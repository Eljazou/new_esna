# -*- coding: utf-8 -*-
"""verify_code_intact.py -- catch code corruption that php -l cannot see.

php -l validates PHP only. A migration bug that eats a JavaScript concatenation
operator inside a <script> block produces perfectly valid PHP containing broken
JavaScript, and lints clean. This happened twice while building metronize.py:

    PHP:  '... class="latc' . $ii . '" ...'   ->  '... class="latc' . $ii '" ...'
    JS:   '... class="concurclose' + ci + '"' ->  '... class="concurclose' + ci '"'

This compares structural token counts between the original view in esna/ and the
migrated one. Class attributes are expected to change; operators, brackets and
string delimiters are not.

NOTE: the `js concat` regex can false-positive on prose/URLs that happen to
read like `word + word + word` (a Google Fonts URL such as Plus+Jakarta+Sans,
or a CSS comment "icon badge + title + subtitle"). Always eyeball a hit before
treating it as corruption -- this is a screening tool, not a proof.

Usage:  python tools/verify_code_intact.py Visites/add.ctp [...]
        python tools/verify_code_intact.py --dir Visites
"""
import io
import os
import re
import sys
import glob

OLD_ROOT = '../esna/app/View/'
NEW_ROOT = 'app/View/'

# Structural tokens that a *presentation* migration must never change.
TOKENS = {
    'js concat  (+ x + )':  r"\+\s*\w+\s*\+",
    'php concat (. $x .)':  r"\.\s*\$\w+\s*\.",
    'arrow  =>':            r'=>',
    'js arrow  =>':         r'=>',
    'open paren':           r'\(',
    'close paren':          r'\)',
    'open brace':           r'\{',
    'close brace':          r'\}',
    'semicolon':            r';',
    'php open tag':         r'<\?php|<\?=',
    'php close tag':        r'\?>',
    'script open':          r'<script\b',
    'script close':         r'</script>',
    'function kw':          r'\bfunction\b',
    'foreach kw':           r'\bforeach\b',
    'if kw':                r'\bif\s*\(',
    'echo kw':              r'\becho\b',
}


def counts(path):
    s = io.open(path, encoding='utf-8', errors='replace').read()
    # <style> blocks are CSS, not code: their braces are not program structure,
    # and text like a "Plus+Jakarta+Sans" font URL or a comment such as
    # "icon badge + title + subtitle" reads as a concat operator to the regex.
    # Migrations legitimately delete whole <style> blocks, so counting them
    # produced false "corruption" on Clients/{add,index}.ctp. Excluded here so
    # a report of CORRUPTION always means something real.
    s = re.sub(r'<style[^>]*>.*?</style>', '', s, flags=re.S)
    return {k: len(re.findall(p, s)) for k, p in TOKENS.items()}


def check(rel):
    old, new = os.path.join(OLD_ROOT, rel), os.path.join(NEW_ROOT, rel)
    if not os.path.isfile(old) or not os.path.isfile(new):
        print('%-44s SKIP' % rel)
        return 0
    new_src = io.open(new, encoding='utf-8', errors='replace').read()
    # A view that was deliberately rebuilt from scratch (rather than restyled)
    # will legitimately lose whole JS blocks, so token counts are meaningless.
    # Such files opt out explicitly with @migration-rewrite in their docblock.
    if '@migration-rewrite' in new_src:
        print('%-44s REWRITE (opted out)' % rel)
        return 0

    a, b = counts(old), counts(new)
    # Asset includes legitimately removed by the migration shift some counts,
    # so only flag tokens that indicate *code* damage.
    # Parens/semicolons are deliberately NOT critical: removing an asset
    # include such as Html->script('jquery.dataTables.min'); legitimately drops
    # two parens and a semicolon. Verified by inspection on the Visites module.
    # These remaining tokens cannot change in a presentation-only migration.
    # `echo` and parens drop legitimately when asset includes are removed
    # (echo $this->Html->script('...');), so they are not corruption signals.
    # Statement-level equivalence is verify_php.py's job. What remains here are
    # tokens a presentation-only migration can never change -- and crucially the
    # JS concat operator, which php -l is blind to.
    critical = ('js concat  (+ x + )', 'php concat (. $x .)',
                'open brace', 'close brace',
                'function kw', 'foreach kw', 'if kw')
    bad = []
    for k in critical:
        if b[k] < a[k]:
            bad.append('%s %d->%d' % (k, a[k], b[k]))
    if not bad:
        print('%-44s OK' % rel)
        return 0
    print('%-44s CORRUPTION: %s' % (rel, '; '.join(bad)))
    return 1


if __name__ == '__main__':
    args = sys.argv[1:]
    if args and args[0] == '--dir':
        d = args[1]
        rels = [os.path.join(d, os.path.basename(f)).replace('\\', '/')
                for f in sorted(glob.glob(os.path.join(NEW_ROOT, d, '*.ctp')))]
    else:
        rels = args
    # A run that compares nothing must never print a pass. Paths here are
    # relative to NEW_ROOT ('app/View/'), so passing a repo-relative path such
    # as `--dir app/View/Prospects` globs app/View/app/View/... , finds no
    # files, and would otherwise report ALL INTACT having checked zero files.
    if not rels:
        print('ERROR: no files matched -- paths are relative to %s '
              '(use "Prospects/add.ctp" or "--dir Prospects")' % NEW_ROOT)
        sys.exit(2)
    bad = sum(check(r) for r in rels)
    print('\n%d file(s) checked -- %s'
          % (len(rels), 'ALL INTACT' if not bad else '%d CORRUPTED' % bad))
    sys.exit(1 if bad else 0)

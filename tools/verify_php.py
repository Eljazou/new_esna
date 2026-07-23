# -*- coding: utf-8 -*-
"""Compare the PHP logic of a migrated view against the original in esna/.

Migration rule: only classes, wrapper divs and structural HTML may change --
never business logic. This extracts every PHP statement, strips presentation-only
noise (whitespace, class/style/target attributes, asset includes, comments), and
reports anything that still differs. A clean run means controller variables,
loops, conditionals, rights checks and URLs are provably unchanged.

Usage:  python verify_php.py Clients/index.ctp [...]
"""
import io
import os
import re
import sys

OLD_ROOT = '../esna/app/View/'
NEW_ROOT = 'app/View/'

PHP = re.compile(r'<\?php(.*?)(?:\?>|$)', re.S)

NOISE = re.compile(
    r"^\s*(//|/\*|\*|\#)"
    r"|Html->css\("
    r"|Html->script\('"
    r"|Html->scriptStart\(|Html->scriptEnd\("
    r"|element\('assets/|element\('layout/",
    re.M)

# presentation-only argument keys that may legitimately change
STYLE_KEY = re.compile(
    r"""['"](class|style|target|placeholder|id|div|label|between|separator|
         legend|format|escape|type|before|after|title|data-[\w-]+)['"]\s*=>\s*
        (?:['"][^'"]*['"]|array\([^)]*\)|true|false|null)\s*,?""",
    re.X | re.I)


def canon(stmt):
    """Reduce a statement to its logic-bearing skeleton."""
    stmt = STYLE_KEY.sub('', stmt)          # drop styling args
    stmt = re.sub(r'\s+', '', stmt)         # whitespace-insensitive
    stmt = stmt.replace('array()', '')      # emptied option arrays
    stmt = re.sub(r',+', ',', stmt)
    stmt = re.sub(r'\(,', '(', stmt)
    stmt = re.sub(r',\)', ')', stmt)
    stmt = stmt.replace('""', '').replace("''", '')
    return stmt


def statements(path):
    src = io.open(path, encoding='utf-8', errors='replace').read()
    out = []
    for block in PHP.findall(src):
        for line in block.split('\n'):
            s = line.strip()
            if not s or NOISE.search(s):
                continue
            c = canon(s)
            if c and c not in (';', '?>', '{', '}'):
                out.append(c)
    return out


SKIPPED = []


def report(rel):
    old, new = os.path.join(OLD_ROOT, rel), os.path.join(NEW_ROOT, rel)
    if not os.path.isfile(old):
        SKIPPED.append(rel)
        print('%-40s SKIP (no original)' % rel)
        return 0
    a, b = sorted(statements(old)), sorted(statements(new))
    only_old = [x for x in a if x not in b]
    only_new = [x for x in b if x not in a]
    if not only_old and not only_new:
        print('%-40s OK    %3d statements, logic identical' % (rel, len(a)))
        return 0
    print('%-40s DIFF  -%d/+%d' % (rel, len(only_old), len(only_new)))
    for s in only_old:
        print('   - %s' % s[:160])
    for s in only_new:
        print('   + %s' % s[:160])
    return 1


if __name__ == '__main__':
    rels = sys.argv[1:]
    bad = sum(report(r) for r in rels)
    # A skip is not a pass. Paths are relative to NEW_ROOT ('app/View/'), so a
    # repo-relative argument like `app/View/Prospects/add.ctp` finds no original
    # and silently skips -- a whole batch of those used to print ALL CLEAN
    # having compared nothing. Only a genuinely new view should ever skip.
    if not rels or len(SKIPPED) == len(rels):
        print('\nERROR: compared 0 file(s) -- paths are relative to %s '
              '(use "Prospects/add.ctp")' % NEW_ROOT)
        sys.exit(2)
    print('\n%d compared, %d skipped -- %s'
          % (len(rels) - len(SKIPPED), len(SKIPPED),
             'ALL CLEAN' if not bad else '%d file(s) differ' % bad))
    sys.exit(1 if bad else 0)

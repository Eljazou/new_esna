# -*- coding: utf-8 -*-
"""scan_concat_damage.py -- exhaustive hunt for eaten concatenation operators.

Written after a real corruption slipped through: an earlier ad-hoc check used a
fixed-width context window (`.{25}...`) to compare occurrences, which silently
skipped matches near a line start. This compares the *multiset* of concat
expressions per file instead, so nothing can hide.

Reports every concat expression present in the esna/ original but missing from
the migrated view. Any output is a real defect.

Usage:  python tools/scan_concat_damage.py            # every migrated module
        python tools/scan_concat_damage.py Clients    # one module
"""
import io
import os
import re
import sys
import glob
from collections import Counter

OLD_ROOT = '../esna/app/View/'
NEW_ROOT = 'app/View/'

# JS:  'a' + x + 'b'      -- plus signs are unambiguous operators
# PHP: 'a' . $x . 'b'      -- the dot form MUST require a $var, otherwise the
#                            dots in filenames ("jquery-2.2.3.min",
#                            "cdn.datatables.net") match and every removed
#                            asset include is reported as damage.
CONCAT = re.compile(r"\+\s*\w+\s*\+|\.\s*\$\w+\s*\.")


def strip_css(s):
    return re.sub(r'<style[^>]*>.*?</style>', '', s, flags=re.S)


def expressions(path):
    s = strip_css(io.open(path, encoding='utf-8', errors='replace').read())
    return Counter(m.group(0).strip() for m in CONCAT.finditer(s))


def scan(module):
    bad = 0
    for new in sorted(glob.glob(os.path.join(NEW_ROOT, module, '*.ctp'))):
        rel = os.path.relpath(new, NEW_ROOT).replace('\\', '/')
        old = os.path.join(OLD_ROOT, rel)
        if not os.path.isfile(old):
            continue
        lost = expressions(old) - expressions(new)
        if lost:
            bad += 1
            print('%-46s LOST %s' % (rel, dict(lost)))
    return bad


if __name__ == '__main__':
    mods = sys.argv[1:] or [d for d in ('Clients', 'Visites', 'Rapports')
                            if os.path.isdir(os.path.join(NEW_ROOT, d))]
    total = 0
    for m in mods:
        print('--- %s ---' % m)
        n = scan(m)
        total += n
        if not n:
            print('  no lost concatenations')
    print('\n%s' % ('ALL CLEAN' if not total else '%d file(s) damaged' % total))
    sys.exit(1 if total else 0)

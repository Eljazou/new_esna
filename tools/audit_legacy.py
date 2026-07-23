# -*- coding: utf-8 -*-
"""audit_legacy.py -- report leftover AdminLTE / Bootstrap 3 markup in views.

Comment-aware: PHP/CSS block comments, HTML comments and JS line comments are
stripped first, so a migration note that merely *mentions* `.box` is not counted
as a leftover.

Usage:  python tools/audit_legacy.py app/View/Visites
"""
import io
import os
import re
import sys
import glob

PATTERNS = {
    'AdminLTE .box':         r'class="[^"]*(?<![-\w])box(?![-\w])[^"]*"',
    # (?![-\w]) so `box-header-custom` / `box-body-content` -- the app's OWN
    # component classes, which are not AdminLTE and must not be renamed -- are
    # not reported as leftovers. Same hyphen-boundary trap that made
    # metronize.py rewrite `small-box-footer` into `small-card-footer`.
    'box-header/body/title': r'class="[^"]*(?<![-\w])box-(header|body|title|footer)(?![-\w])',
    'BS3 panel':             r'class="[^"]*(?<![-\w])panel(-heading|-body|-title|-footer)?(?![-\w])',
    'small-box/info-box':    r'class="[^"]*(small-box|info-box)',
    'AdminLTE colours':      r'class="[^"]*bg-(aqua|green|red|yellow|purple|navy|teal)(?![-\w])',
    'well':                  r'class="[^"]*(?<![-\w])well(?![-\w])',
    'col-xs-*':              r'\bcol-xs-\d',
    'BS3 data-toggle':       r'''\sdata-(toggle|dismiss|target|parent)=['"]''',
    'input-group-addon':     r'input-group-addon',
    'control-label':         r'class="[^"]*control-label',
    'form-horizontal':       r'class="[^"]*form-horizontal',
    'BS3 label-*':           r'class="[^"]*label-(success|danger|warning|info|primary)',
    # Font Awesome 4 (`fa`) AND Font Awesome 5 (`fas`/`far`/`fal`/`fab`). The
    # pattern used to match only the bare `fa` token, so every FA5 icon in the
    # app was invisible to this audit -- including the whole Rapportprocpects
    # sentiment scale, which is served by a licensed kit-pro loader.
    'Font Awesome <i>':      r'<i[^>]*class="[^"]*(?<![-\w])'
                             r'(fa[srlb]?|fa-(solid|regular|light|thin|brands|duotone))'
                             r'(?![-\w])',
    # Font Awesome delivered by CDN <link>/<script>, which the icon pattern
    # above cannot see: site-assets.fontawesome.com (v6) and the licensed
    # kit-pro loader in webroot/js/fontawesome.js. Both are external requests.
    'Font Awesome CDN':      r'(site-assets|kit|use|kit-pro)\.fontawesome\.com'
                             r"|Html->script\(['\"]fontawesome['\"]\)",
    'Ionicons':              r'<i[^>]*class="[^"]*(?<![-\w])ion(?![-\w])',
    'legacy DataTables css': r"Html->css\('dataTables\.bootstrap'\)",
    # jQuery CORE only -- matching bare `code.jquery.com` also flagged
    # code.jquery.com/ui/..., but jQuery UI is a DIFFERENT library that Metronic
    # does not bundle and that several views genuinely use for .datepicker().
    # metronize.py already draws this line; the audit must draw the same one or
    # it reports false positives on every view that legitimately keeps jQuery UI.
    'duplicate jQuery':      r"Html->script\('jquery-[\d.]+min'\)"
                             r"|code\.jquery\.com/jquery-",
    'CSS .box/.panel rule':  r'(?<![-\w])\.(box|panel)(-header|-body|-title|-footer)?(?![-\w])\s*[,{]',
    # AdminLTE widget chrome + Bootstrap 3 float helpers. Added after the Users
    # module revealed these in files earlier audits had passed as clean.
    'AdminLTE small-box':    r'class="[^"]*(?<![-\w])small-box(?![-\w])',
    'AdminLTE box-tools':    r'class="[^"]*(?<![-\w])(box-tools|btn-box-tool|collapsed-box)(?![-\w])',
    'AdminLTE data-widget':  r'\sdata-widget=',
    'BS3 pull-right/left':   r'class="[^"]*(?<![-\w])pull-(right|left)(?![-\w])',
    'AdminLTE description':  r'class="[^"]*(?<![-\w])description-block(?![-\w])',
}


def strip_comments(s):
    s = re.sub(r'/\*.*?\*/', '', s, flags=re.S)     # php / css block
    s = re.sub(r'<!--.*?-->', '', s, flags=re.S)    # html
    s = re.sub(r'^\s*//.*$', '', s, flags=re.M)     # js / php line
    return s


def audit(target):
    files = sorted(glob.glob(os.path.join(target, '*.ctp'))) if os.path.isdir(target) else [target]
    total = 0
    for label, pat in PATTERNS.items():
        hits = []
        for f in files:
            s = strip_comments(io.open(f, encoding='utf-8', errors='replace').read())
            n = len(re.findall(pat, s))
            if n:
                hits.append('%s(%d)' % (os.path.basename(f), n))
        total += len(hits)
        print('%-22s %s' % (label, ' '.join(hits) if hits else 'clean'))
    print('\n%d file(s) scanned -- %s' % (
        len(files), 'ALL CLEAN' if total == 0 else '%d pattern/file combos remain' % total))
    return total


if __name__ == '__main__':
    sys.exit(1 if audit(sys.argv[1] if len(sys.argv) > 1 else 'app/View') else 0)

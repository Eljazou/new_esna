# -*- coding: utf-8 -*-
"""metronize.py -- reusable AdminLTE/Bootstrap-3 -> Metronic 8 view migrator.

Rewrites presentation only. It never touches PHP statements other than the
$options arrays of FormHelper calls and the asset includes it is explicitly
told to replace, so controller variables, loops, conditionals, rights checks
(requestAction) and form actions are preserved verbatim.

Usage:
    python metronize.py app/View/Clients/archive.ctp [...]
Options are per-file and idempotent -- running twice changes nothing.
"""
import io
import re
import sys

# ---------------------------------------------------------------- containers
CLASS_MAP = [
    # AdminLTE box -> Metronic card
    (r'\bbox-header with-border\b', 'card-header'),
    (r'\bbox-header\b', 'card-header'),
    (r'\bbox-body\b', 'card-body'),
    (r'\bbox-footer\b', 'card-footer'),
    (r'\bbox-title\b', 'card-title'),
    (r'\bbox box-primary\b', 'card'),
    (r'\bbox box-default color-palette-box\b', 'card'),
    (r'\bbox box-default\b', 'card'),
    (r'\bbox box-info\b', 'card'),
    (r'\bbox box-warning\b', 'card'),
    (r'\bbox box-danger\b', 'card'),
    (r'\bbox box-success\b', 'card'),
    # Bootstrap 3 panel -> card
    (r'\bpanel panel-(?:default|primary|info|warning|danger|success)\b', 'card'),
    (r'\bpanel-heading\b', 'card-header'),
    (r'\bpanel-body\b', 'card-body'),
    (r'\bpanel-footer\b', 'card-footer'),
    (r'\bpanel-title\b', 'card-title'),
    # buttons
    (r'\bbtn btn-default btn-flat\b', 'btn btn-light'),
    (r'\bbtn btn-default\b', 'btn btn-light'),
    (r'\bbtn-flat\b', ''),
    (r'\bbtn btn-info\b', 'btn btn-info'),
    (r'\bbtn-block\b', 'w-100'),
    # AdminLTE colour helpers -> Bootstrap 5 semantics
    (r'\bbg-aqua\b', 'bg-primary'),
    (r'\bbg-green\b', 'bg-success'),
    (r'\bbg-red\b', 'bg-danger'),
    (r'\bbg-yellow\b', 'bg-warning'),
    (r'\bbg-blue\b', 'bg-primary'),
    (r'\bbg-purple\b', 'bg-primary'),
    (r'\bbg-navy\b', 'bg-dark'),
    (r'\bbg-teal\b', 'bg-info'),
    # BS3 labels -> BS5 badges
    (r'\blabel label-success\b', 'badge badge-light-success'),
    (r'\blabel label-danger\b', 'badge badge-light-danger'),
    (r'\blabel label-warning\b', 'badge badge-light-warning'),
    (r'\blabel label-info\b', 'badge badge-light-info'),
    (r'\blabel label-primary\b', 'badge badge-light-primary'),
    (r'\blabel label-default\b', 'badge badge-light'),
    # forms
    (r'\bcontrol-label\b', 'form-label fw-semibold text-gray-800'),
    (r'\binput-group-addon\b', 'input-group-text'),
    (r'\bform-horizontal\b', ''),
    (r'\bhelp-block\b', 'form-text'),
    # grid: BS3 col-xs-* has no BS5 equivalent prefix
    (r'\bcol-xs-(\d+)\b', r'col-\1'),
    # tables
    (r'\btable table-bordered table-striped display\b',
     'table table-row-bordered table-row-gray-300 align-middle gy-4 gs-4'),
    (r'\btable table-bordered table-striped\b',
     'table table-row-bordered table-row-gray-300 align-middle gy-4'),
    (r'\btable table-bordered\b', 'table table-row-bordered align-middle gy-4'),
    (r'\btable-striped\b', 'table-striped'),
    (r'\btable-responsive-custom\b', 'table-responsive'),
    # misc AdminLTE
    (r'\bwell\b', 'card card-body bg-light'),
    (r'\bcaret\b', ''),
]

# Font Awesome 4 -> Keenicons. Only the icons actually used in this app.
ICON_MAP = {
    'fa-cog': 'ki-setting-3', 'fa-cogs': 'ki-setting-3',
    'fa-plus': 'ki-plus', 'fa-plus-circle': 'ki-plus-circle',
    'fa-minus': 'ki-minus', 'fa-minus-circle': 'ki-minus-circle',
    'fa-edit': 'ki-pencil', 'fa-pencil': 'ki-pencil',
    'fa-trash': 'ki-trash', 'fa-trash-o': 'ki-trash',
    'fa-eye': 'ki-eye', 'fa-search': 'ki-magnifier',
    'fa-user': 'ki-profile-user', 'fa-users': 'ki-people',
    'fa-home': 'ki-home-2', 'fa-calendar': 'ki-calendar-8',
    'fa-file': 'ki-file', 'fa-file-o': 'ki-file',
    'fa-download': 'ki-cloud-download', 'fa-upload': 'ki-cloud-add',
    'fa-print': 'ki-printer', 'fa-check': 'ki-check',
    'fa-times': 'ki-cross', 'fa-close': 'ki-cross',
    'fa-bar-chart': 'ki-chart-simple', 'fa-line-chart': 'ki-chart-line',
    'fa-pie-chart': 'ki-chart-pie-simple', 'fa-map-marker': 'ki-geolocation',
    'fa-phone': 'ki-phone', 'fa-envelope': 'ki-sms',
    'fa-tag': 'ki-tag', 'fa-tags': 'ki-tag',
    'fa-list': 'ki-menu', 'fa-bars': 'ki-burger-menu',
    'fa-arrow-left': 'ki-arrow-left', 'fa-arrow-right': 'ki-arrow-right',
    'fa-refresh': 'ki-arrows-circle', 'fa-save': 'ki-check-circle',
    'fa-info-circle': 'ki-information-5', 'fa-exclamation-triangle': 'ki-information-5',
    'fa-lock': 'ki-lock', 'fa-unlock': 'ki-lock-2',
    'fa-star': 'ki-star', 'fa-clock-o': 'ki-time',
    'fa-archive': 'ki-archive', 'fa-copy': 'ki-copy',
}
# how many <span class="pathN"> each Keenicon needs (duotone layers)
ICON_PATHS = {
    'ki-setting-3': 5, 'ki-profile-user': 4, 'ki-chart-simple': 4,
    'ki-calendar-8': 6, 'ki-people': 5, 'ki-chart-pie-simple': 3,
    'ki-information-5': 3, 'ki-cross-circle': 2, 'ki-check-circle': 2,
    'ki-plus-circle': 2, 'ki-minus-circle': 2, 'ki-geolocation': 2,
    'ki-magnifier': 2, 'ki-trash': 5, 'ki-pencil': 2, 'ki-eye': 3,
    'ki-file': 2, 'ki-sms': 2, 'ki-phone': 2, 'ki-tag': 2, 'ki-lock': 3,
    'ki-lock-2': 4, 'ki-star': 1, 'ki-time': 2, 'ki-archive': 1,
    'ki-copy': 1, 'ki-printer': 5, 'ki-cloud-download': 2,
    'ki-cloud-add': 2, 'ki-home-2': 2, 'ki-burger-menu': 1,
    'ki-arrows-circle': 2, 'ki-chart-line': 1, 'ki-menu': 1,
}


def swap_icons(src):
    def repl(m):
        prefix, name, suffix = m.group(1), m.group(2), m.group(3)
        ki = ICON_MAP.get(name)
        if not ki:
            return m.group(0)
        paths = ''.join('<span class="path%d"></span>' % i
                        for i in range(1, ICON_PATHS.get(ki, 1) + 1))
        extra = (' ' + suffix.strip()) if suffix.strip() else ''
        return '<i class="ki-duotone %s%s">%s</i>' % (ki, extra, paths)

    # <i class="fa fa-cog"></i>  /  <i class="fa fa-cog fs-2"></i>
    return re.sub(r'<i class="(fa\s+)(' + '|'.join(ICON_MAP) + r')([^"]*)"\s*></i>',
                  repl, src)



# A class="..." match whose value contains code-concatenation syntax is not a
# real class list -- it is a fragment of a PHP or JS string being built, e.g.
#     '<span class="concurclose' + ci + '" ...'        (JS)
#     '<input class="latc' . $ii . '" ...'             (PHP)
# Rewriting those eats the + / . operators. Segment-splitting already avoids
# most of these; this is the belt-and-braces guard that makes it impossible.
_CODEY = re.compile(r"""['"]\s*[.+]|[.+]\s*['"]|\$\w|\+\s*\w+\s*\+|<\?""")


def _is_code_fragment(value):
    return bool(_CODEY.search(value))


def _outside_php(src, fn):
    """Apply fn only to the HTML parts of a .ctp, never inside <?php ... ?>.

    Why this exists: a class="..." regex also matches string literals in code.

      PHP:  '<input type="hidden" class="latc' . $ii . '" value="...'
      JS:   '<span class="concurclose' + ci + '" onclick="..."'

    Rewriting those eats the concatenation operators (. in PHP, + in JS) and
    produces a parse error -- and the JS case is invisible to php -l. Splitting
    on <?php ?> AND <script> blocks first makes the rewrite structurally unable
    to touch either language.

    Consequence: markup built inside JS strings is deliberately NOT migrated.
    Run tools/find_js_markup.py to list those spots for manual handling.
    """
    parts = re.split(r'(<\?php.*?\?>|<\?=.*?\?>|<script.*?</script>)', src, flags=re.S)
    for i in range(0, len(parts), 2):      # even indices are the HTML segments
        parts[i] = fn(parts[i])
    return ''.join(parts)


def metronize(src):
    # --- Bootstrap 3/4 data-* attributes -> Bootstrap 5 -------------------
    src = re.sub(r'\bdata-toggle="(modal|dropdown|tab|collapse|tooltip|popover)"',
                 r'data-bs-toggle="\1"', src)
    src = re.sub(r'\bdata-dismiss="(modal|alert)"', r'data-bs-dismiss="\1"', src)
    src = re.sub(r'\bdata-target="', 'data-bs-target="', src)
    src = re.sub(r'\bdata-parent="', 'data-bs-parent="', src)
    src = re.sub(r'\bdata-backdrop="', 'data-bs-backdrop="', src)
    src = re.sub(r'\bdata-slide(-to)?="', r'data-bs-slide\1="', src)

    # --- class rewrites, applied inside class="..." only ------------------
    def fix_class(m):
        val = m.group(1)
        if _is_code_fragment(val):
            return m.group(0)
        for pat, rep in CLASS_MAP:
            val = re.sub(pat, rep, val)
        val = re.sub(r'\s+', ' ', val).strip()
        return 'class="%s"' % val

    src = _outside_php(src, lambda h: re.sub(r'class="([^"]*)"', fix_class, h))

    # Token-level rewrites. Substring regexes are unsafe here: an earlier
    # version turned "search-icon-box" into "search-icon-card". Only whole
    # class names are replaced.
    TOKENS = {
        'box': 'card',
        'panel': 'card',
        'form-group': 'mb-5',
        'well': 'card card-body bg-light',
        'btn-default': 'btn-light',
        'btn-flat': '',
        'caret': '',
        'control-label': 'form-label fw-semibold text-gray-800',
        'input-group-addon': 'input-group-text',
        'table-bordered': 'table-row-bordered',
        'btn-block': 'w-100',
        # AdminLTE leftovers found while migrating Users -- these appear across
        # every module, including ones previously reported clean.
        'small-box': 'card',
        'collapsed-box': '',
        'box-tools': 'card-toolbar',
        'btn-box-tool': 'btn btn-sm btn-icon btn-active-light-primary',
        'description-block': 'd-block',
        # Bootstrap 3 float helpers -> Bootstrap 5
        'pull-right': 'float-end',
        'pull-left': 'float-start',
    }

    def fix_tokens(m):
        if _is_code_fragment(m.group(1)):
            return m.group(0)
        flat = []
        for tok in m.group(1).split():
            flat.extend(TOKENS.get(tok, tok).split())
        seen, out = set(), []
        for t in flat:
            if t and t not in seen:
                seen.add(t)
                out.append(t)
        return 'class="%s"' % ' '.join(out)

    src = _outside_php(src, lambda h: re.sub(r'class="([^"]*)"', fix_tokens, h))


    # --- CSS selectors inside this view's own <style> blocks ------------
    # Markup classes were renamed above; rules still pointing at the old names
    # would silently stop applying (this hit 6 files in the Clients module).
    def fix_style_block(m):
        css = m.group(0)
        for a, b in (('.box-header', '.card-header'), ('.box-body', '.card-body'),
                     ('.box-title', '.card-title'), ('.box-footer', '.card-footer'),
                     ('.panel-heading', '.card-header'), ('.panel-body', '.card-body'),
                     ('.panel-title', '.card-title'), ('.panel-footer', '.card-footer'),
                     ('.input-group-addon', '.input-group-text')):
            css = css.replace(a, b)
        css = re.sub(r'(?<![-\w])\.box(?![-\w])', '.card', css)
        css = re.sub(r'(?<![-\w])\.panel(?![-\w])', '.card', css)
        return css

    src = re.sub(r'<style[^>]*>.*?</style>', fix_style_block, src, flags=re.S)

    # --- icons ------------------------------------------------------------
    src = swap_icons(src)

    # --- BS3 close button inside modals ----------------------------------
    src = re.sub(
        r'<button[^>]*class="close"[^>]*>\s*(?:<span[^>]*>)?[^<]*(?:</span>)?\s*</button>',
        '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>',
        src)

    # --- assets -----------------------------------------------------------
    # legacy DataTables (BS3 skin) -> Metronic bundle, once per file
    had_dt = bool(re.search(r"Html->(css|script)\('(dataTables\.bootstrap|jquery\.dataTables\.min|dataTables\.bootstrap\.min)'\)", src))
    src = re.sub(r"\s*(?:echo\s+)?\$this->Html->css\('dataTables\.bootstrap'\);?", '', src)
    src = re.sub(r"\s*(?:echo\s+)?\$this->Html->script\('jquery\.dataTables\.min'\);?", '', src)
    src = re.sub(r"\s*(?:echo\s+)?\$this->Html->script\('dataTables\.bootstrap\.min'\);?", '', src)
    src = re.sub(r'<\?php\s+echo \$this->Html->css\(\'dataTables\.bootstrap\'\);\?>\s*\n', '', src)

    # jQuery / select2 / bootstrap now come from Metronic's plugins.bundle
    for lib in ('jquery-2.2.3.min', 'jquery-3.4.1.min', 'jquery-1.12.4',
                'select2.full.min', 'bootstrap.min', 'app.min'):
        src = re.sub(r"\s*(?:echo\s+)?\$this->Html->script\('%s'\);?" % re.escape(lib), '', src)
    src = re.sub(r"\s*(?:echo\s+)?\$this->Html->css\('select2\.min'\);?", '', src)

    # CDN duplicates of what Metronic already bundles
    # jQuery CORE only. jQuery UI is a DIFFERENT library, is NOT in Metronic's
    # plugins.bundle, and is required by the .datepicker() calls in several
    # views -- stripping it silently breaks them. Match jquery-<version>.js at
    # the code.jquery.com root, never the /ui/ path.
    src = re.sub(r'\s*<script src="https?://code\.jquery\.com/jquery-[\d.]+(?:\.min)?\.js"></script>', '', src)
    src = re.sub(r'\s*<script src="//?cdn\.datatables\.net/[^"]*"></script>', '', src)
    src = re.sub(r'\s*<script src="https?://cdn\.datatables\.net/[^"]*"></script>', '', src)
    src = re.sub(r'\s*<script src="//?cdnjs\.cloudflare\.com/ajax/libs/jszip/[^"]*"></script>', '', src)
    src = re.sub(r'\s*<script src="//?cdn\.rawgit\.com/bpampuch/pdfmake/[^"]*"></script>', '', src)

    # tidy empty php tags left behind
    src = re.sub(r'<\?php\s*\?>\s*\n', '', src)
    return src, had_dt


def process(path):
    src = io.open(path, encoding='utf-8').read()
    out, had_dt = metronize(src)
    if had_dt and "element('assets/datatables')" not in out:
        out = "<?php echo $this->element('assets/datatables'); ?>\n" + out
    if out != src:
        io.open(path, 'w', encoding='utf-8', newline='').write(out)
        print('metronized %s%s' % (path, '  (+datatables element)' if had_dt else ''))
    else:
        print('unchanged  %s' % path)


if __name__ == '__main__':
    for p in sys.argv[1:]:
        process(p)

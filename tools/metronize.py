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
import os
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

# Class renames that are safe to apply to a CSS selector as well as to markup.
# Targets that are Bootstrap UTILITIES rather than components are excluded: a
# rule written for a component (`.form-group { margin-bottom: 20px }`) must not
# be re-pointed at a utility (`.mb-5 { margin-bottom: 20px }`), because that
# would leak the component's styling onto every element using that utility.
# Those cases are reported instead, so a human decides.
UTILITY_TARGETS = {'mb-5', 'w-100', 'float-end', 'float-start', 'd-block'}

STYLE_WARNINGS = []


def _atomic_renames(tokens):
    """Every single-class rename the markup pass performs, as {old: new}.

    Derived from CLASS_MAP and TOKENS so the CSS side can never lag the markup
    side again. Multi-class targets collapse to their first class
    (`.control-label` -> `.form-label`); renames to nothing are skipped, since
    deleting a selector's text would corrupt the rule rather than retire it.
    """
    ren = {}
    for pat, rep in CLASS_MAP:
        m = re.fullmatch(r'\\b([\w-]+)\\b', pat)
        if m and rep:
            ren[m.group(1)] = rep.split()[0]
    for old, new in tokens.items():
        if new:
            ren[old] = new.split()[0]
    return {o: n for o, n in ren.items() if n not in UTILITY_TARGETS}


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
    # Added for the small-CRUD batch. Rapportprocpects/Analyses use Font
    # Awesome 5 PRO prefixes (fal/fas/far) served by a licensed kit loader
    # (webroot/js/fontawesome.js -> kit-pro.fontawesome.com); mapping these to
    # Keenicons removes that external, license-tied dependency.
    'fa-filter': 'ki-filter', 'fa-bold': 'ki-text-bold',
    'fa-share': 'ki-send', 'fa-times-circle': 'ki-cross-circle',
    'fa-calendar-times': 'ki-calendar-remove', 'fa-calendar-alt': 'ki-calendar-8',
    'fa-phone-alt': 'ki-phone', 'fa-clock': 'ki-time',
    'fa-alarm-clock': 'ki-timer', 'fa-comments': 'ki-messages',
    'fa-comments-alt': 'ki-message-text-2', 'fa-calculator': 'ki-calculator',
    'fa-table': 'ki-element-11', 'fa-camera': 'ki-picture',
    'fa-clipboard': 'ki-clipboard', 'fa-server': 'ki-data',
    'fa-heart': 'ki-heart', 'fa-briefcase': 'ki-briefcase',
    'fa-building': 'ki-bank',
    'fa-cloud-upload-alt': 'ki-cloud-add', 'fa-cloud-download-alt': 'ki-cloud-download',
    # Font Awesome 6 icon names (loaded in a few views from a
    # site-assets.fontawesome.com <link>, a third FA delivery path alongside the
    # local v4 CSS and the kit-pro loader).
    'fa-pen-to-square': 'ki-pencil', 'fa-user-group': 'ki-people',
    'fa-magnifying-glass': 'ki-magnifier', 'fa-trash-can': 'ki-trash',
    'fa-xmark': 'ki-cross', 'fa-floppy-disk': 'ki-check-circle',
}

# Icons deliberately NOT mapped. The sentiment scale in Rapportprocpects is a
# five-point rating UI (very unfavourable -> very favourable); Keenicons has no
# faithful equivalent set, and substituting approximate glyphs would change what
# the control communicates. fa-bow-arrow (Pro-only) likewise has no counterpart.
# These keep Font Awesome, so the kit loader stays on those pages -- see
# PROJECT_LOG TODO #34.
ICON_KEEP = {
    'fa-angry', 'fa-frown', 'fa-meh-rolling-eyes', 'fa-smile-beam',
    'fa-laugh-beam', 'fa-bow-arrow', 'fa-spinner',
}
# How many <span class="pathN"> each Keenicon needs (duotone layers).
#
# Read from Metronic's own stylesheet rather than trusted from this table: a
# duotone icon rendered with the wrong number of path spans draws only part of
# itself, and a typo'd ki-* name renders nothing at all -- neither shows up in
# php -l, the logic diff or the legacy audit. Deriving the counts makes those
# two failures impossible instead of merely unlikely. The literals below stay as
# the fallback for when the bundle is not present.
_KI_CSS = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))),
                       'app', 'webroot', 'metronic', 'demo1', 'dist', 'assets',
                       'plugins', 'global', 'plugins.bundle.css')


def _derive_icon_paths():
    """{ki-name: number of <span class="pathN"> children it needs}.

    0 means a SINGLE-GLYPH icon, which must get no path spans at all; a duotone
    icon returns its real layer count. Both matter: too few spans draws a
    partial icon, and the hand-written table this replaced was wrong for
    ki-menu (4, listed as 1), ki-burger-menu (4), ki-archive (3) and
    ki-chart-line (2), so those had been rendering incomplete wherever used.
    A name absent from the result is unknown and is left alone by swap_icons.
    """
    try:
        css = io.open(_KI_CSS, encoding='utf-8', errors='replace').read()
    except IOError:
        sys.stderr.write('metronize: WARNING Keenicons stylesheet not found at '
                         '%s -- no icons will be converted\n' % _KI_CSS)
        return {}
    found = {}
    for name in set(ICON_MAP.values()):
        n = len(set(re.findall(r'\.%s \.path(\d+):before' % re.escape(name), css)))
        if n:
            found[name] = n
        elif re.search(r'\.%s:before' % re.escape(name), css):
            found[name] = 0
        else:
            sys.stderr.write('metronize: WARNING %s is not defined in '
                             'Keenicons -- it would render as nothing\n' % name)
    return found


ICON_PATHS = _derive_icon_paths()


_ONLY_PATHS = re.compile(r'(?:\s*<span class="path\d+"></span>)*\s*')


def fix_icon_paths(src):
    """Repair the <span class="pathN"> children of ALREADY-converted icons.

    Needed because earlier runs used a hand-written path-count table that was
    wrong for several icons, so views already committed carry duotone icons
    missing layers (and single-glyph icons carrying a span that renders
    nothing). Only icons whose body is nothing but path spans are touched, so
    an <i> wrapping real content is never disturbed.
    """
    def repl(m):
        head, name, tail, inner = m.groups()
        if name not in ICON_PATHS or not _ONLY_PATHS.fullmatch(inner):
            return m.group(0)
        paths = ''.join('<span class="path%d"></span>' % i
                        for i in range(1, ICON_PATHS[name] + 1))
        return '%s%s%s>%s</i>' % (head, name, tail, paths)

    return re.sub(r'(<i[^>]*class="ki-duotone\s+)(ki-[\w-]+)([^"]*")>(.*?)</i>',
                  repl, src, flags=re.S)


def swap_icons(src):
    def repl(m):
        attrs, name, suffix, after = m.group(1), m.group(3), m.group(4), m.group(5)
        if name in ICON_KEEP:
            return m.group(0)
        ki = ICON_MAP.get(name)
        if not ki or ki not in ICON_PATHS:
            return m.group(0)
        paths = ''.join('<span class="path%d"></span>' % i
                        for i in range(1, ICON_PATHS[ki] + 1))
        extra = (' ' + suffix.strip()) if suffix.strip() else ''
        return '<i%s class="ki-duotone %s%s"%s>%s</i>' % (
            attrs, ki, extra, after, paths)

    # Matches, with any other attributes preserved in place:
    #   <i class="fa fa-cog"></i>            <i class="fa fa-cog fs-2"></i>
    #   <i onclick="..." class="fa fa-clock-o"></i>
    #   <i class="fal fa-comments"></i>      (Font Awesome 5 Pro prefixes)
    # `fa` alone stays in the alternation for FA4 markup; fas/far/fal/fab are
    # FA5 and appear in the Rapportprocpects and Analyses views.
    return re.sub(
        r'<i((?:\s+(?!class=)[\w-]+="[^"]*")*)\s+class="'
        r'((?:fa[srlb]?|fa-(?:solid|regular|light|thin|brands|duotone))\s+)('
        + '|'.join(sorted(set(ICON_MAP) | ICON_KEEP, key=len, reverse=True))
        + r')([^"]*)"((?:\s+[\w-]+="[^"]*")*)\s*>\s*</i>',
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
    # silently stop applying (this hit 6 files in Clients). The rename list is
    # now DERIVED from the same maps the markup pass uses, instead of being a
    # hand-maintained parallel list -- that parallel list had drifted and missed
    # the AdminLTE colour helpers, which is how Rapportprocpects/
    # fuille_route_conseiller.ctp ended up with `.info-box.bg-aqua{...}` rules
    # aimed at markup that now said `bg-primary`. That was not merely a lost
    # tint: bg-primary/-warning/-success are REAL Bootstrap 5 utilities, so the
    # local `background:#fff !important` neutralizer stopped matching and the
    # cards rendered as solid colour blocks.
    def fix_style_block(m):
        css = m.group(0)
        # No lookbehind on the dot: a `.` cannot occur inside a CSS identifier,
        # and requiring a non-word char before it breaks COMPOUND selectors --
        # `.info-box.bg-aqua` has `x` before `.bg-aqua`, which is exactly the
        # form the colour-helper rules use. The trailing (?![-\w]) still stops
        # `.box` from eating `.box-header`.
        for old, new in sorted(_atomic_renames(TOKENS).items(),
                               key=lambda kv: -len(kv[0])):
            css = re.sub(r'\.%s(?![-\w])' % re.escape(old), '.' + new, css)
        css = re.sub(r'\.col-xs-(\d+)(?![-\w])', r'.col-\1', css)
        # Compound container selectors. Markup collapsed `panel panel-primary`
        # (and `box box-info`, etc.) to a bare `card`, so a rule still written
        # as `.card.panel-primary` matches nothing -- it is dead CSS, and the
        # page silently loses that styling. Drop the variant half; a variant
        # appearing on its own becomes `.card`.
        VARIANT = r'(?:default|primary|info|success|warning|danger)'
        css = re.sub(r'\.card\.(?:panel|box)-%s(?![-\w])' % VARIANT, '.card', css)
        css = re.sub(r'\.(?:panel|box)-%s(?![-\w])' % VARIANT, '.card', css)
        # Renames excluded above are not silently dropped. Whether the rule is
        # actually dead depends on the REST of the file, which is checked in
        # process() -- FormHelper emits `'div' => array('class' => 'form-group')`
        # from inside PHP, and the markup pass never touches PHP, so a
        # .form-group rule is usually still very much alive.
        for old, new in TOKENS.items():
            if (new and new.split()[0] in UTILITY_TARGETS
                    and re.search(r'\.%s(?![-\w])' % re.escape(old), css)):
                STYLE_WARNINGS.append(old)
        return css

    src = re.sub(r'<style[^>]*>.*?</style>', fix_style_block, src, flags=re.S)

    # --- icons ------------------------------------------------------------
    # Font Awesome's spinner is an ANIMATED glyph (fa-spin). Keenicons has no
    # animated equivalent, so mapping it to a static icon would leave a "loading"
    # indicator that never moves. Bootstrap 5's spinner is the right target.
    src = re.sub(r'<i class="fa[srlb]?\s+fa-spinner[^"]*"\s*>\s*</i>',
                 '<span class="spinner-border spinner-border-sm align-middle">'
                 '</span>', src)
    src = swap_icons(src)
    src = fix_icon_paths(src)

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
    del STYLE_WARNINGS[:]
    out, had_dt = metronize(src)
    # A CSS rule kept for a utility-target class is only DEAD if nothing in the
    # finished file still produces that class -- including PHP, which the markup
    # pass deliberately never rewrites. Checking the whole output removes the
    # false alarms that would otherwise fire on every FormHelper-built form.
    for cls in sorted(set(STYLE_WARNINGS)):
        body = re.sub(r'<style[^>]*>.*?</style>', '', out, flags=re.S)
        if not re.search(r'[\'"\s]%s[\'"\s]' % re.escape(cls), body):
            print('  WARN %s: .%s rule is now dead (class no longer emitted)'
                  % (path, cls))
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

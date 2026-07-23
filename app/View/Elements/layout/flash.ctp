<?php
/**
 * Flash messages, rendered as Metronic / Bootstrap 5 alerts.
 *
 * Rendered by the layout via: $this->element('layout/flash');
 *
 * WHY THIS EXISTS
 * ---------------
 * CakePHP 2's SessionHelper::flash() hardcodes its output for the 'default'
 * element -- it always emits:
 *
 *     <div id="flashMessage" class="message">...</div>
 *
 * and, unlike other elements, creating an Elements/default.ctp does NOT
 * override it. Of the 417 setFlash() calls in app/Controller, 345 pass only a
 * message (so they land on that plain markup) and a handful pass an explicit
 * array('class' => 'alert alert-success'|'alert alert-danger').
 *
 * The previous layout coped by rewriting the markup with jQuery on
 * $(window).load() -- which meant the raw, unstyled message was painted first
 * and only became an alert once every asset had finished downloading.
 *
 * This element instead post-processes the helper's output server-side: no
 * flash-of-unstyled-content, no jQuery dependency, and -- importantly -- no
 * changes to any controller. Business logic is untouched; setFlash() calls
 * keep working exactly as they are.
 *
 * SEVERITY MAPPING (deliberately identical to the old JS, so behaviour does
 * not change):
 *   #flashMessage -> success     #authMessage -> danger
 * An explicit alert-* class supplied by the controller always wins.
 */

$blocks = array(
    // session key => default severity when the controller gave no class
    'flash' => 'success',
    'auth'  => 'danger',
);

$icons = array(
    'success' => 'ki-check-circle',
    'danger'  => 'ki-cross-circle',
    'warning' => 'ki-information-5',
    'info'    => 'ki-information-5',
    'primary' => 'ki-information-5',
);

foreach ($blocks as $key => $severity) {
    if (!$this->Session->check('Message.' . $key)) {
        continue;
    }

    // Render through the helper so any element/params a controller passed are
    // still honoured, then inspect what came back.
    $raw = $this->Session->flash($key);
    if (trim($raw) === '') {
        continue;
    }

    // An explicit severity from the controller takes precedence.
    if (preg_match('/alert-(success|danger|warning|info|primary)/', $raw, $m)) {
        $severity = $m[1];
    }

    // Pull the message text out of Cake's wrapper div. If the controller used
    // a custom element the output may be arbitrary markup -- in that case fall
    // back to echoing it untouched rather than mangling it.
    if (preg_match('#^\s*<div[^>]*id="' . $key . 'Message"[^>]*>(.*)</div>\s*$#s', $raw, $m)) {
        $message = trim($m[1]);
    } else {
        echo $raw;
        continue;
    }

    $icon = isset($icons[$severity]) ? $icons[$severity] : 'ki-information-5';
    ?>
    <div id="<?php echo h($key); ?>Message"
         class="alert alert-<?php echo h($severity); ?> d-flex align-items-center flex-wrap p-5 mb-6"
         role="alert">
        <i class="ki-duotone <?php echo h($icon); ?> fs-2hx me-4">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
        </i>
        <div class="d-flex flex-column flex-grow-1 pe-0 pe-sm-10">
            <span class="fw-semibold"><?php echo $message; ?></span>
        </div>
        <button type="button" class="btn btn-icon btn-sm btn-active-light-<?php echo h($severity); ?> ms-auto"
                data-bs-dismiss="alert" aria-label="Fermer">
            <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
        </button>
    </div>
    <?php
}

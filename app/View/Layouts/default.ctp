<?php ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CRM VMP</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <?php
    // ---------------------------------------------------------------------
    // Stylesheets. Order matters:
    //   1. Metronic plugins   (also declares the Keenicons @font-face)
    //   2. Metronic core theme
    //   3. Font Awesome 4.5.0 — LOCAL copy, kept only for the legacy `fa-*`
    //      icons still present in un-migrated views. Remove this line once
    //      the last `fa-` class is gone (see PROJECT_LOG TODO #11).
    //   4. esna-theme.css — the ESNAPHARM purple/Poppins brand layer. MUST
    //      stay last so its overrides beat Metronic's defaults.
    // Flatpickr's CSS is already inside plugins.bundle.css, so it is not
    // loaded separately any more.
    // ---------------------------------------------------------------------
    echo $this->Html->css('/metronic/demo1/dist/assets/plugins/global/plugins.bundle');
    echo $this->Html->css('/metronic/demo1/dist/assets/css/style.bundle');
    echo $this->Html->css('font-awesome.min');
    echo $this->Html->css('esna-theme');

    // Per-view stylesheets injected via $this->Html->css(..., array('block' => 'css'))
    echo $this->fetch('css');

    // ---------------------------------------------------------------------
    // Metronic's global plugin bundle ships jQuery, Select2, flatpickr and
    // daterangepicker. It is loaded HERE, once, in <head>, for two reasons:
    //   * every view's inline <script> can rely on $ being defined, which is
    //     why the previous author hoisted a second jQuery into <body>;
    //   * loading it once removes the duplicate jQuery that used to detach
    //     plugins registered against the first instance.
    // Only Metronic's own UI bundle (scripts.bundle.js) stays at the bottom,
    // because it binds to DOM that must exist first.
    // ---------------------------------------------------------------------
    echo $this->Html->script('/metronic/demo1/dist/assets/plugins/global/plugins.bundle');
    echo $this->Html->script('flatpickr-fr');
    ?>

    <!-- Brand theme moved to webroot/css/esna-theme.css (loaded above). -->
</head>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">

    <?php
    // jquery-2.2.3.min used to be loaded here, on top of the jQuery already
    // inside plugins.bundle.js. Two instances meant the second one replaced
    // window.$/window.jQuery and silently detached every plugin registered
    // against the first (Select2 in particular). plugins.bundle.js now loads
    // once in <head>, so jQuery is available to view scripts without the
    // duplicate. See PROJECT_LOG TODO #10.
    ?>

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

            <!-- ================= HEADER ================= -->
            <?php echo $this->element('layout/topbar'); ?>
            <!-- ================= /HEADER ================= -->

            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                <!-- ================= SIDEBAR ================= -->
                <?php echo $this->element('layout/sidebar'); ?>
                <!-- ================= /SIDEBAR ================= -->

                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <div class="app-content flex-column-fluid" id="kt_app_content">
                            <div class="app-container container-fluid" id="kt_app_content_container">
                                <?php
                                echo $this->element('layout/flash');
                                echo $this->fetch('content');
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php echo $this->element('layout/footer'); ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->element('layout/chat_ia'); ?>
    <?php
    // jQuery, Select2, flatpickr and daterangepicker were all loaded once in
    // <head> via plugins.bundle.js — it is deliberately NOT repeated here.
    // Only Metronic's UI bundle (menu, drawer, modal, sticky, scroll) loads
    // at the bottom, as Metronic's own docs expect, because it binds to DOM
    // that must already exist.
    echo $this->Html->script('/metronic/demo1/dist/assets/js/scripts.bundle');

    // Per-view scripts injected via $this->Html->script(..., array('block' => 'script'))
    echo $this->fetch('script');
    ?>
</body>
<script>
    // The $(window).load() handler that used to live here rewrote #flashMessage
    // and #authMessage into Bootstrap alerts on the client. Flash messages are
    // now rendered as Metronic alerts server-side by Elements/layout/flash.ctp,
    // so the handler has been removed: it would have overwritten that markup
    // (and it only ran once every asset had finished loading, which is why the
    // raw message used to flash unstyled first). Severity mapping is unchanged
    // — flash => success, auth => danger.

    function searchmenu(va) {
        var v = va.toLowerCase();
        var menu = document.getElementById("menu");
        var items = menu.querySelectorAll('.menu-item');
        items.forEach(function (item) {
            var text = item.innerText.toLowerCase();
            item.style.display = text.indexOf(v) !== -1 || v === "" ? "" : "none";
        });
    }

    // Compat shim: several older views still use Bootstrap 3/4 modal/dropdown
    // attributes (data-toggle / data-target / data-dismiss). Metronic ships
    // Bootstrap 5, which renamed these to data-bs-*, so the old attributes get
    // silently ignored. This delegated listener makes the legacy attributes
    // work again, app-wide, without having to edit every .ctp view that still
    // uses them.
    document.addEventListener('click', function (e) {
        var opener = e.target.closest('[data-toggle="modal"]');
        if (opener) {
            var targetSelector = opener.getAttribute('data-target');
            var modalEl = targetSelector ? document.querySelector(targetSelector) : null;
            if (modalEl) {
                e.preventDefault();
                if (window.bootstrap && bootstrap.Modal) {
                    bootstrap.Modal.getOrCreateInstance(modalEl).show();
                }
                return;
            }
        }

        var closer = e.target.closest('[data-dismiss="modal"]');
        if (closer) {
            var openModal = closer.closest('.modal');
            if (openModal) {
                if (window.bootstrap && bootstrap.Modal) {
                    var instance = bootstrap.Modal.getInstance(openModal);
                    if (instance) {
                        e.preventDefault();
                        instance.hide();
                    }
                }
            }
        }

        var dropdownOpener = e.target.closest('[data-toggle="dropdown"]');
        if (dropdownOpener) {
            e.preventDefault();
            if (window.bootstrap && bootstrap.Dropdown) {
                var dropdownInstance = bootstrap.Dropdown.getOrCreateInstance(dropdownOpener);
                dropdownInstance.toggle();
                return;
            }

            if (window.jQuery && $.fn.dropdown) {
                $(dropdownOpener).dropdown('toggle');
                return;
            }

            var $menu = $(dropdownOpener).next('.dropdown-menu');
            if (!$menu.length) {
                $menu = $(dropdownOpener).siblings('.dropdown-menu');
            }

            if (!$menu.length) {
                return;
            }

            var isOpen = $(dropdownOpener).attr('aria-expanded') === 'true';
            if (isOpen) {
                $menu.hide();
                $(dropdownOpener).attr('aria-expanded', 'false');
            } else {
                $menu.show();
                $(dropdownOpener).attr('aria-expanded', 'true');
            }
        }
    });

    // Mirror all remaining legacy data-toggle attributes (tab, tooltip, collapse, etc.)
    // to data-bs-toggle on page load, in case any BS5-native init relies on them.
    // Also restore the Bootstrap 5 dropdown wrapper class on legacy button-groups.
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-toggle]').forEach(function (el) {
            if (!el.hasAttribute('data-bs-toggle')) {
                el.setAttribute('data-bs-toggle', el.getAttribute('data-toggle'));
            }
            if (el.getAttribute('data-toggle') === 'dropdown') {
                var parent = el.closest('.btn-group, .dropdown');
                if (parent && !parent.classList.contains('dropdown')) {
                    parent.classList.add('dropdown');
                }
            }
        });

        if (window.flatpickr) {
            document.querySelectorAll('input.datepicker, input.flatpickr, input[data-datepicker], input[name*="date"], input[id*="date"]').forEach(function (el) {
                if (el.getAttribute('data-flatpickr-init') === '1' || el.type === 'date') {
                    return;
                }

                if (el.readOnly || el.disabled) {
                    return;
                }

                flatpickr(el, {
                    locale: 'fr',
                    dateFormat: 'Y-m-d',
                    allowInput: true
                });

                el.setAttribute('data-flatpickr-init', '1');
            });
        }
    });
</script>

<!-- Script pour gérer le chat IA -->
<script>
    $(function () {
        $('#open-chat-ia').click(function () {
            var modalEl = document.getElementById('chat-ia-modal');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });

        $('#ia-chat-form').submit(function (e) {
            e.preventDefault();

            var message = $('#ia-chat-input').val();
            if (message.trim() === '') return;

            appendUserMessage(message);
            $('#ia-chat-input').val('');

            var contentHeaderHtml = "<?php $d = $this->viewVars;
            unset($d["content_for_layout"]);
            echo addslashes(json_encode($d)); ?>";

            $.ajax({
                url: '<?php echo $this->Html->url(["controller" => "iaservices", "action" => "system_askia"]); ?>',
                type: 'POST',
                data: {
                    message: message,
                    html: contentHeaderHtml
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#ia-chat-messages').append(
                        '<div class="text-center" id="ia-loading"><i class="fa fa-spinner fa-spin"></i> En attente de réponse...</div>'
                    );
                    scrollChatToBottom();
                },
                success: function (response) {
                    $('#ia-loading').remove();
                    appendIAMessage(response.message || "Désolé, je n'ai pas pu traiter votre demande.");
                },
                error: function () {
                    $('#ia-loading').remove();
                    appendIAMessage("Désolé, une erreur est survenue. Veuillez réessayer plus tard.");
                }
            });
        });

        function appendUserMessage(message) {
            var now = new Date();
            var timeStr = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();

            var userMessageHtml = `
      <div class="d-flex flex-column align-items-end mb-3">
        <div class="d-flex justify-content-between w-100">
          <span class="text-muted fs-8">${timeStr}</span>
          <span class="fw-bold">Vous</span>
        </div>
        <div>${escapeHtml(message)}</div>
      </div>
    `;

            $('#ia-chat-messages').append(userMessageHtml);
            scrollChatToBottom();
        }

        function appendIAMessage(message) {
            var now = new Date();
            var timeStr = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();

            var iaMessageHtml = `
      <div class="d-flex flex-column mb-3">
        <div class="d-flex justify-content-between">
          <span class="fw-bold">IA Assistant</span>
          <span class="text-muted fs-8">${timeStr}</span>
        </div>
        <div>${escapeHtml(message)}</div>
      </div>
    `;

            $('#ia-chat-messages').append(iaMessageHtml);
            scrollChatToBottom();
        }

        function scrollChatToBottom() {
            var chatContainer = document.getElementById('ia-chat-messages');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;")
                .replace(/\n/g, "<br>");
        }
    });
</script>

</html>
<?php //echo $this->element('sql_dump');   ?>

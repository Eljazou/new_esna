<?php
/**
 * `mobile` layout — the visit-report forms opened inside the native phone app's
 * webview (Appweb, Appwebfinal, Appwebfinalv2, Visitemobileapis).
 *
 * Migrated off Bootstrap 3 + AdminLTE 2. Deliberately NOT rebuilt on Metronic:
 * this is a phone surface, and Metronic's core bundles total ~4.4 MB against
 * ~890 KB here. It gets plain Bootstrap 5 plus the Font Awesome Pro 6 the mobile
 * app already vendors (webroot/css/all.css) — see PROJECT_LOG §7, Option B.
 *
 * REMOVED
 *   - bootstrap.css (3.3.6), style.min.css + skin-blue.min.css (AdminLTE),
 *     bootstrap.min.js (BS3), app.min.js (AdminLTE)
 *   - Font Awesome 4.5.0 and Ionicons 2.0.1 CDN links. Both were external
 *     requests; FA 6 Pro is local and supersedes the first. Ionicons was never
 *     used by any view on this layout.
 *   - the html5shiv / respond.js IE8 conditional comments
 *   - the $(window).load() handler that rewrote #flashMessage into a Bootstrap
 *     alert on the client. Flash is now rendered server-side by
 *     Elements/layout/flash.ctp, exactly as on the desktop layout. No view on
 *     this layout referenced #flashMessage.
 *   - searchmenu(), which drove a sidebar this layout has never contained.
 *
 * KEPT ON PURPOSE
 *   - `.content-wrapper` / `.content-header`. The class names came from
 *     AdminLTE, but seven views now supply their OWN rules for them (centring,
 *     padding, background) — they are a layout/view contract, and dropping them
 *     would silently un-style those pages.
 *   - jQuery 2.2.3. The views make heavy use of `$(...)`; none of them use
 *     jQuery-2-only idioms, so 3.x would probably work, but "probably" is not
 *     worth it on views nobody can render yet. See PROJECT_LOG TODO #46.
 *   - the loading overlay and its `.btn_spiner` trigger, used by 10 views.
 *   - the viewport, verbatim (it blocks pinch-zoom; that is pre-existing
 *     behaviour of the app shell, not something to change while restyling).
 */
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CRM VMP</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php
    echo $this->Html->css('bootstrap5.min');
    echo $this->Html->css('all');
    echo $this->fetch('css');
    ?>
    <style>
        /*  loading style */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        .loading-spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body>
    <div class="content-wrapper">
        <section class="content-header">
            <?php
            echo $this->element('layout/flash');
            echo $this->fetch('content');
            ?>
        </section>
        <section class="content">
        </section>
    </div>
    <footer class="main-footer text-muted small border-top py-3 px-3">
        <div class="float-end d-none d-sm-block">
            CRM VMP
        </div>
        <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="#">ICOZ</a>.</strong> All rights reserved.
    </footer>
    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>
    <?php
    echo $this->Html->script('jquery-2.2.3.min');
    echo $this->Html->script('bootstrap5.bundle.min');
    echo $this->fetch('script');
    ?>
    <script>
        $(document).ready(function() {
            $(".btn_spiner").on("click", function() {
                $("#loading-overlay").css('display', 'flex');
            });
        });
    </script>
</body>

</html>

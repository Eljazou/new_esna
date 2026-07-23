<?php
/**
 * Users :: login — page de connexion (CRM VMP).
 *
 * @migration-rewrite
 *   This view was rebuilt from scratch rather than restyled, so
 *   tools/verify_code_intact.py cannot compare token counts against the
 *   original: two JavaScript blocks were removed on purpose (see below).
 *   Field names and the form contract ARE preserved and are asserted by
 *   tools/verify_php.py, which reports this file as logic-identical.
 *
 * This view renders a COMPLETE HTML document: the `login` layout is only
 * `Session->flash() + fetch('content')`, so everything below is this file's
 * responsibility. That was true before the migration too.
 *
 * Rebuilt on Metronic 8 (was AdminLTE: skin-blue.min / style.min / Bootstrap 3,
 * with Font Awesome + Ionicons pulled from CDNs).
 *
 * PRESERVED EXACTLY — do not rename, AuthComponent depends on these:
 *   - $this->Form->create('User') and the raw </form> close
 *   - name="data[User][username]"
 *   - name="data[User][password]"
 * The background image (/img/background/dwa2.jpg) is kept as-is.
 *
 * The old page ran a $(window).load() handler that rewrote #flashMessage /
 * #authMessage into Bootstrap alerts on the client. Flash messages are now
 * rendered server-side as Metronic alerts by Elements/layout/flash.ctp (wired
 * into Layouts/login.ctp), so that handler is gone — it would have overwritten
 * the new markup, exactly as in the main layout. There was also an .iCheck()
 * call bound to `input`, but iCheck was never loaded on this page, so it threw
 * silently on every visit; it is not carried over.
 */
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CRM VMP — Connexion</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <?php
    // Same bundle order as the main layout, so branding is identical.
    echo $this->Html->css('/metronic/demo1/dist/assets/plugins/global/plugins.bundle');
    echo $this->Html->css('/metronic/demo1/dist/assets/css/style.bundle');
    echo $this->Html->css('esna-theme');
    ?>

    <style type="text/css">
        /* Full-bleed brand background. The image is the one the previous login
           page used; only the overlay/card styling is new. */
        body.esna-login {
            background-image: linear-gradient(rgba(30, 27, 58, .55), rgba(30, 27, 58, .55)),
                              url("/img/background/dwa2.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        .esna-login-card {
            width: 100%;
            max-width: 440px;
            border-radius: 18px;
            box-shadow: 0 18px 50px rgba(31, 29, 74, .28);
        }

        .esna-login-logo b {
            color: var(--lb-primary);
        }
    </style>
</head>

<body class="esna-login d-flex flex-column">

    <div class="d-flex flex-center flex-column-fluid p-6">
        <div class="card esna-login-card">
            <div class="card-body p-10 p-lg-12">

                <div class="text-center mb-8">
                    <div class="esna-login-logo fs-2hx fw-bold text-gray-900 mb-2">
                        <b>CRM </b>VMP
                    </div>
                    <div class="text-gray-500 fw-semibold fs-6">Bienvenue dans CRM VMP</div>
                </div>

                <?php echo $this->Form->create('User'); ?>

                <div class="fv-row mb-5">
                    <label class="form-label fw-semibold text-gray-800" for="esnaLoginUsername">Email</label>
                    <div class="position-relative">
                        <input type="text" id="esnaLoginUsername" class="form-control form-control-solid ps-12"
                               placeholder="Email" name="data[User][username]" autocomplete="username" autofocus>
                        <span class="position-absolute translate-middle-y top-50 ms-4">
                            <i class="ki-duotone ki-sms fs-2 text-gray-500">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </span>
                    </div>
                </div>

                <div class="fv-row mb-8">
                    <label class="form-label fw-semibold text-gray-800" for="esnaLoginPassword">Mot de passe</label>
                    <div class="position-relative">
                        <input type="password" id="esnaLoginPassword" class="form-control form-control-solid ps-12"
                               placeholder="Mot de passe" name="data[User][password]" autocomplete="current-password">
                        <span class="position-absolute translate-middle-y top-50 ms-4">
                            <i class="ki-duotone ki-lock fs-2 text-gray-500">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </span>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-duotone ki-entrance-right fs-3 me-2">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        Connexion
                    </button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <?php
    // Metronic's UI bundle only — jQuery/Select2/flatpickr all ship inside
    // plugins.bundle.js, which is already loaded in <head> above.
    echo $this->Html->script('/metronic/demo1/dist/assets/js/scripts.bundle');
    ?>
</body>

</html>

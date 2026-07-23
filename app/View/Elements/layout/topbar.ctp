<?php
/**
 * Application header / topbar (Metronic app-header).
 *
 * Extracted from app/View/Layouts/default.ctp (Step 2) so the layout stays
 * readable and every page shares one definition. Markup is unchanged from the
 * working Metronic version -- only the indentation was reduced.
 *
 * Rendered by the layout via: $this->element('layout/topbar');
 */
?>
<div id="kt_app_header" class="app-header">
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container">

        <div class="d-flex align-items-center d-lg-none ms-n2 me-2">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px"
                id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-burger-menu fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
            </div>
        </div>

        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
            id="kt_app_header_wrapper">
            <div class="app-navbar flex-shrink-0 ms-auto">

                <div class="app-navbar-item ms-1 ms-md-3">
                    <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'system_naissance')); ?>"
                        class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px position-relative">
                        <i class="ki-duotone ki-gift fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                        <span
                            class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
                        <span class="badge badge-circle badge-success position-absolute top-0 start-100 translate-middle">
                            <?php echo $this->requestAction(array('controller' => 'users', 'action' => 'system_naissance', 1)); ?>
                        </span>
                    </a>
                </div>

                <div class="app-navbar-item ms-1 ms-md-3">
                    <a href="<?php echo $this->Html->url(array('controller' => 'notifications', 'action' => 'index')); ?>"
                        class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px position-relative">
                        <i class="ki-duotone ki-notification fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <?php $nombre_notif = $this->requestAction('/notifications/system_get_nombre_notification'); ?>
                        <?php if ($nombre_notif): ?>
                            <span class="badge badge-circle badge-warning position-absolute top-0 start-100 translate-middle">
                                <?php echo $nombre_notif; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </div>

                <div class="app-navbar-item ms-1 ms-md-3">
                    <a href="<?php echo $this->Html->url(array('controller' => 'boitemails', 'action' => 'index')); ?>"
                        class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px position-relative">
                        <i class="ki-duotone ki-sms fs-2"><span class="path1"></span><span class="path2"></span></i>
                        <?php $nombremessage = $this->requestAction('/boitemails/system_get_nombre_mail'); ?>
                        <span class="badge badge-circle badge-success position-absolute top-0 start-100 translate-middle">
                            <?php echo $nombremessage; ?>
                        </span>
                    </a>
                </div>

                <div class="app-navbar-item ms-1 ms-md-3 d-flex align-items-center">
                    <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'view')); ?>"
                        class="d-flex align-items-center text-decoration-none">
                        <span class="lb-avatar-bubble">
                            <?php echo strtoupper(substr(AuthComponent::user('name'), 0, 1)); ?>
                        </span>
                        <span class="name_user fw-semibold ms-2 text-dark"><?php echo AuthComponent::user('name'); ?></span>
                    </a>
                </div>

                <div class="app-navbar-item ms-1 ms-md-3">
                    <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout')); ?>"
                        class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
                        title="Se déconnecter">
                        <i class="ki-duotone ki-exit-right fs-2"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

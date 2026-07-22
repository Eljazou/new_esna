<?php
/**
 * Page title + breadcrumb toolbar (Metronic "app-toolbar" pattern).
 *
 * Markup follows Metronic 8.2.0 demo1 (see dist/account/activity.html):
 * page-title > h1.page-heading + ul.breadcrumb.breadcrumb-separatorless,
 * with an optional right-hand actions slot.
 *
 * USAGE -- at the top of any view:
 *
 *     <?php echo $this->element('layout/page_header', array(
 *         'title' => 'Liste des clients',
 *         'crumbs' => array(
 *             'Clients' => array('controller' => 'clients', 'action' => 'index'),
 *             'Fiche client' => null,          // null = current page, not a link
 *         ),
 *         'actions' => '<a href="#" class="btn btn-primary btn-sm">Ajouter</a>',
 *     )); ?>
 *
 * Every parameter is optional:
 *   title   string  page heading. Defaults to the humanised controller name.
 *   crumbs  array   label => URL (array or string), or label => null for the
 *                   current page. An "Accueil" root crumb is prepended
 *                   automatically unless 'home' => false is passed.
 *   actions string  raw HTML rendered on the right (buttons, filters...).
 *   home    bool    set false to suppress the automatic "Accueil" crumb.
 *
 * Labels are escaped with h(); 'actions' is intentionally raw so callers can
 * pass buttons.
 */

$title   = isset($title)   ? $title   : Inflector::humanize(Inflector::underscore($this->request->params['controller']));
$crumbs  = isset($crumbs)  ? $crumbs  : array();
$actions = isset($actions) ? $actions : '';
$home    = isset($home)    ? $home    : true;
?>
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-5">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">

        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                <?php echo h($title); ?>
            </h1>

            <?php if ($home || !empty($crumbs)): ?>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <?php if ($home): ?>
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo $this->Html->url('/'); ?>" class="text-muted text-hover-primary">Accueil</a>
                        </li>
                    <?php endif; ?>

                    <?php foreach ($crumbs as $label => $url): ?>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <?php if ($url === null): ?>
                                <?php echo h($label); ?>
                            <?php else: ?>
                                <a href="<?php echo $this->Html->url($url); ?>"
                                   class="text-muted text-hover-primary"><?php echo h($label); ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php if ($actions !== ''): ?>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <?php echo $actions; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

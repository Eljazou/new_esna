<?php
/**
 * Sidebar navigation menu (Metronic app-sidebar).
 *
 * Extracted from app/View/Layouts/default.ctp (Step 2) so the layout stays
 * readable and every page shares one definition. Markup is unchanged from the
 * working Metronic version -- only the indentation was reduced.
 *
 * Rendered by the layout via: $this->element('layout/sidebar');
 */
?>
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
    data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true" data-kt-drawer-width="255px" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <div class="app-sidebar-logo px-6 d-flex align-items-center position-relative"
        id="kt_app_sidebar_logo" style="min-height: 45px;">
        <a href="<?php
        if (1 == $this->requestAction('/droits/getrole/users/tableau_bord_super'))
            echo $this->Html->url(array('controller' => 'users', 'action' => 'tableau_bord_super'));
        else
            echo $this->Html->url(array('controller' => 'users', 'action' => 'view'));
        ?>" class="d-flex align-items-center text-decoration-none app-sidebar-logo-default">
            <span class="fw-bold fs-4" style="color: var(--lb-primary);">CRM VMP</span>
        </a>
        <a href="<?php
        if (1 == $this->requestAction('/droits/getrole/users/tableau_bord_super'))
            echo $this->Html->url(array('controller' => 'users', 'action' => 'tableau_bord_super'));
        else
            echo $this->Html->url(array('controller' => 'users', 'action' => 'view'));
        ?>" class="d-flex align-items-center text-decoration-none app-sidebar-logo-minimize">
            <span class="fw-bold fs-5" style="color: var(--lb-primary);">CRM</span>
        </a>
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize" title="Réduire / agrandir le menu">
            <i class="ki-duotone ki-double-left fs-4 rotate-180"><span class="path1"></span><span class="path2"></span></i>
        </div>
    </div>

    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-2"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">

            <div class="px-6 mb-3 sidebar-search-full">
                <input type="text" id="RechercherLienDirect" class="form-control form-control-sm"
                    placeholder="Rechercher lien direct" onkeyup="searchmenu(this.value)">
            </div>
            <div class="px-6 mb-3 sidebar-search-icon d-flex justify-content-center">
                <button type="button" class="btn btn-icon btn-sm sidebar-search-icon-btn"
                    title="Rechercher"
                    onclick="document.getElementById('kt_app_sidebar_toggle').click();">
                    <i class="ki-duotone ki-magnifier"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="menu"
                data-kt-menu="true">

                <?php $role = $this->requestAction('/droits/getrole/absences/calendrier');
                if ($role == 1):
                    ?>
                    <div class="menu-item">
                        <a class="menu-link"
                            href="<?php echo $this->Html->url(array('controller' => 'absences', 'action' => 'calendrier')); ?>">
                            <span class="menu-icon"><i class="ki-duotone ki-speaker fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                            <span class="menu-title">Activité hors terrain</span>
                            <span class="badge badge-light-danger ms-2">New</span>
                        </a>
                    </div>
                <?php endif;
                $role = $this->requestAction('/droits/getrole/brochures/index');
                if ($role == 1):
                    ?>
                    <div class="menu-item">
                        <a class="menu-link"
                            href="<?php echo $this->Html->url(array('controller' => 'brochures', 'action' => 'index')); ?>">
                            <span class="menu-icon"><i class="ki-duotone ki-book fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i></span>
                            <span class="menu-title">
                                <?php
                                if (AuthComponent::user('role') == 'Admin')
                                    echo "Programme produit";
                                else
                                    echo "Brochures";
                                ?>
                            </span>
                        </a>
                    </div>
                    <?php
                endif;
                $role = $this->requestAction('/droits/getrole/formations/index');
                if ($role == 1):
                    ?>
                    <div class="menu-item">
                        <a class="menu-link"
                            href="<?php echo $this->Html->url(array('controller' => 'formations', 'action' => 'index')); ?>">
                            <span class="menu-icon"><i class="ki-duotone ki-flask fs-3"><span class="path1"></span><span class="path2"></span></i></span>
                            <span class="menu-title">Formations</span>
                        </a>
                    </div>
                    <?php
                endif;
                $role = $this->requestAction('/droits/getrole/marketings/index');
                if ($role == 1):
                    ?>
                    <div class="menu-item">
                        <a class="menu-link"
                            href="<?php echo $this->Html->url(array('controller' => 'marketings', 'action' => 'index')); ?>">
                            <span class="menu-icon"><i class="ki-duotone ki-speaker fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                            <span class="menu-title">Marketing</span>
                        </a>
                    </div>
                <?php endif;
                $role = $this->requestAction('/droits/getrole/clients/allclients');
                if ($role == 1):
                    ?>
                    <div class="menu-item">
                        <a class="menu-link"
                            href="<?php echo $this->Html->url(array('controller' => 'clients', 'action' => 'allclients')); ?>">
                            <span class="menu-icon"><i class="ki-duotone ki-people fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></span>
                            <span class="menu-title">Liste des clients</span>
                        </a>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/notefrais/notedefrais');
                $role2 = $this->requestAction('/droits/getrole/notefrais/validation');
                $role3 = $this->requestAction('/droits/getrole/notefrais/automatique_note_de_frais');
                $role4 = $this->requestAction('/droits/getrole/notevalidations/index');
                $role5 = $this->requestAction('/droits/getrole/notefrais/exporter');

                if ($role3 == 1 || $role1 == 1 || $role2 == 1 || $role4 == 1 || $role5 == 1):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-dollar fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                            <span class="menu-title">Note de frais</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Génération manuel', array('controller' => 'notefrais', 'action' => 'notedefrais'), array('class' => 'menu-link')) . '</div>';
                            if ($role3 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Génération automatique', array('controller' => 'notefrais', 'action' => 'automatique_note_de_frais'), array('class' => 'menu-link')) . '</div>';
                            if ($role2 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Valider', array('controller' => 'notefrais', 'action' => 'validation'), array('class' => 'menu-link')) . '</div>';
                            if ($role5 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Exporter', array('controller' => 'notefrais', 'action' => 'exporter', 1), array('class' => 'menu-link')) . '</div>';
                            if ($role4 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Règles de validation', array('controller' => 'notevalidations', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role = $this->requestAction('/droits/getrole/gadjets/index');
                if ($role == 1):
                    ?>
                    <div class="menu-item">
                        <a class="menu-link"
                            href="<?php echo $this->Html->url(array('controller' => 'gadjets', 'action' => 'index')); ?>">
                            <span class="menu-icon"><i class="ki-duotone ki-rocket fs-3"><span class="path1"></span><span class="path2"></span></i></span>
                            <span class="menu-title">Echantillons</span>
                        </a>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/listes/view');
                $role2 = $this->requestAction('/droits/getrole/listes/listeretard');
                $role3 = $this->requestAction('/droits/getrole/listes/feuilleroute');
                if ($role1 == 1 || $role2 == 1 || $role3 == 1):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></span>
                            <span class="menu-title">Mon listing</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Liste de la semaine', array('controller' => 'listes', 'action' => 'view'), array('class' => 'menu-link')) . '</div>';
                            if ($role2 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Liste de retards', array('controller' => 'listes', 'action' => 'listeretard'), array('class' => 'menu-link')) . '</div>';
                            if ($role3 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Créé une feuille de route', array('controller' => 'listes', 'action' => 'feuilleroute'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role = $this->requestAction('/droits/getrole/echantillons/stockvmp');
                if ($role == 1):
                    ?>
                    <div class="menu-item">
                        <a class="menu-link"
                            href="<?php echo $this->Html->url(array('controller' => 'echantillons', 'action' => 'stockvmp')); ?>">
                            <span class="menu-icon"><i class="ki-duotone ki-text-align-left fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i></span>
                            <span class="menu-title">Stock des échantillons</span>
                        </a>
                    </div>
                    <?php
                endif;
                $role = $this->requestAction('/droits/getrole/clientsproposes/add');
                if ($role == 1):
                    ?>
                    <div class="menu-item">
                        <a class="menu-link"
                            href="<?php echo $this->Html->url(array('controller' => 'clientsproposes', 'action' => 'add')); ?>">
                            <span class="menu-icon"><i class="ki-duotone ki-user-tick fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                            <span class="menu-title">Proposer un client</span>
                        </a>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/rapports/index');
                $role2 = $this->requestAction('/droits/getrole/rapports/visites');
                $role3 = $this->requestAction('/droits/getrole/actionrapports/index');
                if ($role1 == 1 || $role2 == 1 || $role3 == 1):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-check fs-3"></i></span>
                            <span class="menu-title">Rapports</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Rapport hebdomadaire', array('controller' => 'rapports', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role2 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Rapports des visites', array('controller' => 'rapports', 'action' => 'visites'), array('class' => 'menu-link')) . '</div>';
                            if ($role3 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Mes rapports d\'actions', array('controller' => 'actionrapports', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role = $this->requestAction('/droits/getrole/grosistes/index');
                if ($role == 1):
                    ?>
                    <div class="menu-item">
                        <a class="menu-link"
                            href="<?php echo $this->Html->url(array('controller' => 'grosistes', 'action' => 'index')); ?>">
                            <span class="menu-icon"><i class="ki-duotone ki-time fs-3"><span class="path1"></span><span class="path2"></span></i></span>
                            <span class="menu-title">Sorti grossiste</span>
                        </a>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/users/index');
                $role2 = $this->requestAction('/droits/getrole/users/affectation');
                $role3 = $this->requestAction('/droits/getrole/objectifs/index');
                $role4 = $this->requestAction('/droits/getrole/evaluations/index');
                $role5 = $this->requestAction('/droits/getrole/visites/pointage');
                $role6 = $this->requestAction('/droits/getrole/listes/getlisteforallclients');
                if ($role6 == 1 || $role5 == 1 || $role1 == 1 || $role2 == 1 || $role3 == 1 || $role4 == 1):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></span>
                            <span class="menu-title">Gestion des utilisateurs</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php if ($role1 == 1): ?>
                                <div class="menu-item">
                                    <?php echo $this->Html->link('Gestion des utilisateurs', array('controller' => 'users', 'action' => 'index'), array('class' => 'menu-link')); ?>
                                </div>
                                <?php
                            endif;
                            if ($role2 == 1):
                                ?>
                                <div class="menu-item">
                                    <?php echo $this->Html->link('Affectation', array('controller' => 'users', 'action' => 'affectation'), array('class' => 'menu-link')); ?>
                                </div>
                                <?php
                            endif;
                            if ($role3 == 1):
                                ?>
                                <div class="menu-item">
                                    <?php echo $this->Html->link('Gestion des objectifs', array('controller' => 'objectifs', 'action' => 'index'), array('class' => 'menu-link')); ?>
                                </div>
                                <?php
                            endif;
                            if ($role4 == 1):
                                ?>
                                <div class="menu-item">
                                    <?php echo $this->Html->link('Evaluations', array('controller' => 'evaluations', 'action' => 'index'), array('class' => 'menu-link')); ?>
                                </div>
                                <?php
                            endif;
                            if ($role5 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Pointage', array('controller' => 'visites', 'action' => 'pointage'), array('class' => 'menu-link')) . '</div>';
                            if ($role6 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('toutes les listes', array('controller' => 'listes', 'action' => 'getlisteforallclients'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/notefrais/index');
                $role2 = $this->requestAction('/droits/getrole/actions/valider');
                $role4 = $this->requestAction('/droits/getrole/clientsproposes/valider');
                $role5 = $this->requestAction('/droits/getrole/commandes/index');
                $role6 = $this->requestAction('/droits/getrole/gadjets/admin');
                $role7 = $this->requestAction('/droits/getrole/documents/valider');
                $role8 = $this->requestAction('/droits/getrole/avences/valider');
                $role9 = $this->requestAction('/droits/getrole/listes/validerFuilleDeRoute');
                $role10 = $this->requestAction('/droits/getrole/absences/valider');
                $role11 = $this->requestAction('/droits/getrole/packs/valider');
                if ($role11 == 1 || $role10 == 1 || $role9 == 1 || $role8 == 1 || $role7 == 1 || $role6 == 1 || $role5 == 1 || $role1 == 1 || $role2 == 1 || $role4 == 1):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-check fs-3"></i></span>
                            <span class="menu-title">Validation</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Note de frais', array('controller' => 'notefrais', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role2 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Actions', array('controller' => 'actions', 'action' => 'valider'), array('class' => 'menu-link')) . '</div>';
                            if ($role4 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Clients', array('controller' => 'clientsproposes', 'action' => 'valider'), array('class' => 'menu-link')) . '</div>';
                            if ($role5 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Commandes', array('controller' => 'commandes', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role6 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Echantillons', array('controller' => 'gadjets', 'action' => 'admin'), array('class' => 'menu-link')) . '</div>';
                            if ($role7 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Documents', array('controller' => 'documents', 'action' => 'valider'), array('class' => 'menu-link')) . '</div>';
                            if ($role8 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Avances', array('controller' => 'avences', 'action' => 'valider'), array('class' => 'menu-link')) . '</div>';
                            if ($role9 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Feuilles de route', array('controller' => 'listes', 'action' => 'validerFuilleDeRoute'), array('class' => 'menu-link')) . '</div>';
                            if ($role10 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Absences et congés', array('controller' => 'absences', 'action' => 'valider'), array('class' => 'menu-link')) . '</div>';
                            if ($role11 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Packs', array('controller' => 'packs', 'action' => 'valider'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/secteurs/index');
                $role2 = $this->requestAction('/droits/getrole/categories/index');
                $role3 = $this->requestAction('/droits/getrole/types/index');
                $role4 = $this->requestAction('/droits/getrole/droits/gestion');
                $role5 = $this->requestAction('/droits/getrole/echantillons/index');
                $role6 = $this->requestAction('/droits/getrole/games/index');
                $role7 = $this->requestAction('/droits/getrole/produits/index');
                $role8 = $this->requestAction('/droits/getrole/offres/index');
                $role9 = $this->requestAction('/droits/getrole/objectifprofiles/index');
                $role10 = $this->requestAction('/droits/getrole/rapports/index');
                $role11 = $this->requestAction('/droits/getrole/clients/trouverdoublons');
                $role12 = $this->requestAction('/droits/getrole/groproduits/index');
                $role13 = $this->requestAction('/droits/getrole/grosistes/index');
                $role14 = $this->requestAction('/droits/getrole/jourferiers/index');
                $role15 = $this->requestAction('/droits/getrole/autoechantiants/index');
                $role16 = $this->requestAction('/droits/getrole/lignes/index');
                $role17 = $this->requestAction('/droits/getrole/brochures/organiser');
                $role18 = $this->requestAction('/droits/getrole/notefraissecteurs/index');
                $role19 = $this->requestAction('/droits/getrole/odpobjectifs/index');
                if (
                    $role19 == 1 || $role16 == 1 || $role15 == 1 || $role14 == 1 || $role12 == 1 || $role11 == 1 || $role9 == 1 || $role1 == 1 ||
                    $role2 == 1 || $role17 == 1 || $role3 == 1 || $role4 == 1 || $role5 == 1 || $role6 == 1 || $role7 == 1
                    || $role8 == 1 || $role18 == 1
                ):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-profile-user fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i></span>
                            <span class="menu-title">Administration</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php if ($role1 == 1): ?>
                                <div class="menu-item">
                                    <?php echo $this->Html->link('Gestion des secteurs', array('controller' => 'secteurs', 'action' => 'index'), array('class' => 'menu-link')); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($role2 == 1): ?>
                                <div class="menu-item">
                                    <?php echo $this->Html->link('Gestion des spécialités', array('controller' => 'categories', 'action' => 'index'), array('class' => 'menu-link')); ?>
                                </div>
                                <?php
                            endif;
                            if ($role3 == 1):
                                ?>
                                <div class="menu-item">
                                    <?php echo $this->Html->link('Gestion des type de clients', array('controller' => 'types', 'action' => 'index'), array('class' => 'menu-link')); ?>
                                </div>
                                <?php
                            endif;
                            if ($role4 == 1):
                                ?>
                                <div class="menu-item">
                                    <?php echo $this->Html->link('Gestion des droits', array('controller' => 'droits', 'action' => 'gestion'), array('class' => 'menu-link')); ?>
                                </div>
                                <?php
                            endif;
                            if ($role5 == 1):
                                ?>
                                <div class="menu-item">
                                    <?php echo $this->Html->link('Gestion des échantillons', array('controller' => 'echantillons', 'action' => 'index'), array('class' => 'menu-link')); ?>
                                </div>
                                <?php
                            endif;
                            if ($role6 == 1):
                                ?>
                                <div class="menu-item">
                                    <?php echo $this->Html->link('Gestion des gammes', array('controller' => 'games', 'action' => 'index'), array('class' => 'menu-link')); ?>
                                </div>
                                <?php
                            endif;
                            if ($role7 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des produits', array('controller' => 'produits', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role8 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des offres', array('controller' => 'offres', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role9 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des objectifes profile', array('controller' => 'objectifprofiles', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role10 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des rapports', array('controller' => 'rapports', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role11 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Clients en double', array('controller' => 'clients', 'action' => 'trouverdoublons'), array('class' => 'menu-link')) . '</div>';
                            if ($role12 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Produits de grossistes', array('controller' => 'groproduits', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role13 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des grossistes', array('controller' => 'grosistes', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role14 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion jours fériés', array('controller' => 'jourferiers', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role15 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('gestion automatique échantillons', array('controller' => 'autoechantiants', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role16 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des lignes', array('controller' => 'lignes', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role17 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Organisation des brochures', array('controller' => 'brochures', 'action' => 'organiser'), array('class' => 'menu-link')) . '</div>';
                            if ($role18 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des notes de frais', array('controller' => 'notefraissecteurs', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role19 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('ODP contacts', array('controller' => 'odpobjectifs', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if (AuthComponent::user('role') == 'Admin'):
                                ?>
                                <div class="menu-item">
                                    <a class="menu-link"
                                        href="<?php echo $this->Html->url(array('controller' => 'hopitals', 'action' => 'index')); ?>">
                                        Gestion des hôpitaux<span class="badge badge-light-danger ms-2">New</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/users/admin_statistique');
                $role2 = $this->requestAction('/droits/getrole/clients/statistique_visites');
                $role3 = $this->requestAction('/droits/getrole/users/tableau_bord_super');
                $role4 = $this->requestAction('/droits/getrole/secteurs/index');
                $role5 = $this->requestAction('/droits/getrole/categories/index');
                $role6 = $this->requestAction('/droits/getrole/types/index');
                $role7 = $this->requestAction('/droits/getrole/clients/statistique_pot');
                $role8 = $this->requestAction('/droits/getrole/actions/statistiqueparregion');
                $role9 = $this->requestAction('/droits/getrole/visites/suiviglobal');
                $role10 = $this->requestAction('/droits/getrole/grosistes/statistiqueglobal');
                $role11 = $this->requestAction('/droits/getrole/clients/statistiqueListeParVM');
                $role12 = $this->requestAction('/droits/getrole/statistiques/statistiquesvisite');
                $role13 = $this->requestAction('/droits/getrole/statistiques/statclient');
                $role14 = $this->requestAction('/droits/getrole/stockvisites/index');
                $role15 = $this->requestAction('/droits/getrole/clients/infoClientParMois');
                $role16 = $this->requestAction('/droits/getrole/boiteidees/index');
                $role17 = $this->requestAction('/droits/getrole/gadgetclients/statistique');
                if ($role17 == 1 || $role16 == 1 || $role15 == 1 || $role14 == 1 || $role13 == 1 || $role12 == 1 || $role11 == 1 || $role10 == 1 || $role9 == 1 || $role8 == 1 || $role1 == 1 || $role2 == 1 || $role3 == 1 || $role4 == 1 || $role5 == 1 || $role6 == 1 || $role7 == 1):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></span>
                            <span class="menu-title">Statistiques</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role14 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Stock temps réel', array('controller' => 'stockvisites', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Employées', array('controller' => 'users', 'action' => 'admin_statistique'), array('class' => 'menu-link')) . '</div>';
                            if ($role2 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Clients par visite', array('controller' => 'clients', 'action' => 'statistique_visites'), array('class' => 'menu-link')) . '</div>';
                            if ($role3 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistique VMP/Jours', array('controller' => 'users', 'action' => 'tableau_bord_super'), array('class' => 'menu-link')) . '</div>';
                            if ($role4 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistiques des secteurs', array('controller' => 'secteurs', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role5 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistiques des spécialités', array('controller' => 'categories', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role6 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistique des type de clients', array('controller' => 'types', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role7 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistique Pot', array('controller' => 'clients', 'action' => 'statistique_pot'), array('class' => 'menu-link')) . '</div>';
                            if ($role8 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistique Actions', array('controller' => 'actions', 'action' => 'statistiqueparregion'), array('class' => 'menu-link')) . '</div>';
                            if ($role9 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistique des visites', array('controller' => 'visites', 'action' => 'suiviglobal'), array('class' => 'menu-link')) . '</div>';
                            if ($role10 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistique des grossiste', array('controller' => 'grosistes', 'action' => 'statistiqueglobal'), array('class' => 'menu-link')) . '</div>';
                            if ($role11 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistique des listes par VM', array('controller' => 'clients', 'action' => 'statistiqueListeParVM'), array('class' => 'menu-link')) . '</div>';
                            if ($role12 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistique global', array('controller' => 'statistiques', 'action' => 'statistiquesvisite'), array('class' => 'menu-link')) . '</div>';
                            if ($role13 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Stat Covid19', array('controller' => 'statistiques', 'action' => 'statclient'), array('class' => 'menu-link')) . '</div>';
                            if ($role15 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Suivi clients par mois', array('controller' => 'clients', 'action' => 'infoClientParMois'), array('class' => 'menu-link')) . '</div>';
                            if ($role16 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Boite idees', array('controller' => 'boiteidees', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role17 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Statistiques gadgets client', array('controller' => 'gadgetclients', 'action' => 'statistique'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/analyses/moyenne_visites');
                $role2 = $this->requestAction('/droits/getrole/analyses/visite_dsm');
                $role3 = $this->requestAction('/droits/getrole/analyses/portefeuille_vm');
                $role4 = $this->requestAction('/droits/getrole/analyses/doublons_vm');
                $role5 = $this->requestAction('/droits/getrole/analyses/calcule_couverture');
                $role6 = $this->requestAction('/droits/getrole/analyses/frequences_visites');
                $role7 = $this->requestAction('/droits/getrole/asm/suivi_pharmacie');
                $role8 = $this->requestAction('/droits/getrole/asm/asm_visites_double');
                if ($role1 == 1 || $role2 == 1 || $role3 == 1 || $role4 == 1 || $role5 == 1 || $role6 == 1 || $role7 == 1 || $role8 == 1): ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-archive fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                            <span class="menu-title">Analyse de Performance</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Moyenne des visites', array('controller' => 'analyses', 'action' => 'moyenne_visites'), array('class' => 'menu-link')) . '</div>';
                            if ($role2 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Visites DSM', array('controller' => 'analyses', 'action' => 'visite_dsm'), array('class' => 'menu-link')) . '</div>';
                            if ($role3 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Portefeuille des VMP', array('controller' => 'analyses', 'action' => 'portefeuille_vm'), array('class' => 'menu-link')) . '</div>';
                            if ($role4 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Doublons VMP', array('controller' => 'analyses', 'action' => 'doublons_vm'), array('class' => 'menu-link')) . '</div>';
                            if ($role5 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Calcul de la couverture', array('controller' => 'analyses', 'action' => 'calcule_couverture'), array('class' => 'menu-link')) . '</div>';
                            if ($role6 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Fréquences des visites', array('controller' => 'analyses', 'action' => 'frequences_visites'), array('class' => 'menu-link')) . '</div>';
                            if ($role7 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Suivi pharmacie', array('controller' => 'asm', 'action' => 'suivi_pharmacie'), array('class' => 'menu-link')) . '</div>';
                            if ($role8 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Visites en double', array('controller' => 'asm', 'action' => 'asm_visites_double'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/prospectaffaires/index');
                $role2 = $this->requestAction('/droits/getrole/prospects/affectation');
                $role3 = $this->requestAction('/droits/getrole/prospects/teleconseiller');
                $role4 = $this->requestAction('/droits/getrole/rapportprocpects/fuille_route_conseiller');
                $role5 = $this->requestAction('/droits/getrole/rapportprocpects/export_feuille');
                $role6 = $this->requestAction('/droits/getrole/prospects/import');
                $role7 = $this->requestAction('/droits/getrole/prospects/tableau_bord_conseiller');
                $role8 = $this->requestAction('/droits/getrole/rapportprocpects/opportunites');
                $role9 = $this->requestAction('/droits/getrole/prospectcompagnes/affectation_auto_excel');
                $role10 = $this->requestAction('/droits/getrole/commandes/index');
                if ($role10 == 1 || $role9 == 1 || $role8 == 1 || $role7 == 1 || $role6 == 1 || $role5 == 1 || $role4 == 1 || $role1 == 1 || $role2 == 1 || $role3 == 1):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-archive fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                            <span class="menu-title">Centre téléconseiller</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role7 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Tableau de bord', array('controller' => 'prospects', 'action' => 'tableau_bord_conseiller'), array('class' => 'menu-link')) . '</div>';
                            if ($role10 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Les commandes', array('controller' => 'commandes', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des affaires', array('controller' => 'prospectaffaires', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role2 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des affectations', array('controller' => 'prospects', 'action' => 'affectation'), array('class' => 'menu-link')) . '</div>';
                            if ($role3 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des téléconseillers', array('controller' => 'prospects', 'action' => 'teleconseiller'), array('class' => 'menu-link')) . '</div>';
                            if ($role4 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Mes appels', array('controller' => 'rapportprocpects', 'action' => 'fuille_route_conseiller'), array('class' => 'menu-link')) . '</div>';
                            if ($role5 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Export des actions', array('controller' => 'rapportprocpects', 'action' => 'export_feuille'), array('class' => 'menu-link')) . '</div>';
                            if ($role6 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Import des prospects', array('controller' => 'prospects', 'action' => 'import'), array('class' => 'menu-link')) . '</div>';
                            if ($role8 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gestion des opportunités', array('controller' => 'rapportprocpects', 'action' => 'opportunites'), array('class' => 'menu-link')) . '</div>';
                            if ($role9 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Importation des compagnes', array('controller' => 'prospectcompagnes', 'action' => 'affectation_auto_excel'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/digitals/traitement_administratif');
                $role2 = $this->requestAction('/droits/getrole/digitals/traitement_commercail');
                if ($role1 == 1 || $role2 == 1):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-archive fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                            <span class="menu-title">Centre digital</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Traitement administratif', array('controller' => 'digitals', 'action' => 'traitement_administratif'), array('class' => 'menu-link')) . '</div>';
                            if ($role2 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Traitement commercial', array('controller' => 'digitals', 'action' => 'traitement_commercail'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/pots/add');
                $role2 = $this->requestAction('/droits/getrole/pots/import');
                $role3 = $this->requestAction('/droits/getrole/pots/index');
                if ($role1 == 1 || $role2 == 1 || $role3 == 1):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-archive fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                            <span class="menu-title">Portefeuille client</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Portefeuille', array('controller' => 'pots', 'action' => 'index'), array('class' => 'menu-link')) . '</div>';
                            if ($role2 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Importation', array('controller' => 'pots', 'action' => 'import'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/services/set_liste_to_user');
                if ($role1 == 1):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-archive fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                            <span class="menu-title">Services</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Importation commercial', array('controller' => 'services', 'action' => 'set_liste_to_user'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $role1 = $this->requestAction('/droits/getrole/evaluations/archive');
                $role2 = $this->requestAction('/droits/getrole/brochures/archive');
                $role3 = $this->requestAction('/droits/getrole/formations/archive');
                $role4 = $this->requestAction('/droits/getrole/notefrais/archive');
                $role5 = $this->requestAction('/droits/getrole/clients/archive');
                $role6 = $this->requestAction('/droits/getrole/actions/archive');
                $role7 = $this->requestAction('/droits/getrole/absences/archive');
                $role8 = $this->requestAction('/droits/getrole/echantillons/archive');
                $role9 = $this->requestAction('/droits/getrole/visites/archive');
                $role10 = $this->requestAction('/droits/getrole/users/archive');
                $role11 = $this->requestAction('/droits/getrole/clientsproposes/archive');
                $role12 = $this->requestAction('/droits/getrole/produits/archive');
                $role13 = $this->requestAction('/droits/getrole/offres/archive');
                $role14 = $this->requestAction('/droits/getrole/rapports/archive');
                $role15 = $this->requestAction('/droits/getrole/commandes/archive');
                $role16 = $this->requestAction('/droits/getrole/categories/archive');
                $role17 = $this->requestAction('/droits/getrole/secteurs/archive');
                $role18 = $this->requestAction('/droits/getrole/games/archive');
                $role19 = $this->requestAction('/droits/getrole/listes/archive');
                $role20 = $this->requestAction('/droits/getrole/documents/archive');
                $role21 = $this->requestAction('/droits/getrole/documents/archive');
                if (
                    $role21 == 1 || $role20 == 1 || $role19 == 1 || $role15 == 1 || $role14 == 1 || $role2 == 1 || $role3 == 1 || $role4 == 1 || $role5 == 1 || $role6 == 1 ||
                    $role7 == 1 || $role8 == 1 || $role9 == 1 || $role10 == 1 || $role11 == 1 || $role12 == 1 || $role13 == 1 || $role16 == 1 || $role17 == 1 || $role18 == 1 || $role19 == 1
                ):
                    ?>
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="ki-duotone ki-archive fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                            <span class="menu-title">Archive</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php
                            if ($role1 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Evaluation', array('controller' => 'evaluations', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role2 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Brochures', array('controller' => 'brochures', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role3 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Formations', array('controller' => 'formations', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role4 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Note de frais', array('controller' => 'notefrais', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role5 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Clients', array('controller' => 'clients', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role6 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Actions', array('controller' => 'actions', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role7 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Absences', array('controller' => 'absences', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role8 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Echantillons', array('controller' => 'echantillons', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role9 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Visites', array('controller' => 'visites', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role10 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Utilisateurs', array('controller' => 'users', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role11 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Proposition des clients', array('controller' => 'clientsproposes', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role12 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Produits', array('controller' => 'produits', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role13 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Offres', array('controller' => 'offres', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role14 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Rapports', array('controller' => 'rapports', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role15 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Commandes', array('controller' => 'commandes', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role16 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Spécialités', array('controller' => 'categories', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role17 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Secteurs', array('controller' => 'secteurs', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role18 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Gammes', array('controller' => 'games', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role19 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Listes', array('controller' => 'listes', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role20 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Documents', array('controller' => 'documents', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            if ($role21 == 1)
                                echo '<div class="menu-item">' . $this->Html->link('Avences', array('controller' => 'avences', 'action' => 'archive'), array('class' => 'menu-link')) . '</div>';
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

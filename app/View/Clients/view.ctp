<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<?php
// Example string representing JSON-encoded vendors data
$vendeurJson = $client['Client']['vendeur'];
$vendeurs = json_decode($vendeurJson, true);

// ------------------------------------------------------------------
// Shared row/badge renderers used across the Info card, Appels tab,
// Stock tab and Commandes table. Defined ONCE at the top of the file.
// (Previously this was declared with `function cv_row(){...}` INSIDE
// the `foreach ($appels as $appel):` loop further down the page —
// PHP would throw "Cannot redeclare cv_row()" as soon as a client
// had a 2nd call logged. Moving it here fixes that.)
// ------------------------------------------------------------------
function cv_row($label, $value) {
    echo '<div class="d-flex flex-stack border-bottom border-gray-200 py-2">'
        . '<div class="fw-bold text-gray-600 fs-7 text-uppercase">' . $label . '</div>'
        . '<div class="text-gray-800 fs-6 text-end">' . $value . '</div>'
        . '</div>';
}
function cv_badges($label, $pipeValue) {
    $items = array_filter(explode('|', (string) $pipeValue));
    $badges = '';
    foreach ($items as $item) {
        $badges .= '<span class="badge badge-light-primary me-1 mb-1">' . trim($item) . '</span>';
    }
    echo '<div class="border-bottom border-gray-200 py-2">'
        . '<div class="fw-bold text-gray-600 fs-7 text-uppercase mb-2">' . $label . '</div>'
        . '<div>' . $badges . '</div>'
        . '</div>';
}
?>

<!--
    NOTE: the <style> block that used to live here (300+ lines defining
    .cv-grid, .cv-card, .cv-btn, .cv-pill, .cv-profile, .cv-table, a
    second unrelated ".card"/".card-body" pair for the gadget list,
    plus a hand-written override targeting AdminLTE inline styles by
    literal fingerprint) has been removed entirely. Every element below
    now uses real Metronic 8 / Bootstrap 5 utility and component
    classes, so there is nothing left to maintain here.

    The ".objet / .optionh / .optionb" floating dropdown widget is NOT
    reproduced in this file because its markup lives inside the
    clients/visite_item_v1 and clients/visite_item_v2 elements (not
    part of this template) and is driven by exact class-name lookups
    in objettog()/pup()/pup1()/pup2() further down. If those elements
    still emit .objet/.optionh/.optionb markup, that small piece of
    custom CSS needs to stay defined somewhere (e.g. a scoped
    <style> in those element files) until those files are converted too.
-->

<div class="client-view">

<!--begin::Map modal-->
<div id="myModalmap" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Maps</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div id="map-canvas" style="height: 480px;border-radius:0.475rem;overflow:hidden;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<!--end::Map modal-->

<!--begin::Objections / Veille / Concurrence grid modals-->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold modal-title" id="gridModalLabel"></h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gy-4"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">FERMER</button>
            </div>
        </div>
    </div>
</div>

<div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold modal-title" id="gridModalLabel"></h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gy-4">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>Produits</th>
                                <th>Emplacement produits</th>
                                <th>PLV en place</th>
                                <th>Stocks disponibles au moment de la visite</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">FERMER</button>
            </div>
        </div>
    </div>
</div>

<div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold modal-title" id="gridModalLabel"></h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gy-4">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>Produit</th>
                                <th>Produit concurrent</th>
                                <th>Emplacement produits</th>
                                <th>PLV en place</th>
                                <th>Type de l'offre</th>
                                <th>Degrés d'agressivité</th>
                                <th>Stocks disponibles au moment de la visite</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">FERMER</button>
            </div>
        </div>
    </div>
</div>
<!--end::Grid modals-->

<!--begin::Export result modal-->
<div class="modal fade" id="modal_return" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Export Result</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div id="export-message" class="text-center">
                    <i class="ki-duotone ki-loading fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>
                    <p class="mt-3 mb-0">Export en cours...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Export result modal-->

<!--begin::Stat cards: visites / retards / action en cours-->
<div class="row g-5 g-xl-8 mb-5 mb-xl-8">

    <!--begin::Visites-->
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-body d-flex align-items-center pt-5">
                <div class="symbol symbol-45px me-4">
                    <span class="symbol-label bg-light-primary">
                        <i class="ki-duotone ki-eye fs-1 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    </span>
                </div>
                <div class="flex-grow-1">
                    <div class="fs-2hx fw-bold text-gray-900 lh-1"><?php
                        $i = 0;
                        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                        $details = array();
                        foreach ($client['Visite'] as $visite) {
                            if (AuthComponent::user('role') != 'VMP' && AuthComponent::user('role') != 'Coordinateur') {
                                if ($visite['date'] >= $client['Client']['date_recrutement']) {
                                    $i++;
                                    $details[] = $visite['date'];
                                }
                            } else {
                                if ($visite['date'] >= $client['Client']['date_recrutement'] && $visite['user_id'] == AuthComponent::user('id')) {
                                    $i++;
                                    $details[] = $visite['date'];
                                }
                            }
                        }
                        echo $i;
                        ?></div>
                    <div class="text-gray-500 fw-semibold fs-6">Nombre de visites</div>
                </div>
                <button type="button" onclick="boxtog(1)" class="btn btn-icon btn-sm btn-light" title="Plus de détails"><i id="icon1" class="ki-duotone ki-plus fs-3"></i></button>
            </div>
            <div class="card-body pt-0 box1" style="display:none;">
                <div class="text-muted fs-7" style="max-height:180px;overflow-y:auto;">
                    <?php foreach ($details as $key => $value): ?>
                        <div class="py-1"><i class="ki-duotone ki-time text-primary me-2"><span class="path1"></span><span class="path2"></span></i><?php echo $value; ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!--end::Visites-->

    <!--begin::Retards-->
    <?php
    $dateretard = $this->requestAction('/clients/system_get_retard_list_client/' . $client['Client']['id']);
    $r = $i - $dateretard['nobre'];
    $retardColor = ($r < 0) ? 'danger' : 'success';
    ?>
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-body d-flex align-items-center pt-5">
                <div class="symbol symbol-45px me-4">
                    <span class="symbol-label bg-light-<?php echo $retardColor; ?>">
                        <i class="ki-duotone ki-time fs-1 text-<?php echo $retardColor; ?>"><span class="path1"></span><span class="path2"></span></i>
                    </span>
                </div>
                <div class="flex-grow-1">
                    <div class="fs-2hx fw-bold lh-1 text-<?php echo $retardColor; ?>"><?php
                        echo $r;
                        unset($dateretard['nobre']);
                        ?></div>
                    <div class="text-gray-500 fw-semibold fs-6">Nombre de retards</div>
                </div>
                <button type="button" onclick="boxtog(2)" class="btn btn-icon btn-sm btn-light" title="Plus de détails"><i id="icon2" class="ki-duotone ki-plus fs-3"></i></button>
            </div>
            <div class="card-body pt-0 box2" style="display:none;">
                <div class="text-muted fs-7" style="max-height:180px;overflow-y:auto;">
                    <?php foreach ($dateretard as $key => $value): ?>
                        <div class="py-1"><i class="ki-duotone ki-time text-primary me-2"><span class="path1"></span><span class="path2"></span></i><?php echo $value; ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!--end::Retards-->

    <!--begin::Action en cours-->
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-body d-flex align-items-center pt-5">
                <div class="symbol symbol-45px me-4">
                    <span class="symbol-label bg-light-warning">
                        <i class="ki-duotone ki-star fs-1 text-warning"></i>
                    </span>
                </div>
                <div class="flex-grow-1">
                    <div class="fs-2hx fw-bold text-gray-900 lh-1"><?php
                        if (count($client['Action']) == 0) {
                            echo '----';
                        } else {
                            $now = time();
                            $your_date = strtotime($client['Action'][0]['date_fin']);
                            $datediff = $your_date - $now;
                            $j = floor($datediff / (60 * 60 * 24));
                            echo ($j > 0) ? "$j j" : '----';
                        }
                        ?></div>
                    <div class="text-gray-500 fw-semibold fs-6">Action en cours</div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Action en cours-->

</div>
<!--end::Stat cards-->

<div class="row g-5 g-xl-8">
    <div class="col-xl-8">

        <!--begin::Profile header-->
        <div class="card mb-5 mb-xl-8">
            <div class="card-body pt-9 pb-9">
                <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                            <h1 class="text-gray-900 fs-2 fw-bold m-0">
                                <?php echo $client['Client']['nom'] . ' ' . $client['Client']['prenom']; ?>
                            </h1>
                            <?php if (AuthComponent::user('role') == 'Admin'): ?>
                                <span class="badge badge-light-primary fs-7 fw-bold"><?php echo $client['Client']['potentialite']; ?></span>
                            <?php endif; ?>
                            <?php if ($client['Type']['name'] == 'Pharmacie'): ?>
                                <span class="badge badge-light-success fs-7 fw-bold">CA : <?php echo $client['Client']['activite']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex align-items-center text-muted fs-6">
                            <?php
                            if ($client['Client']['sexe'] == 'h') {
                                echo '<i class="ki-duotone ki-profile-circle fs-5 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Homme';
                            } elseif ($client['Client']['sexe'] == 'f') {
                                echo '<i class="ki-duotone ki-profile-circle fs-5 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Femme';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3 mt-sm-0">
                        <?php
                        if ($this->requestAction('/droits/getrole/visites/add') == 1)
                            echo $this->Html->link(__('Visiter'), array('controller' => 'visites', 'action' => 'add', $client['Client']['id']), array("class" => "btn btn-sm btn-light-primary"));
                        if ($this->requestAction('/droits/getrole/actions/add') == 1)
                            echo $this->Html->link(__('Demander une action'), array('controller' => 'actions', 'action' => 'add', $client['Client']['id']), array("class" => "btn btn-sm btn-light-primary"));
                        if ($this->requestAction('/droits/getrole/packs/add') == 1)
                            echo $this->Html->link(__('Ajouter un pack'), array('controller' => 'packs', 'action' => 'add', $client['Client']['id']), array("class" => "btn btn-sm btn-light-primary"));
                        if ($this->requestAction('/droits/getrole/clients/remettre0') == 1)
                            echo $this->Html->link(__('Remettre à 0'), array('action' => 'remettre0', $client['Client']['id']), array("class" => "btn btn-sm btn-light-danger"));
                        if ($this->requestAction('/droits/getrole/gadgetclients/add') == 1): ?>
                            <a href="#gadget_modal" rel="modal:open" class="btn btn-sm btn-light-warning">
                                <i class="ki-duotone ki-gift fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                                Ajouter gadget
                            </a>
                        <?php endif;

                        if ($client['Type']['name'] != 'Médecin') {
                            $token = $client['Client']['id'] * 12;
                            $tok = md5($token);
                            if (empty($client['Client']['tel'])) {
                                $tel = 0;
                            } else {
                                $tel = $client['Client']['tel'];
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Profile header-->

        <!--begin::Info card-->
        <div class="card mb-5 mb-xl-8">
            <?php if ($client['Type']['name'] == 'Médecin' || $client['Type']['id'] == '5') { ?>
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            $typ = strtoupper(substr($client['Category']['name'], 0, 3));
                            cv_row('Code', $client['Secteur']["code_region"] . $client['Secteur']["code_ville"] . $client['Secteur']["code_secteur"] . $typ . $client['Client']['id']);
                            cv_row('Type', $client['Type']['name']);
                            cv_row('Secteur', $client['Secteur']['full_name']);
                            cv_row('Catégorie', $client['Category']['name']);
                            cv_row('Tendance', $client['Category1']['name']);
                            cv_row('Titre', h($client['Client']['titre']));
                            cv_row('Activité', h($client['Client']['activite']));
                            if (!empty($client['Hopital']['name'])) {
                                cv_row('Hôpital', h($client['Hopital']['name']));
                            }
                            cv_row('Exercice', h($client['Client']['exercice']));
                            ?>
                        </div>
                        <div class="col-md-6 border-start">
                            <?php
                            cv_row('GSM', h($client['Client']['tel']));
                            cv_row('E-mail', h($client['Client']['mail']));
                            cv_row('Fixe', h($client['Client']['fixe']));
                            cv_row('Fax', h($client['Client']['fax']));
                            cv_row('Adresse', h($client['Client']['adress']));
                            $cc = explode(' ', $client['Client']['created']);
                            cv_row('Date de recrutement', $cc[0]);
                            ?>
                            <div class="d-flex flex-stack border-bottom border-gray-200 py-2">
                                <div class="fw-bold text-gray-600 fs-7 text-uppercase">Vendeurs</div>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#popup_vendor">
                                        <i class="ki-duotone ki-people fs-4 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                        <span class="count_vd"><?php echo count($vendeurs ?? []); ?></span>
                                    </button>
                                </div>
                            </div>
                            <?php cv_row('Remarque', $client['Client']['rmq']); ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            cv_row('Code Wavesoft', $client['Client']['code_wavsoft']);
                            $clientcall = array("0" => "Non", "1" => "Oui");
                            cv_row("Client de centre d'appel", $clientcall[$client['Client']['client_call']]);
                            cv_row('Type', $client['Type']['name']);
                            cv_row('Dirigeant', $client['Client']['dirigent']);
                            cv_row('Secteur', $client['Secteur']['full_name']);
                            cv_row('Adresse', h($client['Client']['adress']));
                            cv_row('Date de recrutement', h($client['Client']['date_recrutement']));
                            ?>
                        </div>
                        <div class="col-md-6 border-start">
                            <?php
                            cv_row('GSM', h($client['Client']['tel']));
                            cv_row('E-mail', h($client['Client']['mail']));
                            cv_row('Fixe', h($client['Client']['fixe']));
                            cv_row('Fax', h($client['Client']['fax']));
                            cv_row('Présentoir', h($client['Client']['dirigent']));
                            ?>
                            <div class="d-flex flex-stack border-bottom border-gray-200 py-2">
                                <div class="fw-bold text-gray-600 fs-7 text-uppercase">Vendeurs</div>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#popup_vendor">
                                        <i class="ki-duotone ki-people fs-4 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                        <span class="count_vd"><?php echo is_array($vendeurs) ? count($vendeurs) : "0"; ?></span>
                                    </button>
                                </div>
                            </div>
                            <?php cv_row('Remarque', $client['Client']['rmq']); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
            $buttonCount = 0;
            if ($client['Type']['name'] == 'Pharmacie') {
                $buttonCount++;
            }
            if (
                $this->requestAction('/droits/getrole/clients/edit') == 1 ||
                $this->requestAction('/droits/getrole/clientsproposes/edit') == 1
            ) {
                $buttonCount++;
            }
            ?>
            <?php if ($buttonCount > 0): ?>
                <div class="card-footer d-flex gap-3 flex-wrap">
                    <?php if ($client['Type']['name'] == 'Pharmacie') { ?>
                        <button type="button" class="btn btn-primary flex-grow-1 export-client-btn" data-client-id="<?php echo $client['Client']['id']; ?>">
                            Exporter
                        </button>
                    <?php } ?>
                    <?php
                    if ($this->requestAction('/droits/getrole/clients/edit') == 1)
                        echo $this->Html->link('Editer', array('action' => 'edit', $client['Client']['id']), array('class' => 'btn btn-light-warning flex-grow-1'));
                    else if ($this->requestAction('/droits/getrole/clientsproposes/edit') == 1)
                        echo $this->Html->link('Proposer une modification', array('controller' => 'clientsproposes', 'action' => 'edit', $client['Client']['id']), array('class' => 'btn btn-light-warning flex-grow-1'));
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <!--end::Info card-->

        <!--begin::Historique des actions-->
        <?php if (!empty($client['Action'])): ?>
            <div class="card mb-5 mb-xl-8">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Historique des actions</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gy-4 mb-0">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="ps-4">Responsable</th>
                                    <th>Gamme</th>
                                    <th>Date début</th>
                                    <th>Date fin</th>
                                    <th>Durée</th>
                                    <th>Reste</th>
                                    <th>Etat</th>
                                    <th class="text-end pe-4"></th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                <?php foreach ($client['Action'] as $action): ?>
                                    <tr>
                                        <td class="ps-4"><?php echo $this->requestAction('/users/system_get_name_user/' . $action['user_id']); ?></td>
                                        <td><?php echo $action['game_id']; ?></td>
                                        <td><?php echo strftime("%A %d-%m-%Y", strtotime($action['date_debut'])); ?></td>
                                        <td><?php echo strftime("%A %d-%m-%Y", strtotime($action['date_fin'])); ?></td>
                                        <td><?php
                                            $now = strtotime($action['date_debut']);
                                            $your_date = strtotime($action['date_fin']);
                                            $datediff = $your_date - $now;
                                            $j = floor($datediff / (60 * 60 * 24));
                                            echo "$j jours";
                                            ?></td>
                                        <td><?php
                                            $now = time();
                                            $your_date = strtotime($action['date_fin']);
                                            $datediff = $your_date - $now;
                                            $j = floor($datediff / (60 * 60 * 24));
                                            if ($action['date_debut'] > date('Y-m-d'))
                                                echo '----';
                                            else if ($j >= 0)
                                                echo "$j jours";
                                            else
                                                echo '----';
                                            ?></td>
                                        <td><?php
                                            if ($action['date_debut'] > date('Y-m-d'))
                                                echo '<span class="badge badge-light-warning">Prochainement</span>';
                                            else if ($j >= 0)
                                                echo '<span class="badge badge-light-success">En cours</span>';
                                            else
                                                echo '<span class="badge badge-light-danger">Terminé</span>';
                                            ?></td>
                                        <td class="text-end pe-4">
                                            <?php if ($this->requestAction('/droits/getrole/actions/edit') == 1 || $this->requestAction('/droits/getrole/actions/valider') == 1): ?>
                                                <a href="#" class="btn btn-sm btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                                    Action
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                                </a>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-3" data-kt-menu="true">
                                                    <?php
                                                    if ($this->requestAction('/droits/getrole/actions/edit') == 1) {
                                                        if ($action['date_debut'] > date('Y-m-d') || $j >= 0) {
                                                            echo '<div class="menu-item px-3">' . $this->Html->link('Editer', array('controller' => 'actions', 'action' => 'edit', $action['id']), array('class' => 'menu-link px-3')) . '</div>';
                                                        }
                                                    }
                                                    if ($this->requestAction('/droits/getrole/actions/valider') == 1) {
                                                        echo '<div class="menu-item px-3">' . $this->Html->link('archiver', array('controller' => 'actions', 'action' => 'valider', $action['id'], -1), array('class' => 'menu-link px-3')) . '</div>';
                                                    }
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!--end::Historique des actions-->

        <!--begin::Liste des affectations-->
        <?php if ($this->requestAction('/droits/getrole/listes/remplire') == 1): ?>
            <div class="card mb-5 mb-xl-8">
                <div class="card-header">
                    <h3 class="card-title fw-bold">La liste des affectations</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gy-4 mb-0">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="ps-4">VMP</th>
                                    <th>Liste</th>
                                    <th>Date</th>
                                    <th class="pe-4">Désaffectation</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                <?php foreach ($client['Affectation'] as $action):
                                    $liste = $this->requestAction('/listes/system_get_liste/' . $action['liste_id']);
                                    if (empty($liste)) {
                                        $liste['User']['name'] = $liste['Liste']['name'] = $liste['User']['id'] = '--';
                                    }
                                ?>
                                    <tr>
                                        <td class="ps-4"><?php echo $this->Html->link($liste['User']['name'], array('controller' => 'users', 'action' => 'view', $liste['User']['id'])); ?></td>
                                        <td><?php echo $this->Html->link($liste['Liste']['name'], array('controller' => 'listes', 'action' => 'view', $action['liste_id'])); ?></td>
                                        <td><?php echo $action['created']; ?></td>
                                        <td class="pe-4"><?php
                                            if ($action['valide'] == 1)
                                                echo $this->Html->link("Désaffecter", array('action' => 'desafecter', $client['Client']['id'], $action['id']));
                                            else
                                                echo $action['modified'];
                                            ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    $users = $this->requestAction('/users/system_get_all_user_vmp_superviseur_coordinateur');
                    echo $this->Form->create('Clients', array("url" => array('action' => 'desafecter')));
                    echo $this->Form->hidden('client_id', array("value" => $client['Client']['id']));
                    ?>
                    <div class="d-flex gap-4 flex-wrap align-items-end p-4 border-top">
                        <div class="flex-grow-1" style="min-width:220px;">
                            <label for="regions" class="form-label fs-7 fw-bold text-gray-600 text-uppercase">VMP</label>
                            <select class="form-select form-select-solid" id="regions">
                                <option value="0">Choisissez un VMP</option>
                                <?php foreach ($users as $userid => $username) { ?>
                                    <option value="<?php echo $userid; ?>"><?php echo $username; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="flex-grow-1" style="min-width:220px;" id="ville"></div>
                        <?php echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary submit', 'div' => false)); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!--end::Liste des affectations-->

        <!--begin::Activity card (visites / appels / stock tabs)-->
        <div class="card mb-5 mb-xl-8">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <i class="ki-duotone ki-map fs-1 text-primary me-3 lh-0"><span class="path1"></span><span class="path2"></span></i>
                    <h3 class="fw-bold m-0 text-gray-800">Activité client</h3>
                </div>
                <div class="card-toolbar m-0">
                    <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bold" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a id="tab_1_tab" class="nav-link justify-content-center text-active-gray-800 active" data-bs-toggle="tab" role="tab" href="#tab_1" aria-selected="true">
                                Les visites
                            </a>
                        </li>
                        <?php if (AuthComponent::user('role') == 'Admin'): ?>
                            <li class="nav-item" role="presentation">
                                <a id="tab_2_tab" class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab" role="tab" href="#tab_2" aria-selected="false" tabindex="-1">
                                    Les appels
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a id="tab_3_tab" class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab" role="tab" href="#tab_3" aria-selected="false" tabindex="-1">
                                    Stock temps réel
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">

                    <!--begin::Tab panel: Visites-->
                    <div id="tab_1" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="tab_1_tab">
                        <div class="timeline timeline-border-dashed">
                            <?php
                            $ii = 0;
                            $mapinf = array();
                            $currentDateLabel = null;
                            foreach ($client['Visite'] as $visite):
                                $user_id = 0;
                                $visite['date'] = explode(' ', $visite['date']);
                                if ($user_id != $visite['user_id'])
                                    $user = $this->requestAction('/users/system_get_name_user/' . $visite['user_id']);
                                if (AuthComponent::user('role') == 'VMP' || AuthComponent::user('role') == 'Coordinateur') {
                                    $super = $this->requestAction('/users/system_get_if_super/' . $visite['user_id']);
                                    if ($super == 0) { /* ok */ } else continue;
                                }
                                $pos = strpos($visite['longitude'], "n");
                                $poss = strpos($visite['longitude'], "0.0");
                                if (!empty($visite['longitude']) && $pos === false && $poss === false) {
                                    $mapinf['visite'][] = "'" . $user . "'," . str_replace(",", ".", $visite['latitude']) . "," . str_replace(",", ".", $visite['longitude']) . ",'" . $visite['date'][0] . "'";
                                }
                                $isV2 = false;
                                $isPharmacieV2 = false;
                                if (!empty($visite['produit_adoption']) && substr(trim($visite['produit_adoption']), 0, 1) === '{') {
                                    $_tmpPa = json_decode($visite['produit_adoption'], true);
                                    if (is_array($_tmpPa)) {
                                        $_first = reset($_tmpPa);
                                        if (is_array($_first)) {
                                            if (array_key_exists('objections', $_first) || array_key_exists('adoption', $_first)) {
                                                $isV2 = true;
                                            } elseif (array_key_exists('disponibilite', $_first) || array_key_exists('produit_conseille', $_first)) {
                                                $isPharmacieV2 = true;
                                            }
                                        }
                                    }
                                }
                                if (!$isV2 && !$isPharmacieV2 && !empty($visite['concurrence_p']) && substr(trim($visite['concurrence_p']), 0, 1) === '[') {
                                    $_tmpCc = json_decode($visite['concurrence_p'], true);
                                    if (is_array($_tmpCc)) {
                                        $_first = reset($_tmpCc);
                                        if (is_array($_first)) {
                                            if (array_key_exists('frequence', $_first)) {
                                                $isV2 = true;
                                            } elseif (array_key_exists('type_offre', $_first) || array_key_exists('produit_concurrent', $_first)) {
                                                $isPharmacieV2 = true;
                                            }
                                        }
                                    }
                                }
                                if (!$isV2 && !$isPharmacieV2) {
                                    if (!empty($visite['distribution_emg']) || !empty($visite['requete_crm']) || !empty($visite['objectif_visite'])) {
                                        if ($client['Type']['name'] == 'Pharmacie') {
                                            $isPharmacieV2 = true;
                                        } else {
                                            $isV2 = true;
                                        }
                                    }
                                }
                                $dateLabel = strftime("%A %d-%m-%Y", strtotime($visite['date'][0]));
                            ?>

                            <?php if ($dateLabel !== $currentDateLabel): $currentDateLabel = $dateLabel; ?>
                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-icon">
                                    <i class="ki-duotone ki-calendar fs-2 text-gray-500"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <div class="timeline-content mb-5 mt-n1">
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-light-danger fw-bold me-2"><?php echo $dateLabel; ?></span>
                                        <span class="badge badge-light-success fw-bold"><?php echo $visite["timer"]; ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-icon">
                                    <i class="ki-duotone ki-user fs-2 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <div class="timeline-content mb-10 mt-n1">
                                    <div class="pe-3 mb-5">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h3 class="fs-5 fw-semibold m-0 text-gray-800"><?php echo $user; ?></h3>
                                            <span class="badge badge-light-info">
                                                <i class="ki-duotone ki-<?php echo ($visite['type_visite'] == 'solo') ? 'profile-user' : 'people'; ?> fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>
                                                <?php echo $visite['type_visite']; ?>
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center mt-1 fs-6">
                                            <i class="ki-duotone ki-time fs-6 text-muted me-1"><span class="path1"></span><span class="path2"></span></i>
                                            <span class="text-muted fs-7">
                                                <?php
                                                if ($visite['date'][1] == "00:00:00") {
                                                    $visite['date'][1] = explode(" ", $visite['created']);
                                                    $visite['date'][1] = $visite['date'][1][1];
                                                }
                                                echo $visite['date'][1]; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="timeline-body">
                                        <?php
                                        if ($isV2) {
                                            echo $this->element('clients/visite_item_v2', compact('visite', 'client'));
                                        } elseif ($isPharmacieV2) {
                                            echo $this->element('clients/visite_item_pharmacie_v2', compact('visite', 'client'));
                                        } else {
                                            echo $this->element('clients/visite_item_v1', compact('visite', 'client', 'ii', 'gammes', 'produits'));
                                        }
                                        echo '<div class="mt-5">';
                                            echo $this->element('clients/visite_item_v1', compact('visite', 'client', 'ii', 'gammes', 'produits'));
                                        echo '</div>';
                                        ?>
                                    </div>

                                    <div class="d-flex align-items-center mt-4">
                                        <?php if ($this->requestAction('/droits/getrole/visites/edit') == 1): ?>
                                            <a class="btn btn-icon btn-light btn-active-light-primary btn-sm me-2"
                                               href="<?php echo $this->Html->url(array('controller' => 'visites', 'action' => 'edit', $visite['id'])); ?>"
                                               title="Editer">
                                                <i class="ki-duotone ki-pencil fs-4"><span class="path1"></span><span class="path2"></span></i>
                                            </a>
                                        <?php endif;
                                        if ($this->requestAction('/droits/getrole/visites/archive') == 1): ?>
                                            <a class="btn btn-icon btn-light btn-active-light-danger btn-sm me-2"
                                               href="<?php echo $this->Html->url(array('controller' => 'visites', 'action' => 'archive', $visite['id'], 0)); ?>"
                                               title="Archive">
                                                <i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php
                                        if (!empty($visite['latitude']) && AuthComponent::user('role') != 'VMP' && AuthComponent::user('role') != 'Coordinateur' && AuthComponent::user('role') != "Super viseur") {
                                            $pos = strpos($visite['longitude'], "n");
                                            $poss = strpos($visite['longitude'], "0.0");
                                            if (!empty($visite['longitude']) && $pos === false && $poss === false) {
                                                echo '<a data-bs-toggle="modal" onclick="clikgeo(' . $ii . ')" data-bs-target="#myModalmap" class="btn btn-icon btn-light btn-active-light-danger btn-sm" title="Position visite">'
                                                    . '<input type="hidden" class="latc' . $ii . '" value="' . str_replace(",", ".", $client['Client']['longitude']) . '">'
                                                    . '<input type="hidden" class="lengc' . $ii . '" value="' . str_replace(",", ".", $client['Client']['latitude']) . '">'
                                                    . '<input type="hidden" class="latv' . $ii . '" value="' . str_replace(",", ".", $visite['latitude']) . '">'
                                                    . '<input type="hidden" class="lengv' . $ii . '" value="' . str_replace(",", ".", $visite['longitude']) . '">'
                                                    . '<i class="ki-duotone ki-geolocation fs-4"><span class="path1"></span><span class="path2"></span></i>'
                                                    . '</a>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                                $ii++;
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <!--end::Tab panel: Visites-->

                    <?php if (AuthComponent::user('role') == 'Admin'): ?>
                    <!--begin::Tab panel: Appels-->
                    <div id="tab_2" class="card-body p-0 tab-pane fade" role="tabpanel" aria-labelledby="tab_2_tab">
                        <?php
                        $appels = $this->requestAction("/rapportprocpects/system_get_appel_for_client/" . $client['Client']['id']);
                        foreach ($appels as $appel):
                            $appeldate = explode(" ", $appel["Rapportprocpect"]["created"]);
                        ?>
                        <div class="timeline timeline-border-dashed mb-5">
                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-icon">
                                    <i class="ki-duotone ki-calendar fs-2 text-gray-500"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <div class="timeline-content mb-3 mt-n1">
                                    <span class="badge badge-light-danger fw-bold"><?php echo strftime("%A %d-%m-%Y", strtotime($appeldate[0])); ?></span>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-icon">
                                    <i class="ki-duotone ki-phone fs-2 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <div class="timeline-content mb-10 mt-n1">
                                    <div class="pe-3 mb-5">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                            <h3 class="fs-5 fw-semibold m-0 text-gray-800">
                                                <?php echo $appel["User"]["name"] . " (" . $appel["Rapportprocpect"]["type_user"] . ")"; ?>
                                            </h3>
                                            <span class="badge badge-light-info">
                                                <i class="ki-duotone ki-time fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>
                                                <?php echo $appel["Rapportprocpect"]["duree"]; ?>
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center mt-1 fs-6">
                                            <span class="text-muted fs-7"><?php echo $appeldate[1]; ?></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column gap-2">
                                                <?php
                                                cv_row('Campagne', $appel["Prospectfeuille"]["prospectcompagne"]);
                                                cv_row('Connaissance produit ?', $appel["Rapportprocpect"]["connaissance"]);

                                                if ($appel["Rapportprocpect"]["connaissance"] == "Oui"):
                                                    cv_row('Disponibilité produit ?', $appel["Rapportprocpect"]["disponibilite"]);
                                                    cv_row('Avez vous réalisé des ventes ?', $appel["Rapportprocpect"]["vente"]);
                                                    if ($appel["Rapportprocpect"]["vente"] == "Oui"):
                                                        cv_row('Si oui, comment ?', $appel["Rapportprocpect"]["comment"]);
                                                    endif;
                                                endif;

                                                cv_row('Voulez vous qu\'un commercial ?', $appel["Rapportprocpect"]["commercial"]);

                                                if ($appel["Rapportprocpect"]["commercial"] == "Non"):
                                                    cv_row('Mise en place produit de la campagne', $appel["Rapportprocpect"]["commande"]);
                                                endif;

                                                cv_row('Pack hors campagne', $appel["Rapportprocpect"]["hors_campagne"]);
                                                cv_row('Degré de satisfaction Call Center', $appel["Rapportprocpect"]["appreciation"] . ' %');
                                                cv_row('Questions', $appel["Rapportprocpect"]["question"]);
                                                cv_badges('Objections', $appel["Rapportprocpect"]["objection"]);
                                                cv_badges('Réclamations', $appel["Rapportprocpect"]["reclamation"]);
                                                cv_badges('Qualifications', $appel["Rapportprocpect"]["qualification"]);
                                                cv_row('Propositions', $appel["Rapportprocpect"]["proposition"]);
                                                cv_row('Type Achat Direct Nombre de CMD', $appel["Rapportprocpect"]["type_achat_direct"]);
                                                cv_row('Type Achat Grossiste Nombre de CMD', $appel["Rapportprocpect"]["type_achat_grossiste"]);
                                                cv_row('Fréquence Passage Commercial', $appel["Rapportprocpect"]["frequence_passage_commercial"]);
                                                cv_row('Commande Groupée', $appel["Rapportprocpect"]["commande_groupee"]);
                                                cv_badges('Objections client', $appel["Rapportprocpect"]["objection_two"]);
                                                cv_row('Statut Client', $appel["Rapportprocpect"]["statut_client"]);
                                                ?>
                                            </div>
                                        </div>

                                        <?php if ($appel["Prospectfeuille"]["commercial_type"] != null): ?>
                                        <div class="col-md-6 border-start">
                                            <div class="d-flex flex-column gap-2">
                                                <?php
                                                cv_row("Type d'action", $appel["Prospectfeuille"]["commercial_type"]);
                                                cv_row('Commercial', $appel["Prospectfeuille"]["commercial_user_wavesoft"]);

                                                $oppText = $appel["Prospectfeuille"]["commercial_opportunite"];
                                                $oppText .= !empty($appel["Prospectfeuille"]["commercial_produits"])
                                                    ? " (" . $appel["Prospectfeuille"]["commercial_produits"] . ")"
                                                    : " (" . $appel["Prospectfeuille"]["commercial_raison"] . ")";
                                                cv_row('Opportunité concrétisée', $oppText);

                                                cv_row('Date de ' . $appel["Prospectfeuille"]["commercial_type"], $appel["Prospectfeuille"]["commercial_date"]);
                                                cv_row('Commentaire', $appel["Prospectfeuille"]["commercial_commentaire"]);
                                                ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="d-flex align-items-center mt-4">
                                        <?php if ($this->requestAction('/droits/getrole/rapportprocpects/supprimer') == 1): ?>
                                            <a class="btn btn-icon btn-light btn-active-light-danger btn-sm"
                                               href="<?php echo $this->Html->url(array('controller' => 'rapportprocpects', 'action' => 'supprimer', $appel["Rapportprocpect"]['id'])); ?>"
                                               title="Supprimer">
                                                <i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!--end::Tab panel: Appels-->

                    <!--begin::Tab panel: Stock temps réel-->
                    <div id="tab_3" class="card-body p-0 tab-pane fade" role="tabpanel" aria-labelledby="tab_3_tab">
                        <?php
                        foreach ($stockreel as $stock):
                            $appeldate = explode(" ", $stock["Stockvisite"]["created"]);
                        ?>
                        <div class="timeline timeline-border-dashed mb-5">
                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-icon">
                                    <i class="ki-duotone ki-calendar fs-2 text-gray-500"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <div class="timeline-content mb-3 mt-n1">
                                    <span class="badge badge-light-danger fw-bold"><?php echo strftime("%A %d-%m-%Y", strtotime($appeldate[0])); ?></span>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-icon">
                                    <i class="ki-duotone ki-package fs-2 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <div class="timeline-content mb-10 mt-n1">
                                    <div class="pe-3 mb-5">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h3 class="fs-5 fw-semibold m-0 text-gray-800"><?php echo $stock["User"]["name"]; ?></h3>
                                            <span class="text-muted fs-7"><?php echo date("H:i:s", strtotime($appeldate[1])); ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex flex-stack border-bottom border-gray-200 py-2">
                                            <div class="fw-bold text-gray-600 fs-7 text-uppercase">Produit</div>
                                            <div class="text-end"><span class="badge badge-light-success"><?php echo $stock["Produit"]["name"]; ?></span></div>
                                        </div>
                                        <?php
                                        cv_row('Quantite', $stock["Stockvisite"]["quantite"]);
                                        cv_row('Type', $stock["Stockvisite"]["type"]);
                                        cv_row('Commentaire', $stock["Stockvisite"]["commentaire"]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!--end::Tab panel: Stock temps réel-->
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <!--end::Activity card-->

        <!--begin::Commandes-->
        <?php if (!empty($client['Commande'])): ?>
            <div class="card mb-5 mb-xl-8">
                <div class="card-header">
                    <h3 class="card-title fw-bold"><?php echo __('Commandes'); ?></h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gy-4 mb-0">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="ps-4"><?php echo __('VMP'); ?></th>
                                    <th><?php echo __('Quantité des produits'); ?></th>
                                    <th><?php echo __('Total en Dhs'); ?></th>
                                    <th><?php echo __('Date de création'); ?></th>
                                    <th class="pe-4"></th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                <?php foreach ($client['Commande'] as $commande): ?>
                                    <tr>
                                        <td class="ps-4"><?php echo $this->requestAction('/users/system_get_name_user/' . $commande['user_id']); ?></td>
                                        <td><?php
                                            $info = $this->requestAction('/commandes/system_get_total_and_quantite/' . $commande['id']);
                                            $info = explode('||', $info);
                                            echo $info[1];
                                            ?></td>
                                        <td><?php echo $info[0]; ?> Dhs</td>
                                        <td><?php echo $commande['created']; ?></td>
                                        <td class="pe-4">
                                            <?php echo $this->Html->link(__('Visualiser'), array('controller' => 'commandes', 'action' => 'view', $commande['id']), array('class' => 'btn btn-sm btn-light-primary')); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!--end::Commandes-->

        <!--begin::Map card-->
        <?php if (AuthComponent::user('role') != 'VMP' && AuthComponent::user('role') != 'Coordinateur' && AuthComponent::user('role') != "Super viseur") { ?>
            <div class="card mb-5 mb-xl-8">
                <div class="card-header">
                    <h3 class="card-title fw-bold">La liste des visites sur map</h3>
                </div>
                <div class="card-body">
                    <div id="maap-canvas" style="min-height: 400px;border-radius:0.475rem;overflow:hidden;"></div>
                </div>
            </div>
        <?php } ?>
        <!--end::Map card-->

    </div>
    <!--./col-xl-8-->

    <!--begin::Sidebar-->
    <div class="col-xl-4">

        <!--begin::Last visit-->
        <div class="card mb-5">
            <div class="card-body d-flex align-items-center">
                <div class="symbol symbol-45px me-4">
                    <span class="symbol-label bg-light-primary">
                        <i class="ki-duotone ki-calendar fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    </span>
                </div>
                <div>
                    <h4 class="fw-bold m-0 fs-6"><?php
                        if (!empty($client['Visite']))
                            echo strftime("%A %d-%m-%Y", strtotime($client['Visite'][0]['date']));
                        else
                            echo '---';
                        ?></h4>
                    <p class="text-muted fs-7 m-0">Date dernière visite</p>
                </div>
            </div>
        </div>
        <!--end::Last visit-->

        <!--begin::Gadgets-->
        <?php if ($this->requestAction('/droits/getrole/gadgetclients/add') == 1): ?>
            <div class="card mb-5">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Gadgets</h3>
                </div>
                <div class="card-body" style="max-height:520px;overflow-y:auto;">
                    <?php foreach ($gadgetclientall as $gadget): ?>
                        <div class="border border-dashed border-gray-300 rounded p-4 mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge badge-light-primary"><?php echo $gadget['Gadgetclient']['created']; ?></span>
                                <span class="badge badge-light-warning"><?php echo $gadget['User']['name']; ?></span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3 class="fs-6 fw-bold m-0"><?php echo $gadget['Gadgetclient']['name']; ?></h3>
                                <span class="badge badge-light fs-4 fw-bold px-4 py-2"><?php echo $gadget['Gadgetclient']['quantite']; ?></span>
                            </div>
                            <?php if ($this->requestAction('/droits/getrole/gadgetclients/supprimer') == 1): ?>
                                <div class="mt-3">
                                    <?php echo $this->Html->link("Supprimer", array("controller" => "gadgetclients", "action" => "supprimer", $gadget['Gadgetclient']['id']), array('class' => 'btn btn-sm btn-light-danger')); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <!--end::Gadgets-->

    </div>
    <!--end::Sidebar-->
</div>

<!--begin::Vendor modal-->
<div class="modal fade" id="popup_vendor" tabindex="-1" role="dialog" aria-labelledby="popup_vendorLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold" id="popup_vendorLabel">Les vendeurs</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <?php if ($client['Client']["vendeur"] != '' && is_array($vendeurs)) { ?>
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gy-4">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th>Nom</th>
                                    <th>Tel</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                <?php foreach ($vendeurs as $vendeur): ?>
                                    <tr>
                                        <td><?php echo $vendeur['nom']; ?></td>
                                        <td><?php echo $vendeur['tel']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<!--end::Vendor modal-->

<!--begin::Gadget modal-->
<div id="gadget_modal" class="modal">
    <div class="modal-content p-6">
        <?php
        echo $this->Form->create('Gadgetclient', array("url" => array("controller" => "gadgetclients", "action" => "add")));
        echo $this->Form->hidden('client_id', array('value' => $client["Client"]["id"]));
        echo $this->Form->input('gadgetclient_id', array("name" => "data[Gadgetclient][name]", 'class' => 'form-control form-control-solid'));
        echo $this->Form->input('quantite', array('class' => 'form-control form-control-solid', 'required' => 'required'));
        ?>
        <div class="modal-footer">
            <input type="submit" value="Envoyer" class="btn btn-primary">
        </div>
    </div>
</div>
<!--end::Gadget modal-->

</div>
<!-- /.client-view -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#GadgetclientGadgetclientId').select2({
            tags: true
        });
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuwmNaUU3JfRgdkYbhaV0hptTkcTKqn8Q&amp;"></script>
<script>
    function boxtog(id) {
        $('.box' + id).toggle(200);
        var clas = $("#icon" + id).attr("class");
        if (clas == 'ki-duotone ki-minus fs-3') {
            $("#icon" + id).attr("class", "ki-duotone ki-plus fs-3");
        }
        if (clas == 'ki-duotone ki-plus fs-3') {
            $("#icon" + id).attr("class", "ki-duotone ki-minus fs-3");
        }
    }

    $(document).ready(function() {

        $('.export-client-btn').on('click', function(e) {
            var clientId = $(this).data('client-id');
            $('#modal_return').modal('show');
            $('#export-message').html('<div class="text-center"><i class="ki-duotone ki-loading fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i><p class="mt-3 mb-0">Export en cours...</p></div>');

            $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'clients', 'action' => 'system_export_client')); ?>/' + clientId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#export-message').html('<div class="alert alert-success">' + response.message + '</div>');
                    } else {
                        $('#export-message').html('<div class="alert alert-success">Client exported successfully</div>');
                    }
                    setTimeout(function() {
                        $('#modal_return').modal('hide');
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    var errorMessage;
                    try {
                        var response = JSON.parse(xhr.responseText);
                        errorMessage = response.message || response.error || 'An error occurred during export';
                    } catch (e) {
                        errorMessage = 'An error occurred during export';
                    }
                    $('#export-message').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                }
            });
        });

        $("#regions").change(function() {
            var id = $("#regions").val();
            var image = "<center><img src='/img/loading.gif' style='width: 30px;' ></center>";
            $("#ville").empty();
            $(image).appendTo("#ville");
            $("#ville").show();
            $.post(
                '/listes/system_get_liste_for_user_client_view/' + id, {},
                function(data) {
                    $("#ville").empty();
                    $(data).appendTo("#ville");
                    $("#ville").show();
                },
                'text'
            );
        });
    });
</script>
<script type="text/javascript">
    function objettog(id) {
        $('.optionb' + id).toggle();
        // TODO #18 closed 2026-07-23. Each view carries its OWN copy of this
        // function next to its own markup -- there is no cross-file coupling.
        // This view emits no .objet/.optionh markup at all (that lives in
        // Rapports/*, now migrated, and Users/admin_statistique.ctp, still on
        // Font Awesome but self-contained), so this function is inert here.
        // Kept and moved to Keenicons for consistency with Rapports.
        var clas = $(".optionh" + id + " .ki-duotone").attr("class");
        if (clas == 'ki-duotone ki-minus fs-6') {
            $(".optionh" + id + " .ki-duotone").attr("class", "ki-duotone ki-plus fs-6");
        }
        if (clas == 'ki-duotone ki-plus fs-6') {
            $(".optionh" + id + " .ki-duotone").attr("class", "ki-duotone ki-minus fs-6");
        }
    }

    function pup(i, id, prod) {
        var product = $("." + id + " .pup" + i).attr('title');
        $(".modal-title").text("Objections pour : " + product);
        var objet = $("." + id + " ." + prod).length;
        var table = $('#myModal .table');
        table.html('');
        for (var io = 0; io < objet; io++) {
            var option = $("." + id + " ." + prod + ":eq(" + io + ") .optionb li").length;
            var tr = '<tr><th>' + $("." + id + " ." + prod + ":eq(" + io + ") .optionh").text() + '</th></tr>';
            table.append(tr);
            for (var op = 0; op < option; op++) {
                var tdc = $("." + id + " ." + prod + ":eq(" + io + ") .optionb li:eq(" + op + ")").text();
                td = '<td>&nbsp;' + tdc + '</td>';
                $("#myModal .table tbody tr:eq(" + io + ")").append(td);
            }
        }
        $("#myModal").modal();
    }

    function pup1(i, id, prod) {
        var product = $("." + id + " .pup" + i).attr('title');
        $(".modal-title").text("Veille pour : " + product);
        var objet = $("." + id + " ." + prod).length;
        var table = $('#myModal1 .table');
        $('#myModal1 .table tbody').html('');
        for (var io = 0; io < objet; io++) {
            var option = $("." + id + " ." + prod + ":eq(" + io + ") .optionb li").length;
            var tr = '<tr></tr>';
            table.append(tr);
            for (var op = 0; op < option; op++) {
                var tdc = $("." + id + " ." + prod + ":eq(" + io + ") .optionb li:eq(" + op + ")").text();
                td = '<td>&nbsp;' + tdc + '</td>';
                $("#myModal1 .table tbody tr:eq(" + io + ")").append(td);
            }
        }
        $("#myModal1").modal();
    }

    function pup2(i, id, prod) {
        var product = $("." + id + " .pup" + i).attr('title');
        $(".modal-title").text("Concurrence pour : " + product);
        var objet = $("." + id + " ." + prod).length;
        var table = $('#myModal2 .table');
        $('#myModal2 .table tbody').html('');
        for (var io = 0; io < objet; io++) {
            var option = $("." + id + " ." + prod + ":eq(" + io + ") .optionb li").length;
            var tr = '<tr></tr>';
            table.append(tr);
            for (var op = 0; op < option; op++) {
                var tdc = $("." + id + " ." + prod + ":eq(" + io + ") .optionb li:eq(" + op + ")").text();
                td = '<td>&nbsp;' + tdc + '</td>';
                $("#myModal2 .table tbody tr:eq(" + io + ")").append(td);
            }
        }
        $("#myModal2").modal();
    }

    var locations1 = [<?php
                        if (!empty($mapinf['visite'])) {
                            foreach ($mapinf['visite'] as $value) {
                                echo '[' . $value . '],';
                            }
                        }
                        ?>];
    var locations = [];
    var leafletMap = null;

    function clikgeo(id) {
        var lat = parseFloat($(".latv" + id).attr("value"));
        var lng = parseFloat($(".lengv" + id).attr("value"));
        setTimeout(function() {
            var container = document.getElementById('map-canvas');
            if (leafletMap) { leafletMap.remove(); leafletMap = null; }
            container.innerHTML = '';
            container.style.height = '450px';
            leafletMap = L.map('map-canvas').setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap',
                maxZoom: 19
            }).addTo(leafletMap);
            L.marker([lat, lng]).addTo(leafletMap).bindPopup('<b>Position visite</b>').openPopup();
            <?php if (!empty($client['Client']['latitude'])): ?>
            var clientLat = <?php echo str_replace(",", ".", $client['Client']['latitude']); ?>;
            var clientLng = <?php echo str_replace(",", ".", $client['Client']['longitude']); ?>;
            if (clientLat && clientLng) {
                L.marker([clientLat, clientLng], {
                    icon: L.icon({iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png', shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34]})
                }).addTo(leafletMap).bindPopup('<b>Position client</b>');
            }
            <?php endif; ?>
            leafletMap.invalidateSize();
        }, 400);
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

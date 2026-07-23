<?php
/**
 * Clients :: index — liste des clients + compteurs.
 *
 * Migrated to Metronic 8 (Bootstrap 5). Business logic is untouched:
 * controller variables ($clients, $nb_clients, $nb_client_affecter, $inn),
 * the Droits rights checks, the foreach loop, every Html->link()/Url() and the
 * AJAX search against /clients/system_recherche/ are all exactly as before.
 *
 * Only markup changed:
 *   .small-box/.bg-aqua|green|red  -> Metronic .card stat tiles
 *   .box/.box-header/.box-body     -> .card/.card-header/.card-body
 *   ion-* icons                    -> Keenicons (ki-duotone)
 *   BS3 dropdown data-toggle       -> data-bs-toggle
 *   8 CDN <script> tags + 3 jQuery -> element('assets/datatables')
 */
echo $this->element('layout/page_header', array(
    'title'  => __('La liste des clients'),
    'crumbs' => array('Clients' => null),
));

echo $this->element('assets/datatables');
?>

<!--begin::Compteurs-->
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-sm-6 col-xl-3">
        <a href="<?php echo $this->Html->Url(array('action' => 'index')); ?>" class="text-decoration-none">
            <div class="card card-flush h-100" style="background-color:#7c6ff0;">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="nbmedcin"><?php echo $nb_clients; ?></span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">N° Clients</span>
                    </div>
                </div>
                <div class="card-body d-flex align-items-end pt-0">
                    <i class="ki-duotone ki-profile-user fs-3x text-white opacity-50"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="<?php echo $this->Html->Url(array('action' => 'index', '1')); ?>" class="text-decoration-none">
            <div class="card card-flush h-100 bg-success">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="visitetotal"><?php echo $nb_client_affecter; ?></span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">N° clients affectés</span>
                    </div>
                </div>
                <div class="card-body d-flex align-items-end pt-0">
                    <i class="ki-duotone ki-chart-simple fs-3x text-white opacity-50"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="<?php echo $this->Html->Url(array('action' => 'index', '-1')); ?>" class="text-decoration-none">
            <div class="card card-flush h-100 bg-danger">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="nbuser"><?php echo ($nb_clients - $nb_client_affecter); ?></span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">N° Clients non affectés</span>
                    </div>
                </div>
                <div class="card-body d-flex align-items-end pt-0">
                    <i class="ki-duotone ki-question-2 fs-3x text-white opacity-50">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                </div>
            </div>
        </a>
    </div>

    <?php if ($this->requestAction('/droits/getrole/clients/remettre0') == 1): ?>
        <div class="col-sm-6 col-xl-3">
            <a href="<?php echo $this->Html->Url(array('action' => 'remettre0')); ?>" class="text-decoration-none">
                <div class="card card-flush h-100 bg-dark">
                    <div class="card-header pt-5">
                        <div class="card-title d-flex flex-column">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">Remettre à 0</span>
                            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Tout remettre à 0</span>
                        </div>
                    </div>
                    <div class="card-body d-flex align-items-end pt-0">
                        <i class="ki-duotone ki-minus-circle fs-3x text-white opacity-50"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
            </a>
        </div>
    <?php endif; ?>
</div>
<!--end::Compteurs-->

<!--begin::Recherche-->
<div class="card mb-5">
    <div class="card-header">
        <h3 class="card-title" for="ClientMail">Recherche par client</h3>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-7">
                <input name="data[Client][mail]" class="form-control form-control-solid" type="text" id="recherche"
                       placeholder="Recherche par client">
            </div>
            <div class="col-md-5">
                <button type="button" id="search" class="btn btn-primary">
                    <i class="ki-duotone ki-magnifier fs-3"><span class="path1"></span><span class="path2"></span></i>
                    Rechercher
                </button>
            </div>
        </div>
    </div>
</div>
<!--end::Recherche-->

<!--begin::Liste-->
<div class="card">
    <div class="card-header align-items-center">
        <h3 class="card-title"><?php echo __('La liste des clients'); ?></h3>
        <div class="card-toolbar">
            <?php if ($this->requestAction('/droits/getrole/clients/add') == 1)
                echo $this->Html->link(__('Ajouter'), array('action' => 'add', "Médecin"), array("target" => "_blanck", 'class' => "btn btn-primary btn-sm"));
            ?>
        </div>
    </div>
    <div class="card-body" id="tabclient">
        <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4 gs-4">
            <thead>
                <tr class="fw-bold fs-7 text-gray-800 text-uppercase">
                    <th>Code</th>
                    <th>Type</th>
                    <th>Nom & prénom</th>
                    <th>Activité</th>
                    <th>Region</th>
                    <th>Ville</th>
                    <th>Secteur</th>
                    <th>Spécialité</th>
                    <th>Tendance</th>
                    <th>Pot V1</th>
                    <th>Pot V2</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Nom & prénom</th>
                    <th>Activité</th>
                    <th>Region</th>
                    <th>Ville</th>
                    <th>Secteur</th>
                    <th>Spécialité</th>
                    <th>Tendance</th>
                    <th>Pot V1</th>
                    <th>Pot V2</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody class="fw-semibold text-gray-700">
<?php foreach ($clients as $client): ?>
                <tr>
                    <td><?php $typ=substr($client['Category']['name'], 0, 3);
                            $typ = strtoupper($typ);
                            echo $client['Secteur']["code_region"].$client['Secteur']["code_ville"].$client['Secteur']["code_secteur"].$typ.$client['Client']['id'];?>
                    </td>
                    <td><?php echo $this->Html->link($client['Type']['name'], array('controller' => 'types', 'action' => 'view', $client['Type']['id']),array("target"=>"_blanck")); ?></td>
                    <td><?php echo $this->Html->link($client['Client']['nom'].' '.$client['Client']['prenom'], array('action' => 'view', $client['Client']['id']),array("target"=>"_blanck")); ?>&nbsp;</td>
                    <td><?php echo h($client['Client']['activite']); ?>&nbsp;</td>
                    <td><?php echo h($client['Secteur']['region']); ?>&nbsp;</td>
                    <td><?php echo h($client['Secteur']['ville']); ?>&nbsp;</td>
                    <td><?php echo $this->Html->link($client['Secteur']['secteur'], array('controller' => 'secteurs', 'action' => 'view', $client['Secteur']['id']),array("target"=>"_blanck")); ?></td>
                    <td><?php
                            echo $this->Html->link($client['Category']['name'], array('controller' => 'categories', 'action' => 'view', $client['Category']['id']),array("target"=>"_blanck"));
                        ?>
                    </td>
                    <td><?php echo $this->Html->link($client['Category1']['name'], array('controller' => 'categories', 'action' => 'view', $client['Category1']['id']),array("target"=>"_blanck")); ?></td>
                    <td><?php echo h($client['Client']['potentialite']); ?>&nbsp;</td>
                    <td><?php echo h($client['Client']['potentialitev2']); ?>&nbsp;</td>
                    <td class="actions">
                        <button type="button" class="btn btn-light-primary btn-sm btn-flex" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="ki-duotone ki-setting-3 fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                            <i class="ki-duotone ki-down fs-6 ms-1"></i>
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-3"
                             data-kt-menu="true">
                            <div class="menu-item px-3"><?php if ($this->requestAction('/droits/getrole/clients/view') == 1)
                            echo $this->Html->link(__('Voir'), array('action' => 'view', $client['Client']['id']),array("target"=>"_blanck", 'class' => 'menu-link px-3'));
                        ?></div>
                            <div class="menu-item px-3"><?php if ($this->requestAction('/droits/getrole/clients/edit') == 1)
                            echo $this->Html->link(__('Editer'), array('action' => 'edit', $client['Client']['id']),array("target"=>"_blanck", 'class' => 'menu-link px-3'));
                        ?></div>
                            <div class="menu-item px-3"><?php if ($this->requestAction('/droits/getrole/clients/archive') == 1)
                            echo $this->Html->link(__('Archiver'), array('action' => 'archive', $client['Client']['id'], 0),array("target"=>"_blanck", 'class' => 'menu-link px-3'));
                        ?></div>
                        </div>
                    </td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!--end::Liste-->

<?php
// Previously this view loaded jQuery THREE times (jquery-2.2.3.min, a
// code.jquery.com 1.12.4 tag, then DataTables' own deps) plus 8 CDN scripts
// for DataTables + Buttons + JSZip + pdfmake. Metronic's datatables.bundle
// (loaded by the element at the top) already contains DataTables 1.13.5,
// Buttons, JSZip and pdfmake, and jQuery comes from plugins.bundle.js in the
// layout — so all of that is gone. The DataTables config below is unchanged.
$this->Html->scriptStart(array('block' => 'script'));
?>
    $(function () {
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "iDisplayLength": 50,
            "language": {
                "sProcessing":     "Traitement en cours...",
                "sSearch":         "Rechercher&nbsp;:",
                "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix":    "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst":      "Premier",
                    "sPrevious":   "Pr&eacute;c&eacute;dent",
                    "sNext":       "Suivant",
                    "sLast":       "Dernier"
                },
                "oAria": {
                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                }
            },
            dom: 'Bfrtip',
            buttons: [
                 'csv', 'excel', 'print'
            ]
        });
    });
    $(document).ready(function () {
             // Setup - add a text input to each footer cell
           var conte = 0;
         $('#example1 tfoot th').each(function(){
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="'+title+'" class="form-control form-control-sm '+conte+'"/>');
            conte = conte+1;
        });

 // DataTable
    var table = $('#example1').DataTable();

    // Apply the search
    table.columns().every( function () {
        var that = this;

        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
});

    $(document).ready(function () {
        $("#search").click(function () {
            var id = $("#recherche").val();
            if (id.length > 2)
            {
                var image = "<center><img src='/img/loading.gif' style='width: 50px;' ></center>";
                $("#tabclient").empty();
                $(image).appendTo("#tabclient");
                $("#tabclient").show();
                id = id.replace("/", "||");
                $.post(
                        '/clients/system_recherche/' + id+"/<?php echo $inn; ?>",
                        {
                            //id: $("#ChembreBlocId").val()
                        },
                        function (data)
                        {
                            $("#tabclient").empty();
                            $(data).appendTo("#tabclient");
                            $("#tabclient").show();
                        },
                        'text' // type
                        );
            }
        });
    });
<?php $this->Html->scriptEnd(); ?>

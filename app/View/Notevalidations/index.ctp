<?php
echo $this->Html->css('dataTables.bootstrap');
echo $this->Html->css('metronic/css/style.bundle.css');
echo $this->Html->script('metronic/widgets.bundle.js');
echo $this->Html->script('metronic/scripts.bundle.js');
?>

<style>
    /* Scoped custom adjustments over Metronic core */
    .metronic-page-shell {
        background: #f5f7fb;
        padding: 24px 0;
    }

    .metronic-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(22, 32, 77, 0.05);
        overflow: hidden;
    }

    .metronic-card .card-header {
        padding: 20px 28px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .page-title-wrap {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .page-icon {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #f2efff;
        color: #7c6ff0;
        font-size: 18px;
    }

    .page-title-wrap h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #1f2940;
    }

    .page-subtitle {
        margin: 2px 0 0;
        font-size: 12.5px;
        color: #94a3b8;
    }

    .metronic-card .card-body {
        padding: 24px 28px;
    }

    /* Datatable styling */
    #example1 {
        margin: 0 !important;
        width: 100% !important;
    }

    #example1 thead th {
        background-color: #f8fafc !important;
        color: #475569 !important;
        border-bottom: 1px solid #e2e8f0 !important;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 14px 16px !important;
    }

    #example1 tbody td {
        padding: 14px 16px !important;
        font-size: 13.5px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9 !important;
        vertical-align: middle;
    }

    #example1 tbody tr:hover td {
        background-color: #f8fafc !important;
    }

    .list-badge-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .btn-metronic-add {
        background: linear-gradient(135deg, #7c6ff0 0%, #6355e6 100%) !important;
        color: #ffffff !important;
        border-radius: 10px !important;
        border: none !important;
        padding: 10px 20px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 12px rgba(124, 111, 240, 0.25);
        transition: all 0.2s ease;
    }

    .btn-metronic-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(124, 111, 240, 0.35);
    }
</style>

<div class="metronic-page-shell">
    <div class="card metronic-card card-flush">
        <div class="card-header">
            <div class="page-title-wrap">
                <span class="page-icon"><i class="fa fa-shield"></i></span>
                <div>
                    <h3>Les règles de validation</h3>
                    <div class="page-subtitle">Gestion des règles, niveaux et messages</div>
                </div>
            </div>

            <?php
            if ($this->requestAction(array('controller' => 'droits', 'action' => 'getrole', 'notevalidations', 'index')) == 1) {
                echo $this->Html->link(
                    '<i class="fa fa-plus me-1" style="color: #fff;"></i> ' . __('Ajouter'),
                    array('action' => 'add'),
                    array('class' => 'btn btn-metronic-add', 'escape' => false)
                );
            }
            ?>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-row-bordered align-middle gs-0 gy-3">
                    <thead>
                        <tr>
                            <th>Responsables</th>
                            <th>Choix</th>
                            <th>Niveau</th>
                            <th>Mail de validation</th>
                            <th>Mail de refus</th>
                            <th>Date d'ajout</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($notevalidations as $notevalidation): ?>
                        <tr>
                            <!-- Responsables -->
                            <td>
                                <div class="list-badge-wrap">
                                <?php
                                $users_list = array_filter(explode(";", $notevalidation['Notevalidation']['users']));
                                foreach ($users_list as $user_id) {
                                    $name = isset($users[$user_id]) ? $users[$user_id] : $user_id;
                                    echo '<span class="badge badge-light-primary fw-semibold">' . h($name) . '</span>';
                                }
                                ?>
                                </div>
                            </td>

                            <!-- Choix -->
                            <td>
                                <div class="list-badge-wrap">
                                <?php
                                $choix_list = array_filter(explode(";", $notevalidation['Notevalidation']['choix']));
                                foreach ($choix_list as $choix) {
                                    echo '<span class="badge badge-light-info fw-semibold">' . h($choix) . '</span>';
                                }
                                ?>
                                </div>
                            </td>

                            <!-- Niveau -->
                            <td>
                                <span class="badge badge-light-dark fw-bold"><?php echo h($notevalidation['Notevalidation']['niveau']); ?></span>
                            </td>

                            <!-- Mail Validation -->
                            <td>
                                <span class="text-gray-700"><?php echo h($notevalidation['Notevalidation']['messagevalidation']); ?></span>
                            </td>

                            <!-- Mail Refus -->
                            <td>
                                <span class="text-gray-700"><?php echo h($notevalidation['Notevalidation']['messageannulation']); ?></span>
                            </td>

                            <!-- Created -->
                            <td>
                                <span class="text-muted fs-7"><?php echo h($notevalidation['Notevalidation']['created']); ?></span>
                            </td>

                            <!-- Actions -->
                            <td class="text-end">
                                <?php
                                echo $this->Form->postLink(
                                    '<i class="fa fa-trash me-1"></i> ' . __('Supprimer'),
                                    array('action' => 'delete', $notevalidation['Notevalidation']['id']),
                                    array(
                                        'class' => 'btn btn-sm btn-light-danger fw-semibold',
                                        'escape' => false
                                    ),
                                    __('Êtes-vous sûr de vouloir supprimer cette règle ?')
                                );
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
echo $this->Html->script('jquery-2.2.3.min');
echo $this->Html->script('bootstrap.min');
echo $this->Html->script('app.min');
echo $this->Html->script('jquery.dataTables.min');
echo $this->Html->script('jquery.slimscroll.min');
echo $this->Html->script('fastclick');
echo $this->Html->script('demo');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

<script>
  $(function () {
    $('#example1').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "bSort": false,
        "iDisplayLength": 250,
        "aaSorting": [],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'btn btn-sm btn-light-primary fw-semibold mb-3'
            }
        ]
    });
  });
</script>
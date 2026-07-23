<?php echo $this->element('assets/datatables'); ?>
<!-- ===== Metronic-native card (lavender palette kept only where Metronic
     has no equivalent: the gradient header and the mini objective rows).
     Everything else — card, symbol, badges, table, DataTables theming —
     comes straight from Metronic's style.bundle.css. ===== -->
<style>
    .obj-card-header{
        background: linear-gradient(135deg, #907DFA 0%, #AFA2FF 100%);
        border-radius: 0.475rem 0.475rem 0 0;
    }
    .obj-card-header .card-title h3,
    .obj-card-header .symbol-label{
        color: #ffffff;
    }
    .obj-card-header .symbol-label{
        background: rgba(255,255,255,.22);
    }
    .obj-row{
        border-radius: 0.475rem;
    }
    .obj-row + .obj-row{ margin-top: .5rem; }
</style>

<div class="card mb-5 mb-xl-8">
    <div class="card-header obj-card-header border-0 pt-6">
        <div class="card-title">
            <div class="symbol symbol-40px symbol-circle me-3">
                <span class="symbol-label">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.8"/>
                        <circle cx="12" cy="12" r="5" stroke="#fff" stroke-width="1.8"/>
                        <circle cx="12" cy="12" r="1.3" fill="#fff"/>
                    </svg>
                </span>
            </div>
            <h3 class="m-0"><?php echo __('Les objectifs'); ?></h3>
        </div>
    </div>
    <div class="card-body py-5">
        <table id="example1" class="table align-middle table-row-dashed fs-6 gy-5">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>Nom & prénom</th>
                    <th>E-mail</th>
                    <th>Téléphone</th>
                    <th style="width:240px">Objectifs</th>
                    <th class="actions text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="fw-semibold">
            <?php foreach ($users as $user):
            if(AuthComponent::user('role')!='Super viseur')
                $user['User1']=$user['User'];
            ?>
                <tr>
                    <td class="text-gray-900 fw-bold"><?php echo h($user['User1']['name']); ?></td>
                    <td class="text-muted"><?php echo h($user['User1']['username']); ?></td>
                    <td class="text-muted"><?php echo h($user['User1']['tel']); ?></td>
                    <td>
                    <?php
                    $d="";
                    $objectifs = $this->requestAction('/objectifs/system_get_objectif_by_date/'.$user['User1']['id']);
                    $hasObjectifs = false;
                    foreach ($objectifs as $value)
                    {
                        if(empty($value))
                        {
                            continue;
                        }
                        $hasObjectifs = true;
                        break;
                    }
                    if (!$hasObjectifs) {
                        echo '<span class="text-muted fst-italic fs-7">Aucun objectif</span>';
                    } else {
                        echo '<div class="d-flex flex-column">';
                        foreach ($objectifs as $value)
                        {
                            if(empty($value)) { continue; }
                            $datee=explode(" ",$value['Objectif']['created']);
                            if($d=="")
                                $d=$datee[0];
                            if($d!=$datee[0])
                                echo '<div class="separator separator-dashed my-2"></div>';
                            $d = $datee[0];
                            ?>
                            <div class="obj-row d-flex align-items-center justify-content-between bg-light-primary px-3 py-2">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold fs-8 text-gray-800"><?php echo h($value['Type']['name']); ?></span>
                                    <span class="text-muted fs-9"><?php echo h($datee[0]); ?></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-light-primary me-2"><?php echo h($value['Objectif']['objectif']); ?> Visites</span>
                                    <?php echo $this->Html->link(
                                        '<i class="ki-duotone ki-cross fs-6"><span class="path1"></span><span class="path2"></span></i>',
                                        array('action' => 'delete', $value['Objectif']['id']),
                                        array('class' => 'btn btn-icon btn-sm btn-active-color-danger p-0', 'escape' => false, 'title' => 'Supprimer')
                                    ); ?>
                                </div>
                            </div>
                            <?php
                        }
                        echo '</div>';
                    }
                    ?>
                    </td>
                    <td class="actions text-end">
                        <?php echo $this->Html->link(
                            '<i class="ki-duotone ki-eye fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>',
                            array('controller' => 'users','action' => 'view', $user['User1']['id']),
                            array('class' => 'btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-2', 'escape' => false, 'title' => 'Voir')
                        ); ?>
                        <?php echo $this->Html->link(
                            '<i class="ki-duotone ki-plus fs-2"></i>',
                            array('controller'=>'objectifs','action' => 'add', $user['User1']['id']),
                            array('class' => 'btn btn-icon btn-bg-light btn-active-color-success btn-sm', 'escape' => false, 'title' => 'Ajouter')
                        ); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
echo $this->Html->script('jquery.slimscroll.min');
echo $this->Html->script('fastclick');
echo $this->Html->script('demo');
?>

<script>
   $(function () {
        $('#example1').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "iDisplayLength": 50
        });
    });
</script>

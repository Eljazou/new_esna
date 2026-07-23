<style>
    /* Scoped Metronic UI Extensions */
    .metronic-page-shell {
        background: #f5f7fb;
        padding: 24px 0;
        font-family: 'Poppins', sans-serif;
    }

    .metronic-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(22, 32, 77, 0.05);
        overflow: hidden;
        margin-bottom: 24px;
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

    .metronic-card .card-body {
        padding: 28px;
    }

    /* Key-Value Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .detail-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
    }

    .detail-label {
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 6px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        word-break: break-word;
    }

    /* Related Table Styling */
    .metronic-table {
        width: 100%;
        margin: 0 !important;
    }

    .metronic-table thead th {
        background-color: #f8fafc !important;
        color: #475569 !important;
        border-bottom: 1px solid #e2e8f0 !important;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 14px 16px !important;
    }

    .metronic-table tbody td {
        padding: 14px 16px !important;
        font-size: 13.5px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9 !important;
        vertical-align: middle;
    }

    .metronic-table tbody tr:hover td {
        background-color: #f8fafc !important;
    }

    .btn-metronic-edit {
        background: linear-gradient(135deg, #7c6ff0 0%, #6355e6 100%) !important;
        color: #ffffff !important;
        border-radius: 10px !important;
        border: none !important;
        padding: 9px 20px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 12px rgba(124, 111, 240, 0.25);
        transition: all 0.2s ease;
    }

    .btn-metronic-edit:hover {
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(124, 111, 240, 0.35);
    }
</style>

<div class="metronic-page-shell">
    
    <!-- Header & Pack Details Card -->
    <div class="card metronic-card">
        <div class="card-header">
            <div class="page-title-wrap">
                <span class="page-icon"><i class="ki-duotone ki-archive"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                <div>
                    <h3><?php echo __('Détails du Pack'); ?> #<?php echo h($pack['Pack']['id']); ?></h3>
                </div>
            </div>

            <?php 
            echo $this->Html->link(
                '<i class="ki-duotone ki-pencil me-1" style="color:#fff;"><span class="path1"></span><span class="path2"></span></i> ' . __('Editer'), 
                array('action' => 'edit', $pack['Pack']['id']), 
                array('class' => 'btn btn-metronic-edit', 'escape' => false)
            );
            ?>
        </div>

        <div class="card-body">
            <div class="detail-grid">
                <!-- ID -->
                <div class="detail-item">
                    <div class="detail-label"><?php echo __('Id'); ?></div>
                    <div class="detail-value">
                        <span class="badge badge-light-primary fs-7">#<?php echo h($pack['Pack']['id']); ?></span>
                    </div>
                </div>

                <!-- Utilisateur -->
                <div class="detail-item">
                    <div class="detail-label"><?php echo __('Utilisateur'); ?></div>
                    <div class="detail-value">
                        <?php 
                        if (!empty($pack['User']['id'])) {
                            echo $this->Html->link(
                                h($pack['User']['name']), 
                                array('controller' => 'users', 'action' => 'view', $pack['User']['id']),
                                array('class' => 'text-primary fw-bold text-decoration-none')
                            ); 
                        } else {
                            echo '<span class="text-muted">-</span>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Client -->
                <div class="detail-item">
                    <div class="detail-label"><?php echo __('Client'); ?></div>
                    <div class="detail-value">
                        <?php 
                        if (!empty($pack['Client']['id'])) {
                            echo $this->Html->link(
                                '#' . h($pack['Client']['id']), 
                                array('controller' => 'clients', 'action' => 'view', $pack['Client']['id']),
                                array('class' => 'badge badge-light-info text-decoration-none')
                            ); 
                        } else {
                            echo '<span class="text-muted">-</span>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Nombre -->
                <div class="detail-item">
                    <div class="detail-label"><?php echo __('Nombre'); ?></div>
                    <div class="detail-value">
                        <span class="badge badge-light-success fw-bold fs-7"><?php echo h($pack['Pack']['nombre']); ?></span>
                    </div>
                </div>

                <!-- Créé le -->
                <div class="detail-item">
                    <div class="detail-label"><?php echo __('Date de création'); ?></div>
                    <div class="detail-value text-muted">
                        <?php echo h($pack['Pack']['created']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Packdetails Card -->
    <div class="card metronic-card">
        <div class="card-header">
            <div class="page-title-wrap">
                <span class="page-icon"><i class="ki-duotone ki-menu -alt"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i></span>
                <div>
                    <h3><?php echo __('Détails associés (Packdetails)'); ?></h3>
                </div>
            </div>

            <?php 
            echo $this->Html->link(
                '<i class="ki-duotone ki-plus me-1"></i> ' . __('Nouveau Packdetail'), 
                array('controller' => 'packdetails', 'action' => 'add', '?' => array('pack_id' => $pack['Pack']['id'])), 
                array('class' => 'btn btn-sm btn-light-primary fw-semibold', 'escape' => false)
            ); 
            ?>
        </div>

        <div class="card-body p-0">
            <?php if (!empty($pack['Packdetail'])): ?>
                <div class="table-responsive">
                    <table class="table metronic-table align-middle gs-0 gy-3">
                        <thead>
                            <tr>
                                <th><?php echo __('Id'); ?></th>
                                <th><?php echo __('Pack Id'); ?></th>
                                <th><?php echo __('Gamme Id'); ?></th>
                                <th><?php echo __('Nombre'); ?></th>
                                <th class="text-end"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pack['Packdetail'] as $packdetail): ?>
                                <tr>
                                    <td>
                                        <span class="badge badge-light-dark">#<?php echo $packdetail['id']; ?></span>
                                    </td>
                                    <td>
                                        <span class="text-gray-700">#<?php echo $packdetail['pack_id']; ?></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-info fw-semibold">Gamme #<?php echo $packdetail['gamme_id']; ?></span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-gray-800"><?php echo $packdetail['nombre']; ?></span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <?php 
                                            echo $this->Html->link(
                                                '<i class="ki-duotone ki-eye"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>', 
                                                array('controller' => 'packdetails', 'action' => 'view', $packdetail['id']),
                                                array('class' => 'btn btn-icon btn-sm btn-light-info', 'title' => __('Voir'), 'escape' => false)
                                            ); 
                                            ?>
                                            <?php 
                                            echo $this->Html->link(
                                                '<i class="ki-duotone ki-pencil"><span class="path1"></span><span class="path2"></span></i>', 
                                                array('controller' => 'packdetails', 'action' => 'edit', $packdetail['id']),
                                                array('class' => 'btn btn-icon btn-sm btn-light-warning', 'title' => __('Editer'), 'escape' => false)
                                            ); 
                                            ?>
                                            <?php 
                                            echo $this->Form->postLink(
                                                '<i class="ki-duotone ki-trash"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>', 
                                                array('controller' => 'packdetails', 'action' => 'delete', $packdetail['id']),
                                                array('class' => 'btn btn-icon btn-sm btn-light-danger', 'title' => __('Supprimer'), 'escape' => false),
                                                __('Êtes-vous sûr de vouloir supprimer ?')
                                            ); 
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-5 text-center text-muted fs-7">
                    <i class="ki-duotone ki-information-5 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> <?php echo __('Aucun détail associé à ce pack pour le moment.'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
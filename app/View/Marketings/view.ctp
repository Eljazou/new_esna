<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style type="text/css">
    :root {
        --primary-color: #7c6ff0;
        --primary-gradient: linear-gradient(135deg, #7c6ff0 0%, #6355e6 100%);
        --primary-soft: #f2efff;
        --card-border-radius: 16px;
        --text-dark: #1f2940;
        --text-muted: #94a3b8;
        --border-color: #e2e8f0;
    }

    body, .metronic-card, .table {
        font-family: 'Poppins', sans-serif !important;
    }

    .metronic-view-wrapper {
        width: 100%;
        max-width: 1100px;
        margin: 20px auto;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Card Shell */
    .metronic-card {
        background: #ffffff;
        border: none;
        border-radius: var(--card-border-radius);
        box-shadow: 0 4px 20px rgba(22, 32, 77, 0.04);
        width: 100%;
        overflow: hidden;
    }

    /* Header */
    .metronic-card-header {
        padding: 20px 28px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .hero-title-group {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .hero-icon-box {
        width: 44px;
        height: 44px;
        min-width: 44px;
        border-radius: 12px;
        background: var(--primary-soft);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-icon-box svg {
        width: 22px;
        height: 22px;
        stroke: var(--primary-color);
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .hero-title-group h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .metronic-card-body {
        padding: 28px !important;
    }

    /* Key-Value Details Grid */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px 32px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
    }

    .detail-value {
        font-size: 14.5px;
        font-weight: 500;
        color: var(--text-dark);
    }

    .detail-value a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.15s ease;
    }

    .detail-value a:hover {
        color: #6355e6;
        text-decoration: underline;
    }

    /* Buttons */
    .btn-metronic-primary {
        background: var(--primary-gradient) !important;
        border: none !important;
        border-radius: 10px !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        padding: 9px 20px !important;
        font-size: 13.5px;
        box-shadow: 0 4px 12px rgba(124, 111, 240, 0.25);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }

    .btn-metronic-primary:hover {
        opacity: 0.95;
        box-shadow: 0 6px 16px rgba(124, 111, 240, 0.35);
        transform: translateY(-1px);
    }

    /* Modern Table Styling */
    .table-container {
        overflow-x: auto;
    }

    .metronic-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .metronic-table th {
        background: #f8fafc;
        color: var(--text-muted);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
        text-align: left;
    }

    .metronic-table td {
        padding: 14px 16px;
        font-size: 13.5px;
        color: var(--text-dark);
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .metronic-table tbody tr:last-child td {
        border-bottom: none;
    }

    .metronic-table tbody tr:hover td {
        background-color: #fafaff;
    }

    /* Action Buttons in Table */
    .table-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action {
        padding: 6px 12px !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        display: inline-block;
        border: none !important;
        transition: all 0.15s ease;
    }

    .btn-action-view {
        background: #f2efff !important;
        color: #7c6ff0 !important;
    }
    .btn-action-view:hover { background: #e4deff !important; }

    .btn-action-edit {
        background: #fff8dd !important;
        color: #f1416c !important;
    }
    .btn-action-edit:hover { background: #ffeea8 !important; }

    .btn-action-delete {
        background: #ffeef3 !important;
        color: #f1416c !important;
    }
    .btn-action-delete:hover { background: #ffc2d1 !important; }

    /* Badge Pills */
    .badge-soft {
        background: var(--primary-soft);
        color: var(--primary-color);
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
    }
</style>

<div class="metronic-view-wrapper">
    <!-- Main Marketing Card -->
    <div class="metronic-card">
        <div class="metronic-card-header">
            <div class="hero-title-group">
                <div class="hero-icon-box">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="20" x2="12" y2="10"></line>
                        <line x1="18" y1="20" x2="18" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="16"></line>
                    </svg>
                </div>
                <h3><?php echo __('Marketing Details'); ?></h3>
            </div>
            <div>
                <?php echo $this->Html->link(__('Editer'), array('action' => 'edit'), array('class' => 'btn-metronic-primary')); ?>
            </div>
        </div>

        <div class="metronic-card-body">
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label"><?php echo __('Id'); ?></span>
                    <span class="detail-value">
                        <span class="badge-soft">#<?php echo h($marketing['Marketing']['id']); ?></span>
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label"><?php echo __('Ligne'); ?></span>
                    <span class="detail-value">
                        <?php echo $this->Html->link($marketing['Ligne']['name'], array('controller' => 'lignes', 'action' => 'view', $marketing['Ligne']['id'])); ?>
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label"><?php echo __('Gamme'); ?></span>
                    <span class="detail-value">
                        <?php echo $this->Html->link($marketing['Game']['name'], array('controller' => 'games', 'action' => 'view', $marketing['Game']['id'])); ?>
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label"><?php echo __('Responsable'); ?></span>
                    <span class="detail-value">
                        <?php echo $this->Html->link($marketing['User']['name'], array('controller' => 'users', 'action' => 'view', $marketing['User']['id'])); ?>
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label"><?php echo __('Année'); ?></span>
                    <span class="detail-value"><?php echo h($marketing['Marketing']['annee']); ?></span>
                </div>

                <div class="detail-item">
                    <span class="detail-label"><?php echo __('Type'); ?></span>
                    <span class="detail-value"><?php echo h($marketing['Marketing']['type']); ?></span>
                </div>

                <div class="detail-item">
                    <span class="detail-label"><?php echo __('Prévisions'); ?></span>
                    <span class="detail-value"><?php echo h($marketing['Marketing']['previsions']); ?></span>
                </div>

                <div class="detail-item">
                    <span class="detail-label"><?php echo __('Créé le'); ?></span>
                    <span class="detail-value"><?php echo h($marketing['Marketing']['created']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Details Card -->
    <div class="metronic-card">
        <div class="metronic-card-header">
            <div class="hero-title-group">
                <div class="hero-icon-box">
                    <svg viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <h3><?php echo __('Détails Associés'); ?></h3>
            </div>
            <div>
                <?php echo $this->Html->link(__('Nouveau Détail'), array('controller' => 'mar_details', 'action' => 'add'), array('class' => 'btn-metronic-primary')); ?>
            </div>
        </div>

        <div class="metronic-card-body" style="padding: 0 !important;">
            <?php if (!empty($marketing['MarDetail'])): ?>
                <div class="table-container">
                    <table class="metronic-table">
                        <thead>
                            <tr>
                                <th><?php echo __('Id'); ?></th>
                                <th><?php echo __('Marketing Id'); ?></th>
                                <th><?php echo __('User Id'); ?></th>
                                <th><?php echo __('Vm'); ?></th>
                                <th><?php echo __('Consommation'); ?></th>
                                <th><?php echo __('Commentaire'); ?></th>
                                <th><?php echo __('Créé le'); ?></th>
                                <th style="text-align: right;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($marketing['MarDetail'] as $marDetail): ?>
                                <tr>
                                    <td><span class="badge-soft">#<?php echo $marDetail['id']; ?></span></td>
                                    <td><?php echo $marDetail['marketing_id']; ?></td>
                                    <td><?php echo $marDetail['user_id']; ?></td>
                                    <td><?php echo $marDetail['vm']; ?></td>
                                    <td><?php echo $marDetail['consomation']; ?></td>
                                    <td><?php echo $marDetail['commentaire']; ?></td>
                                    <td><?php echo $marDetail['created']; ?></td>
                                    <td>
                                        <div class="table-actions" style="justify-content: flex-end;">
                                            <?php echo $this->Html->link(__('Voir'), array('controller' => 'mar_details', 'action' => 'view', $marDetail['id']), array('class' => 'btn-action btn-action-view')); ?>
                                            <?php echo $this->Html->link(__('Editer'), array('controller' => 'mar_details', 'action' => 'edit', $marDetail['id']), array('class' => 'btn-action btn-action-edit')); ?>
                                            <?php echo $this->Form->postLink(__('Supprimer'), array('controller' => 'mar_details', 'action' => 'delete', $marDetail['id']), array('class' => 'btn-action btn-action-delete'), __('Êtes-vous sûr de vouloir supprimer ?')); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="padding: 32px; text-align: center; color: var(--text-muted); font-size: 14px;">
                    <?php echo __('Aucun détail trouvé pour ce marketing.'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
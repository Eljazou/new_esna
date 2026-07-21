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

    .metronic-form-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 20px 0;
        font-family: 'Poppins', sans-serif;
    }

    .metronic-card {
        background: #ffffff;
        border: none;
        border-radius: var(--card-border-radius);
        box-shadow: 0 4px 20px rgba(22, 32, 77, 0.04);
        width: 100%;
        max-width: 720px;
        overflow: hidden;
    }

    /* Card Header */
    .metronic-card-header {
        padding: 24px 28px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .hero-icon-box {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 12px;
        background: var(--primary-soft);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-title-group h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.3;
    }

    .hero-title-group p {
        margin: 2px 0 0;
        font-size: 12.5px;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Card Body */
    .metronic-card-body {
        padding: 28px !important;
    }

    .form-group-custom {
        margin-bottom: 22px;
    }

    .form-group-custom label {
        font-weight: 600;
        font-size: 13px;
        color: var(--text-dark);
        display: block;
        margin-bottom: 8px;
    }

    .form-group-custom .form-control {
        border: 1px solid var(--border-color) !important;
        border-radius: 10px !important;
        height: 44px !important;
        padding: 10px 16px !important;
        font-size: 14px !important;
        box-shadow: none !important;
        width: 100%;
        color: var(--text-dark);
        background-color: #f8fafc;
        transition: all 0.2s ease-in-out;
    }

    .form-group-custom .form-control:focus {
        background-color: #ffffff;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(124, 111, 240, 0.15) !important;
        outline: none;
    }

    /* Repeater / Grid Rows */
    .section-divider {
        font-weight: 700;
        font-size: 13px;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 28px 0 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #f1f5f9;
    }

    .repeater-row {
        display: flex;
        gap: 16px;
        background: #fdfdfd;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 12px;
        align-items: center;
    }

    .repeater-row .form-group-custom {
        flex: 1;
        margin-bottom: 0;
    }

    /* Submit Action Bar */
    .metronic-form-actions {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 20px 0 0 !important;
        margin-top: 16px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }

    .metronic-form-actions input[type="submit"] {
        background: var(--primary-gradient) !important;
        border: none !important;
        border-radius: 10px !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        padding: 11px 32px !important;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(124, 111, 240, 0.25);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .metronic-form-actions input[type="submit"]:hover {
        opacity: 0.95;
        box-shadow: 0 6px 16px rgba(124, 111, 240, 0.35);
        transform: translateY(-1px);
    }
</style>

<div class="metronic-form-wrapper">
    <div class="metronic-card">
        <!-- Header -->
        <div class="metronic-card-header">
            <div class="hero-icon-box">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
            <div class="hero-title-group">
                <h3><?php echo __('Demande un pack'); ?></h3>
                <p>Définissez les détails et les gammes de votre demande</p>
            </div>
        </div>

        <!-- Body -->
        <div class="metronic-card-body">
            <?php echo $this->Form->create('Pack'); ?>
            <?php echo $this->Form->hidden('client_id', array('value' => $client_id)); ?>

            <!-- Main Pack Field -->
            <div class="form-group-custom">
                <?php echo $this->Form->input('nombre', array(
                    'type' => 'number',
                    'label' => 'Nombre de pack', 
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 1',
                    'div' => false
                )); ?>
            </div>

            <!-- Details Section -->
            <div class="section-divider">
                <span>Détails des Gammes</span>
            </div>

            <?php for($i = 0; $i < 5; $i++): ?>
                <div class="repeater-row">
                    <div class="form-group-custom">
                        <?php echo $this->Form->input("Packdetail.$i.game_id", array(
                            'class' => 'form-control',
                            'label' => "Gamme",
                            'div' => false
                        )); ?>
                    </div>
                    <div class="form-group-custom">
                        <?php echo $this->Form->input("Packdetail.$i.nombre", array(
                            'type' => 'number',
                            'class' => 'form-control',
                            'label' => "Nombre",
                            'div' => false
                        )); ?>
                    </div>
                </div>
            <?php endfor; ?>

            <!-- Submit -->
            <?php echo $this->Form->end(array(
                'label' => 'Ajouter',
                'required' => 'required',
                'class' => 'btn btn-primary',
                'div' => array('class' => 'metronic-form-actions')
            )); ?>
        </div>
    </div>
</div>
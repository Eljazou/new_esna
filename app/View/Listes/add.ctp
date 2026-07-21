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

    body, .metronic-card, .form-control {
        font-family: 'Poppins', sans-serif;
    }

    /* Centered Container Wrapper */
    .metronic-form-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 20px 15px;
    }

    /* Metronic Card Container */
    .metronic-card {
        background: #ffffff;
        border: none;
        border-radius: var(--card-border-radius);
        box-shadow: 0 4px 20px rgba(22, 32, 77, 0.04);
        width: 100%;
        max-width: 600px;
        overflow: hidden;
    }

    /* Card Header / Hero Banner */
    .metronic-card-header {
        padding: 24px 28px;
        background: transparent;
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
        font-size: 17px;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.3;
    }

    .hero-title-group p {
        margin: 2px 0 0;
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Form Body */
    .metronic-card-body {
        padding: 28px 28px 32px !important;
    }

    .metronic-field-row {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 24px;
    }

    .field-icon-box {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 10px;
        background: var(--primary-soft);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 24px; /* Align nicely with input box */
    }

    .field-body-wrap {
        flex: 1;
        min-width: 0;
    }

    .field-body-wrap label {
        font-weight: 600;
        font-size: 13.5px;
        color: var(--text-dark);
        display: block;
        margin-bottom: 8px;
    }

    .field-body-wrap .form-control {
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

    .field-body-wrap .form-control:focus {
        background-color: #ffffff;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(124, 111, 240, 0.15) !important;
        outline: none;
    }

    /* Submit Button Section */
    .metronic-form-actions {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 20px 0 0 !important;
        margin-top: 12px;
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
        font-size: 13.5px;
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
        <!-- Header Section -->
        <div class="metronic-card-header">
            <div class="hero-icon-box">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </div>
            <div class="hero-title-group">
                <h3><?php echo 'Ajouter une liste : '.$users['User']['name']; ?></h3>
                <p>Créer et assigner une nouvelle liste d'éléments</p>
            </div>
        </div>

        <!-- Form Body Section -->
        <div class="metronic-card-body">
            <?php echo $this->Form->create('Liste'); ?>
            <?php echo $this->Form->hidden('user_id', array('value' => $users['User']['id'])); ?>

            <div class="metronic-field-row">
                <div class="field-icon-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                </div>
                <div class="field-body-wrap">
                    <?php echo $this->Form->input('name', array(
                        'label' => 'Nom de la liste', 
                        'class' => 'form-control', 
                        'placeholder' => 'Ex: Planification de tournée...',
                        'div' => false
                    )); ?>
                </div>
            </div>

            <?php echo $this->Form->end(array(
                'label' => 'Enregistrer', 
                'class' => 'btn btn-primary', 
                'div' => array('class' => 'metronic-form-actions')
            )); ?>
        </div>
    </div>
</div>
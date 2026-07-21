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
        font-family: 'Poppins', sans-serif !important;
    }

    .metronic-form-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 20px 0;
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

    /* Header */
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
        margin-bottom: 20px;
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

    /* Responsive Grid */
    .grid-2-col {
        display: flex;
        gap: 16px;
    }

    .grid-2-col .form-group-custom {
        flex: 1;
    }

    /* Form Actions */
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
                <svg viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </div>
            <div class="hero-title-group">
                <h3>Editer l'action</h3>
                <p>Mettez à jour les paramètres de l'action marketing</p>
            </div>
        </div>

        <!-- Body -->
        <div class="metronic-card-body">
            <?php echo $this->Form->create('Marketing'); ?>
            
            <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>

            <!-- Line & Gamme -->
            <div class="grid-2-col">
                <div class="form-group-custom">
                    <?php echo $this->Form->input('ligne_id', array(
                        'label' => 'Ligne',
                        'class' => 'form-control',
                        'div' => false
                    )); ?>
                </div>
                <div class="form-group-custom">
                    <?php echo $this->Form->input('game_id', array(
                        'label' => 'Gamme',
                        'class' => 'form-control',
                        'div' => false
                    )); ?>
                </div>
            </div>

            <!-- User & Year -->
            <div class="grid-2-col">
                <div class="form-group-custom">
                    <?php echo $this->Form->input('user_id', array(
                        'label' => 'Responsable',
                        'class' => 'form-control',
                        'div' => false
                    )); ?>
                </div>
                <div class="form-group-custom">
                    <?php 
                    $annee = array();
                    for ($i = (date("Y") - 1); $i < date("Y") + 5; $i++) {
                        $annee[$i] = $i;
                    }
                    echo $this->Form->input('annee', array(
                        'options' => $annee,
                        'label' => 'Année',
                        'class' => 'form-control',
                        'div' => false
                    )); 
                    ?>
                </div>
            </div>

            <!-- Samples & Actions -->
            <div class="grid-2-col">
                <div class="form-group-custom">
                    <?php echo $this->Form->input('echantillons', array(
                        'label' => 'Échantillons',
                        'class' => 'form-control',
                        'div' => false
                    )); ?>
                </div>
                <div class="form-group-custom">
                    <?php echo $this->Form->input('actions', array(
                        'label' => 'Actions',
                        'class' => 'form-control',
                        'div' => false
                    )); ?>
                </div>
            </div>

            <!-- Packs & Financials -->
            <div class="grid-2-col">
                <div class="form-group-custom">
                    <?php echo $this->Form->input('packs', array(
                        'label' => 'Packs',
                        'class' => 'form-control',
                        'div' => false
                    )); ?>
                </div>
                <div class="form-group-custom">
                    <?php echo $this->Form->input('ca', array(
                        'label' => "Chiffre d'affaires",
                        'class' => 'form-control',
                        'div' => false
                    )); ?>
                </div>
            </div>

            <!-- Budget -->
            <div class="form-group-custom">
                <?php echo $this->Form->input('budget', array(
                    'label' => 'Budget',
                    'class' => 'form-control',
                    'div' => false
                )); ?>
            </div>

            <!-- Actions Bar -->
            <?php echo $this->Form->end(array(
                'label' => 'Envoyer',
                'class' => 'btn btn-primary',
                'div' => array('class' => 'metronic-form-actions')
            )); ?>
        </div>
    </div>
</div>
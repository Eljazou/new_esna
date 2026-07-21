<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<?php
echo $this->Html->css('select2.min');
echo $this->Html->script('jquery-2.2.3.min');
echo $this->Html->script('https://code.jquery.com/ui/1.12.0/jquery-ui.js');
echo $this->Html->script('select2.full.min');
?>

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

    body, .metronic-card, .form-control, .ui-datepicker, .select2-container {
        font-family: 'Poppins', sans-serif !important;
    }

    /* Container Wrapper */
    .metronic-form-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 20px 0;
    }

    /* Card Shell */
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

    textarea.form-control {
        height: auto !important;
        min-height: 100px;
    }

    .form-group-custom .form-control:focus {
        background-color: #ffffff;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(124, 111, 240, 0.15) !important;
        outline: none;
    }

    /* Grid layout for date controls */
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

    /* =========================================================
       METRONIC OVERRIDES: JQUERY UI DATEPICKER
       ========================================================= */
    .ui-datepicker {
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 10px 30px rgba(31, 41, 64, 0.12) !important;
        padding: 16px !important;
        background: #ffffff !important;
        width: 280px !important;
        z-index: 9999 !important;
    }

    .ui-datepicker-header {
        background: transparent !important;
        border: none !important;
        color: var(--text-dark) !important;
        padding: 0 0 12px 0 !important;
    }

    .ui-datepicker-title {
        font-weight: 700 !important;
        font-size: 14px !important;
        color: var(--text-dark) !important;
    }

    .ui-datepicker .ui-datepicker-prev,
    .ui-datepicker .ui-datepicker-next {
        border-radius: 8px !important;
        border: none !important;
        top: 2px !important;
        cursor: pointer !important;
    }

    .ui-datepicker .ui-datepicker-prev:hover,
    .ui-datepicker .ui-datepicker-next:hover {
        background: var(--primary-soft) !important;
    }

    .ui-datepicker th {
        color: var(--text-muted) !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        border: none !important;
    }

    .ui-datepicker td {
        border: none !important;
        padding: 2px !important;
    }

    .ui-datepicker td a, .ui-datepicker td span {
        text-align: center !important;
        border-radius: 8px !important;
        border: none !important;
        background: transparent !important;
        color: var(--text-dark) !important;
        font-weight: 500 !important;
        font-size: 13px !important;
        padding: 6px !important;
    }

    .ui-datepicker td a:hover {
        background: var(--primary-soft) !important;
        color: var(--primary-color) !important;
    }

    .ui-datepicker td .ui-state-active {
        background: var(--primary-gradient) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 10px rgba(124, 111, 240, 0.3) !important;
    }

    /* =========================================================
       METRONIC OVERRIDES: SELECT2
       ========================================================= */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid var(--border-color) !important;
        border-radius: 10px !important;
        background-color: #f8fafc !important;
        min-height: 44px !important;
        padding: 4px 8px !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        background-color: #ffffff !important;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(124, 111, 240, 0.15) !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: var(--primary-soft) !important;
        border: none !important;
        color: var(--primary-color) !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        border-radius: 6px !important;
        padding: 4px 8px !important;
        margin-top: 4px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: var(--primary-color) !important;
        margin-right: 6px !important;
    }
</style>

<div class="metronic-form-wrapper">
    <div class="metronic-card">
        <!-- Header -->
        <div class="metronic-card-header">
            <div class="hero-icon-box">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="hero-title-group">
                <h3><?php echo __('Demande d\'une action'); ?></h3>
                <p>Planifiez et configurez une nouvelle action spécifique</p>
            </div>
        </div>

        <!-- Body -->
        <div class="metronic-card-body">
            <?php echo $this->Form->create('Action'); ?>
            <?php echo $this->Form->hidden('client_id', array('value' => $client_id)); ?>

            <!-- Date Range Inputs -->
            <div class="grid-2-col">
                <div class="form-group-custom">
                    <?php echo $this->Form->input('date_debut', [
                        'type' => 'text', 
                        'class' => 'form-control', 
                        'id' => 'datepicker', 
                        'label' => 'Date début',
                        'placeholder' => 'AAAA-MM-JJ',
                        'div' => false
                    ]); ?>
                </div>
                <div class="form-group-custom">
                    <?php echo $this->Form->input('date_fin', [
                        'type' => 'text',
                        'required' => 'required', 
                        'class' => 'form-control', 
                        'id' => 'datepicker1', 
                        'label' => 'Date fin',
                        'placeholder' => 'AAAA-MM-JJ',
                        'div' => false
                    ]); ?>
                </div>
            </div>

            <!-- Gamme Multi-Select -->
            <div class="form-group-custom">
                <?php echo $this->Form->input('game_id', array(
                    'label' => 'Gamme', 
                    'class' => 'form-control choix_multi',
                    'multiple' => true,
                    'name' => 'gamme[]',
                    'div' => false
                )); ?>
            </div>

            <!-- Nature dropdown -->
            <div class="form-group-custom">
                <?php 
                $option = array("F" => "F", "SF" => "SF");
                echo $this->Form->input('nature', array(
                    'label' => 'Nature action',
                    'options' => $option, 
                    'class' => 'form-control',
                    'div' => false
                )); 
                ?>
            </div>

            <!-- Action Name -->
            <div class="form-group-custom">
                <?php echo $this->Form->input('name', array(
                    'type' => 'text',
                    'label' => 'Action', 
                    'class' => 'form-control',
                    'onkeypress' => 'if (isNaN(this.value + String.fromCharCode(event.keyCode))) return false;',
                    'div' => false
                )); ?>
            </div>

            <!-- Description -->
            <div class="form-group-custom">
                <?php echo $this->Form->input('description', array(
                    'type' => 'textarea',
                    'label' => 'Description', 
                    'class' => 'form-control',
                    'rows' => '3',
                    'div' => false
                )); ?>
            </div>

            <!-- Submit Action -->
            <?php echo $this->Form->end(array(
                'label' => 'Ajouter',
                'required' => 'required', 
                'class' => 'btn btn-primary', 
                'div' => array('class' => 'metronic-form-actions')
            )); ?>
        </div>
    </div>
</div>

<script>
    (function (factory) {
        if (typeof define === "function" && define.amd) {
            define(["../widgets/datepicker"], factory);
        } else {
            factory(jQuery.datepicker);
        }
    }(function (datepicker) {
        datepicker.regional.fr = {
            closeText: "Fermer",
            prevText: "Précédent",
            nextText: "Suivant",
            currentText: "Aujourd'hui",
            monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
                "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            monthNamesShort: ["Janv.", "Févr.", "Mars", "Avr.", "Mai", "Juin",
                "Juil.", "Août", "Sept.", "Oct.", "Nov.", "Déc."],
            dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
            dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
            dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
            weekHeader: "Sem.",
            dateFormat: "yy-mm-dd",
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""
        };
        datepicker.setDefaults(datepicker.regional.fr);

        return datepicker.regional.fr;
    }));

    $(document).ready(function () {
        $("#datepicker").datepicker($.datepicker.regional['fr']);
        $("#datepicker1").datepicker($.datepicker.regional['fr']);
        $('.choix_multi').select2({
            placeholder: "Sélectionnez les gammes...",
            width: '100%'
        });
    });
</script>
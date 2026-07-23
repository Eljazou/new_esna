<?php echo $this->Html->css('jquery-ui.min', array('block' => 'css')); ?>
<?php
// jQuery UI powers the .datepicker() calls below. It is NOT part of
// Metronic's plugins.bundle, so it must be loaded explicitly -- served from
// webroot/js instead of the CDN.
echo $this->Html->script('jquery-ui.min'); ?>

<style type="text/css">
    /* =========================================================
       METRONIC CARD & FORM LAYOUT STYLES
       ========================================================= */
    .metronic-card {
        background: #ffffff;
        border-radius: 16px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
        border: none !important;
        max-width: 680px;
        margin: 30px auto;
        overflow: hidden;
    }

    .metronic-card .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid #f1f1f5;
        padding: 24px 32px;
    }

    .metronic-card .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #181c32;
        margin: 0;
    }

    .metronic-card .card-body {
        padding: 32px;
    }

    .form-label {
        font-size: 13.5px;
        font-weight: 600;
        color: #181c32;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border-radius: 10px !important;
        border: 1px solid #e1e3ea !important;
        padding: 11px 16px !important;
        font-size: 14px !important;
        color: #3f4254 !important;
        background-color: #ffffff !important;
        box-shadow: none !important;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        border-color: #9b87f5 !important;
        outline: none;
    }

    .form-action-wrapper {
        background-color: #f2f0fc;
        border-radius: 12px;
        padding: 24px;
        margin-top: 28px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn-metronic-primary {
        background-color: #9b87f5 !important;
        border-color: #9b87f5 !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        padding: 10px 32px !important;
        border-radius: 10px !important;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-metronic-primary:hover {
        background-color: #8b75f3 !important;
    }

    /* =========================================================
       METRONIC STYLE OVERRIDES FOR JQUERY UI DATEPICKER
       ========================================================= */
    .ui-datepicker {
        background-color: #ffffff !important;
        border: 1px solid #ece9f9 !important;
        border-radius: 14px !important;
        box-shadow: 0 10px 30px rgba(108, 99, 245, 0.12) !important;
        font-family: inherit !important;
        padding: 16px !important;
        width: 280px !important;
        z-index: 9999 !important;
    }

    .ui-datepicker .ui-datepicker-header {
        background: #ffffff !important;
        border: none !important;
        color: #181c32 !important;
        padding: 4px 0 12px 0 !important;
        position: relative !important;
    }

    .ui-datepicker .ui-datepicker-title {
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #181c32 !important;
        text-align: center !important;
    }

    .ui-datepicker .ui-datepicker-prev,
    .ui-datepicker .ui-datepicker-next {
        top: 2px !important;
        width: 28px !important;
        height: 28px !important;
        border-radius: 8px !important;
        background: #f4f3ff !important;
        cursor: pointer !important;
        border: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: background 0.2s ease !important;
    }

    .ui-datepicker .ui-datepicker-prev:hover,
    .ui-datepicker .ui-datepicker-next:hover {
        background: #ece9fe !important;
    }

    .ui-datepicker .ui-datepicker-prev span,
    .ui-datepicker .ui-datepicker-next span {
        display: none !important;
    }

    .ui-datepicker .ui-datepicker-prev::after {
        content: "‹";
        font-size: 18px;
        font-weight: 700;
        color: #6c63f5;
        line-height: 1;
    }

    .ui-datepicker .ui-datepicker-next::after {
        content: "›";
        font-size: 18px;
        font-weight: 700;
        color: #6c63f5;
        line-height: 1;
    }

    .ui-datepicker .ui-datepicker-prev { left: 4px !important; }
    .ui-datepicker .ui-datepicker-next { right: 4px !important; }

    .ui-datepicker table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }

    .ui-datepicker th {
        padding: 6px 0 !important;
        text-align: center !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        color: #8d8da8 !important;
        border: none !important;
    }

    .ui-datepicker td {
        padding: 2px !important;
        border: none !important;
        text-align: center !important;
    }

    .ui-datepicker td a,
    .ui-datepicker td span {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 32px !important;
        height: 32px !important;
        margin: 0 auto !important;
        border-radius: 8px !important;
        border: none !important;
        background: transparent !important;
        color: #4a4a68 !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        transition: all 0.15s ease !important;
    }

    .ui-datepicker td a:hover {
        background-color: #f2f0fc !important;
        color: #6c63f5 !important;
    }

    .ui-datepicker td .ui-state-active,
    .ui-datepicker td .ui-state-highlight.ui-state-active {
        background: linear-gradient(135deg, #8c7ef2, #6c63f5) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 10px rgba(108, 99, 245, 0.3) !important;
    }

    .ui-datepicker td .ui-state-highlight {
        background-color: #f4f3ff !important;
        color: #6c63f5 !important;
        font-weight: 700 !important;
    }
</style>

<div class="container">
    <div class="card metronic-card">
        <div class="card-header">
            <h3 class="card-title"><?php echo __('Editer la visite'); ?></h3>
        </div>

        <div class="card-body">
            <?php echo $this->Form->create('Visite', array('class' => '')); ?>

                <?php echo $this->Form->input('id'); ?>

                <!-- Commentaire Field -->
                <div class="mb-4">
                    <?php echo $this->Form->input('commentaire', array(
                        'label' => array('text' => 'Commentaire', 'class' => 'form-label'),
                        'class' => 'form-control',
                        'div' => false
                    )); ?>
                </div>

                <!-- Objections Field -->
                <div class="mb-4">
                    <?php echo $this->Form->input('objection', array(
                        'label' => array('text' => 'Objections', 'class' => 'form-label'),
                        'class' => 'form-control',
                        'div' => false
                    )); ?>
                </div>

                <!-- Veille Field -->
                <div class="mb-4">
                    <?php echo $this->Form->input('veille', array(
                        'label' => array('text' => 'Veille', 'class' => 'form-label'),
                        'class' => 'form-control',
                        'div' => false
                    )); ?>
                </div>

                <!-- Date Field with Styled Datepicker -->
                <div class="mb-4">
                    <?php echo $this->Form->input('date', array(
                        'type' => 'text', 
                        'class' => 'form-control', 
                        'id' => 'datepicker', 
                        'label' => array('text' => 'Date', 'class' => 'form-label'),
                        'div' => false
                    )); ?>
                </div>

                <!-- Action Button Section -->
                <div class="form-action-wrapper">
                    <?php echo $this->Form->end(array(
                        'label' => 'Envoyer', 
                        'class' => 'btn btn-metronic-primary', 
                        'div' => false
                    )); ?>
                </div>

        </div>
    </div>
</div>

<script>
( function( factory ) {
    if ( typeof define === "function" && define.amd ) {
        define( [ "../widgets/datepicker" ], factory );
    } else {
        factory( jQuery.datepicker );
    }
}( function( datepicker ) {
datepicker.regional.fr = {
    closeText: "Fermer",
    prevText: "Précédent",
    nextText: "Suivant",
    currentText: "Aujourd'hui",
    monthNames: [ "janvier", "février", "mars", "avril", "mai", "juin",
        "juillet", "août", "septembre", "octobre", "novembre", "décembre" ],
    monthNamesShort: [ "janv.", "févr.", "mars", "avr.", "mai", "juin",
        "juil.", "août", "sept.", "oct.", "nov.", "déc." ],
    dayNames: [ "dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi" ],
    dayNamesShort: [ "dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam." ],
    dayNamesMin: [ "D","L","M","M","J","V","S" ],
    weekHeader: "Sem.",
    dateFormat: "yy-mm-dd",
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: "" };
datepicker.setDefaults( datepicker.regional.fr );

return datepicker.regional.fr;

} ) );

    $("#datepicker").datepicker($.datepicker.regional['fr']);
</script>
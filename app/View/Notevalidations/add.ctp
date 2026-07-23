<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style type="text/css">
    /* ===== Metronic UI Design System — Scoped (.nv) ===== */
    :root {
        --nv-primary: #7c6ff0;
        --nv-primary-grad: linear-gradient(135deg, #7c6ff0 0%, #6355e6 100%);
        --nv-primary-soft: #f2efff;
        --nv-text-dark: #1f2940;
        --nv-text-muted: #94a3b8;
        --nv-border: #e2e8f0;
        --nv-danger: #f1416c;
        --nv-danger-grad: linear-gradient(135deg, #f1416c 0%, #d9214e 100%);
    }

    .nv {
        font-family: 'Poppins', sans-serif !important;
        width: 100%;
        padding: 20px 0;
    }

    .nv-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(22, 32, 77, 0.05);
        max-width: 680px;
        margin: 0 auto;
        overflow: hidden;
    }

    .nv-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 24px 28px 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .nv-card-header:before {
        content: '';
        width: 6px;
        height: 22px;
        border-radius: 4px;
        background: var(--nv-primary-grad);
    }

    .nv-card-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--nv-text-dark);
        margin: 0;
    }

    .nv-card-body {
        padding: 28px;
    }

    /* Labels with Icons */
    .nv-field-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        color: var(--nv-text-dark);
        margin: 22px 0 8px;
    }

    .nv-field-label svg {
        width: 16px;
        height: 16px;
        stroke: var(--nv-primary);
    }

    .nv-field-label:first-child {
        margin-top: 0;
    }

    .nv .info {
        color: var(--nv-text-muted);
        font-size: 11.5px;
        font-weight: 500;
        text-transform: none;
        letter-spacing: normal;
        margin-left: 4px;
    }

    /* Standard Form Inputs */
    .nv .form-control {
        border-radius: 10px !important;
        border: 1px solid var(--nv-border) !important;
        background-color: #f8fafc;
        box-shadow: none !important;
        height: 44px;
        font-size: 14px;
        color: var(--nv-text-dark);
        padding: 10px 14px;
        transition: all 0.2s ease;
    }

    .nv .form-control:focus {
        background-color: #ffffff;
        border-color: var(--nv-primary) !important;
        box-shadow: 0 0 0 3px rgba(124, 111, 240, 0.15) !important;
        outline: none;
    }

    /* Select2 Restyle */
    .nv .select2-container {
        width: 100% !important;
    }

    .nv .select2-container--default .select2-selection--multiple {
        border-radius: 10px !important;
        border: 1px solid var(--nv-border) !important;
        background-color: #f8fafc;
        min-height: 44px;
        padding: 4px 8px;
    }

    .nv .select2-container--default.select2-container--focus .select2-selection--multiple {
        background-color: #ffffff;
        border-color: var(--nv-primary) !important;
        box-shadow: 0 0 0 3px rgba(124, 111, 240, 0.15);
    }

    .nv .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: var(--nv-primary-soft);
        border: none;
        border-radius: 20px;
        color: var(--nv-primary);
        font-size: 12.5px;
        font-weight: 600;
        padding: 4px 12px;
        margin-top: 4px;
    }

    .nv .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: var(--nv-primary);
        margin-right: 6px;
        border: none;
        font-weight: 700;
    }

    .nv .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #5544e2;
        background: transparent;
    }

    .nv .select2-dropdown {
        border-radius: 12px !important;
        border: 1px solid var(--nv-border) !important;
        box-shadow: 0 10px 30px rgba(22, 32, 77, 0.1);
        overflow: hidden;
    }

    .nv .select2-results__option--highlighted[aria-selected] {
        background: var(--nv-primary) !important;
        color: #ffffff !important;
    }

    /* Dynamic Choix Rows */
    .nv .inputs_choix {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .nv .check_input {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 0;
    }

    .nv .ajusment_input {
        flex: 1;
        margin-bottom: 0 !important;
    }

    .nv .check {
        margin: 0;
        display: none;
        align-items: center;
    }

    .nv .input_check {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 1.5px solid var(--nv-border);
        cursor: pointer;
        accent-color: var(--nv-primary);
    }

    .nv .btns_inputs_choix {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 14px 0 6px;
    }

    .nv .btn-min, .nv .btn-remove {
        font-size: 18px;
        font-weight: 700;
        padding: 0;
        height: 38px;
        width: 38px;
        min-width: 38px;
        border: none;
        border-radius: 10px;
        color: #ffffff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        background: var(--nv-primary-grad);
        box-shadow: 0 4px 12px rgba(124, 111, 240, 0.25);
    }

    .nv .btn-min:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(124, 111, 240, 0.35);
    }

    .nv .btn-remove {
        display: none;
        background: var(--nv-danger-grad);
        box-shadow: 0 4px 12px rgba(241, 65, 108, 0.25);
    }

    .nv .btn-remove:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(241, 65, 108, 0.35);
    }

    .nv .btn-remove svg, .nv .btn-min svg {
        width: 16px;
        height: 16px;
    }

    /* Submit Section */
    .nv-submit-wrap {
        text-align: right;
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .nv .btn-primary {
        background: var(--nv-primary-grad) !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 11px 32px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(124, 111, 240, 0.25) !important;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .nv .btn-primary:hover {
        opacity: 0.95;
        box-shadow: 0 6px 16px rgba(124, 111, 240, 0.35) !important;
        transform: translateY(-1px);
    }
</style>

<div class="nv">
    <div class="nv-card">
        <div class="nv-card-header">
            <h3><?php echo __('Ajouter une validation'); ?></h3>
        </div>
        <div class="nv-card-body">
            <?php echo $this->Form->create('Notevalidation', array('onsubmit' => 'return assemble_choix();')); ?>

            <!-- Utilisateurs -->
            <div class="nv-field-label">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Utilisateurs
            </div>
            <?php echo $this->Form->input('users', array("label" => false, "multiple" => "multiple", 'class' => 'form-control select2')); ?>

            <!-- Choix d'ajustement -->
            <div class="nv-field-label">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Choix d'ajustement
                <span class="info">(Appuyez sur Entrée pour ajouter un nouveau choix)</span>
            </div>
            <input type="hidden" name="data[Notevalidation][choix]" id="note_choix">

            <div class="inputs_choix">
                <div class="check_input check_input0">
                    <div class="checkbox check">
                        <input type="checkbox" class="input_check" titre="0">
                    </div>
                    <input type="text" class="ajusment_input form-control ajusment_input0" placeholder="Saisir un choix...">
                </div>
            </div>

            <div class="btns_inputs_choix">
                <button type="button" class="btn-min" onclick="show_check()" title="Sélectionner pour supprimer">−</button>
                <button type="button" class="btn-remove" onclick="remove()" title="Supprimer la sélection">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </button>
            </div>

            <!-- Niveau -->
            <div class="nv-field-label">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                Niveau
            </div>
            <?php echo $this->Form->input('niveau', array('label' => false, 'class' => 'form-control')); ?>

            <!-- Mail de validation -->
            <div class="nv-field-label">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"/><path d="M22 6l-10 7L2 6"/></svg>
                Mail de validation
            </div>
            <?php echo $this->Form->input('messagevalidation', array("value" => "Responsable (R) a valider la note de frais a (VM) du mois (M)", 'label' => false, 'class' => 'form-control')); ?>

            <!-- Mail de refus -->
            <div class="nv-field-label">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"/><path d="M22 6l-10 7L2 6"/></svg>
                Mail de refus
            </div>
            <?php echo $this->Form->input('messageannulation', array("value" => "Responsable (R) a refusé la note de frais a (VM) du mois (M)", 'label' => false, 'class' => 'form-control')); ?>

            <div class="nv-submit-wrap">
                <button class="btn btn-primary">Envoyer</button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<script>
    $(function () {
        $(".select2").select2({
            width: '100%',
            placeholder: 'Choisissez...',
            allowClear: true
        });
    });

    $(document).ready(function () {
        $(document).on('keypress', '.ajusment_input', function (e) {
            var inputs = $(".ajusment_input");
            if (e.which === 13) {
                var clonedElement = $('.check_input:last').clone();

                clonedElement.removeClass('check_input' + (inputs.length - 1)).addClass('check_input' + inputs.length);
                clonedElement.find('.checkbox').find('input').attr('titre', inputs.length);

                $('.inputs_choix').append(clonedElement);
                clonedElement.find('.ajusment_input').focus();
                $('.ajusment_input:last').val('');

                $(".check").fadeOut();
                $(".btn-min").css('display', 'flex');
                $(".btn-remove").hide();
                e.preventDefault();
            }
        });
    });

    function assemble_choix() {
        var inputs = $(".ajusment_input");
        var arry_val = [];

        for (var i = 0; i < inputs.length; i++) {
            arry_val.push($(inputs[i]).val());
        }

        var convert_array_val = arry_val.join(';');
        $('#note_choix').val(convert_array_val);

        return true;
    }

    function show_check() {
        $(".check").fadeIn();
        $(".btn-min").hide();
        $(".btn-remove").css('display', 'flex');
    }

    function remove() {
        var count_inputs = $(".ajusment_input").length;

        if (count_inputs == 1) {
            $(".ajusment_input0").val('');
            $(".input_check").prop('checked', false);
            $(".check").fadeOut();
            $(".btn-min").css('display', 'flex');
            $(".btn-remove").hide();
        } else {
            for (var i = count_inputs - 1; i >= 0; i--) {
                if ($('.input_check').eq(i).is(':checked')) {
                    var titre = $('.input_check').eq(i).attr('titre');
                    $(".check_input" + titre).remove();
                }
            }
            for (var i = 0; i <= count_inputs; i++) {
                $('.check_input').eq(i).attr('class', 'check_input check_input' + i);
                $('.check_input').eq(i).find('.checkbox').find('input').attr('titre', i);
            }
        }
    }
</script>
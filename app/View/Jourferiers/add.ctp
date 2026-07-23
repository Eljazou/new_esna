<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"></span> Ajouter</h3>
    </div>
    <div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
                    <?php
                    echo $this->Form->create('Jourferier');
                    echo $this->Form->input('name', array('label' => 'Nom','class' => 'form-control'));
                    ?>
                    <div class="col-md-6" style="padding-left: 0px;">
                        <?php
                        echo $this->Form->input('date_debut', ['type' => 'text', 'class' => 'form-control', 'id' => 'datepicker', 'label' => "Date début"]);
                        ?>
                    </div>
                    <div class="col-md-6" style="padding-right: 0px;">
                        <?php
                        echo $this->Form->input('date_fin', ['type' => 'text', "required" => "required", 'class' => 'form-control', 'id' => 'datepicker1', 'label' => "Date fin"]);
                        ?>
                    </div>
                    <?php echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary btn-large', 'div' => array('class' => 'card card-body bg-light text-center col-md-12'))); ?>
                </div>
            </div>
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
            monthNames: ["janvier", "février", "mars", "avril", "mai", "juin",
                "juillet", "août", "septembre", "octobre", "novembre", "décembre"],
            monthNamesShort: ["janv.", "févr.", "mars", "avr.", "mai", "juin",
                "juil.", "août", "sept.", "oct.", "nov.", "déc."],
            dayNames: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"],
            dayNamesShort: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
            dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
            weekHeader: "Sem.",
            dateFormat: "yy-mm-dd",
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""};
        datepicker.setDefaults(datepicker.regional.fr);

        return datepicker.regional.fr;

    }));
    $("#datepicker").datepicker($.datepicker.regional['fr']);
    $("#datepicker1").datepicker($.datepicker.regional['fr']);
</script>



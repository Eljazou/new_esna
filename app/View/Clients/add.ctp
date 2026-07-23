<?php
/**
 * Clients :: add — formulaire de creation d'un client.
 *
 * Migrated to Metronic 8 (Bootstrap 5). Business logic untouched: the three
 * $type branches, the $k hidden-input trick, every foreach and all FormHelper
 * field names are exactly as before. Styling now comes from the $options
 * arrays passed to Form->input() rather than a bespoke 280-line <style> block.
 *
 * select2 and jQuery are provided by Metronic's plugins.bundle (loaded once in
 * the layout), so this view no longer includes them itself.
 */
echo $this->Html->css('esna-clients', array('block' => 'css'));
echo $this->element('layout/page_header', array(
    'title'  => __('Ajouter un client'),
    'crumbs' => array(
        'Clients' => array('controller' => 'clients', 'action' => 'index'),
        'Ajouter' => null,
    ),
));
?>
<div class="card">
    <div class="card-header">
        <div class="heading-text">
            <h3 class="card-title fw-bold fs-3"><?php echo __('Ajouter un client'); ?></h3>
            <p class="text-muted fs-7 mb-0">Renseignez les informations du nouveau client</p>
        </div>
    </div>
    <div class="card-body">
        <?php
        $k = '';
        if ($type == null || $type == 'Médecin' ||  $type == 'Autres professions de la santé' ):
            ?>
            <div>
                <?php echo $this->Form->create('Client'); ?>

                <div class="mb-8">
                    <h4 class="fs-6 fw-bold text-gray-800 mb-4 d-flex align-items-center"><span class="bullet bullet-dot bg-warning me-3"></span>Informations professionnelles</h4>

                    <div class="mb-5"><label for="ClientsTypeId" class="form-label fw-semibold text-gray-800">Type</label>
                        <select name="data[Client][type_id]" onchange="location = this.value;" class="form-select" id="ClientsTypeId">
                            <option value="">(choisissez)</option>
                            <?php
                            foreach ($types as $key => $value) {
                                $selected = '';
                                if ($type == $value) {
                                    $selected = "selected";
                                    $k = $this->Form->input('type_id', array('type' => 'hidden', 'value' => $key));
                                }
                                echo "<option $selected value='" . $this->Html->url(array('action' => 'add', $value)) . "'>$value</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                    echo $k;
                    echo $this->Form->input('secteur_id', array('label' => 'Secteur', 'class' => 'form-select select2'));
                    echo $this->Form->input('category_id', array('label' => 'Spécialité', 'class' => 'form-select'));
                    ?>
                    <div class="row g-4">
                        <div class="col-md-6 mb-5">
                            <label for="ClientCategoryId1" class="form-label fw-semibold text-gray-800">Tendance</label>
                            <select name="data[Client][category1_id]" class="form-select" id="ClientCategoryId1">
                                <option value="">Choisissez</option>
                                <?php
                                foreach ($categories as $key => $value) {
                                    echo "<option value='$key'>$value</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label for="ClientCategoryId2" class="form-label fw-semibold text-gray-800">Titre</label>
                            <select name="data[Client][titre]" class="form-select" id="ClientCategoryId2">
                                <option value="Docteur">Docteur</option>
                                <option value="Professeur">Professeur</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6 mb-5">
                            <label for="ClientActiviteSelectAdd" class="form-label fw-semibold text-gray-800">Activité</label>
                            <select name="data[Client][activite]" class="form-select" id="ClientActiviteSelectAdd">
                                <option value="Prive">Privé</option>
                                <option value="Publique">Publique</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label for="ClientCategoryId4" class="form-label fw-semibold text-gray-800">Exercice</label>
                            <select name="data[Client][exercice]" class="form-select" id="ClientCategoryId4">
                                <option value="Centre de sante"> Centre de santé</option>
                                <option value="Cabinet prive">Cabinet privé</option>
                                <option value="Hopital">Hôpital</option>
                                <option value="Penitencier">Pénitencier</option>
                                <option value="Clinique">Clinique</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-5" id="hopital-field-add" style="display:none;">
                        <label class="form-label fw-semibold text-gray-800">Hôpital</label>
                        <select name="data[Client][hopital_id]" id="ClientHopitalSelectAdd" class="form-select" style="width:100%">
                            <option value="">-- Choisir ou créer un hôpital --</option>
                            <?php foreach ($all_hopitals as $h_id => $h_name): ?>
                                <option value="<?php echo $h_id; ?>"><?php echo h($h_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6 mb-5">
                            <label for="ClientCategoryId5" class="form-label fw-semibold text-gray-800">Patients par Jour</label>
                            <select name="data[Client][A]" class="form-select" id="ClientCategoryId5">
                                <option value="A">Plus de 20</option>
                                <option value="B">Entre 10 et 20</option>
                                <option value="C">Moins de 10</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label for="ClientCategoryId6" class="form-label fw-semibold text-gray-800">Adoption des produits Esnapharm</label>
                            <select name="data[Client][1]" class="form-select" id="ClientCategoryId6">
                                <option value="1">Exclusif</option>
                                <option value="2">Fidèle</option>
                                <option value="3">Rare</option>
                                <option value="4">Non</option>
                            </select>
                        </div>
                    </div>
                    <?php
                    echo $this->Form->input('produits', array('name' => "data[Client][produits]", 'label' => 'La liste des gammes', 'class' => 'form-select select2', 'multiple' => "multiple"));
                    ?>
                </div>

                <div class="mb-8">
                    <h4 class="fs-6 fw-bold text-gray-800 mb-4 d-flex align-items-center"><span class="bullet bullet-dot bg-primary me-3"></span>Coordonnées</h4>
                    <div class="row g-4">
                        <?php echo $this->Form->input('nom', array('label' => array('text' => 'Nom', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                        <?php echo $this->Form->input('prenom', array('label' => array('text' => 'Prénom', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                    </div>
                    <?php echo $this->Form->input('mail', array('label' => array('text' => 'Mail', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                    <div class="row g-4">
                        <?php echo $this->Form->input('tel', array('label' => array('text' => 'Téléphone', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                        <?php echo $this->Form->input('fixe', array('label' => array('text' => 'Fixe', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                    </div>
                    <?php
                    echo $this->Form->input('fax', array('label' => array('text' => 'Fax', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5'));
                    echo $this->Form->input('adress', array('label' => 'Adresse', 'class' => 'form-control', 'type' => 'text'));
                    ?>
                </div>

            <?php
        elseif ($type == 'Pharmacie'):
            ?>
            <div>
                <?php echo $this->Form->create('Client'); ?>

                <div class="mb-8">
                    <h4 class="fs-6 fw-bold text-gray-800 mb-4 d-flex align-items-center"><span class="bullet bullet-dot bg-warning me-3"></span>Informations professionnelles</h4>

                    <div class="mb-5"><label for="ClientsTypeId" class="form-label fw-semibold text-gray-800">Type</label>
                        <select name="data[Client][type_id]" onchange="location = this.value;" class="form-select" id="ClientsTypeId">
                            <option value="">(choisissez)</option>
                            <?php
                            foreach ($types as $key => $value) {
                                $selected = '';
                                if ($type == $value) {
                                    $selected = "selected";
                                    $k = $this->Form->input('type_id', array('type' => 'hidden', 'value' => $key));
                                }
                                echo "<option $selected value='" . $this->Html->url(array('action' => 'add', $value)) . "'>$value</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                    echo $k;
                    $types=array("Client"=>"Client","Prospect"=>"Prospect");
                    echo $this->Form->input('type_pharmacie', array('label' =>'type pharmacie', 'class' => 'form-select','options' =>$types));
                    echo $this->Form->input('secteur_id', array('label' => 'Secteur', 'class' => 'form-select select2'));
                    echo $this->Form->input('category_id', array('label' => 'Spécialité', 'class' => 'form-select'));
                    echo $this->Form->input('code_wavsoft', array( 'class' => 'form-control'));
                    ?>
                    <div class="row g-4">
                        <div class="col-md-6 mb-5">
                            <label for="ClientCategoryId7" class="form-label fw-semibold text-gray-800">Type de pharmacie</label>
                            <select name="data[Client][A]" class="form-select" id="ClientCategoryId7">
                                <option value="A">Pharmacie grande</option>
                                <option value="B">Pharmacie moyenne</option>
                                <option value="C">Pharmacie petite</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label for="ClientCategoryId8" class="form-label fw-semibold text-gray-800">Emplacement du pharmacie</label>
                            <select name="data[Client][e]" class="form-select" id="ClientCategoryId8">
                                <option value="Centre">Centre</option>
                                <option value="Moyen">Moyen</option>
                                <option value="Periphérique">Périphérique</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-semibold text-gray-800">Commande des produits</label>
                        <select name="data[Client][1]" class="form-select">
                            <option value="1">Commande (cliente directe)</option>
                            <option value="2">Pack (cliente indirecte)</option>
                            <option value="3">Non cliente</option>
                        </select>
                    </div>
                </div>

                <div class="mb-8">
                    <h4 class="fs-6 fw-bold text-gray-800 mb-4 d-flex align-items-center"><span class="bullet bullet-dot bg-primary me-3"></span>Coordonnées</h4>
                    <div class="row g-4">
                        <?php echo $this->Form->input('nom', array('label' => array('text' => 'Nom', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                        <?php echo $this->Form->input('prenom', array('label' => array('text' => 'Prénom', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                    </div>
                    <?php echo $this->Form->input('mail', array('label' => array('text' => 'Mail', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                    <div class="row g-4">
                        <?php echo $this->Form->input('tel', array('label' => array('text' => 'Téléphone', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                        <?php echo $this->Form->input('fixe', array('label' => array('text' => 'Fixe', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                    </div>
                    <?php
                    echo $this->Form->input('fax', array('label' => array('text' => 'Fax', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5'));
                    echo $this->Form->input('adress', array('label' => 'Adresse', 'class' => 'form-control', 'type' => 'text'));
                    ?>
                </div>

            <?php
        else :
            ?>
            <div>
                <?php echo $this->Form->create('Client'); ?>

                <div class="mb-8">
                    <h4 class="fs-6 fw-bold text-gray-800 mb-4 d-flex align-items-center"><span class="bullet bullet-dot bg-warning me-3"></span>Informations professionnelles</h4>

                    <div class="mb-5"><label for="ClientsTypeId" class="form-label fw-semibold text-gray-800">Type</label>
                        <select name="data[Client][type_id]" onchange="location = this.value;" class="form-select" id="ClientsTypeId">
                            <option value="">(choisissez)</option>
                            <?php
                            foreach ($types as $key => $value) {
                                $selected = '';
                                if ($type == $value) {
                                    $selected = "selected";
                                    $k = $this->Form->input('type_id', array('type' => 'hidden', 'value' => $key));
                                }
                                echo "<option $selected value='" . $this->Html->url(array('action' => 'add', $value)) . "'>$value</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                    echo $k;
                    $types=array("Client"=>"Client","Prospect"=>"Prospect");
                    echo $this->Form->input('type_pharmacie', array('label' =>'Type de client', 'class' => 'form-select','options' =>$types));
                    echo $this->Form->input('secteur_id', array('label' => 'Secteur', 'class' => 'form-select select2'));
                    echo $this->Form->input('category_id', array('label' => 'Spécialité', 'class' => 'form-select'));
                    echo $this->Form->input('code_wavsoft', array( 'class' => 'form-control'));
                    ?>
                </div>

                <div class="mb-8">
                    <h4 class="fs-6 fw-bold text-gray-800 mb-4 d-flex align-items-center"><span class="bullet bullet-dot bg-primary me-3"></span>Coordonnées</h4>
                    <div class="row g-4">
                        <?php echo $this->Form->input('nom', array('label' => array('text' => 'Nom', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                        <?php echo $this->Form->input('prenom', array('label' => array('text' => 'Prénom', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                    </div>
                    <?php echo $this->Form->input('mail', array('label' => array('text' => 'Mail', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                    <div class="row g-4">
                        <?php echo $this->Form->input('tel', array('label' => array('text' => 'Téléphone', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                        <?php echo $this->Form->input('fixe', array('label' => array('text' => 'Fixe', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5')); ?>
                    </div>
                    <?php
                    echo $this->Form->input('fax', array('label' => array('text' => 'Fax', 'class' => 'form-label fw-semibold text-gray-800'), 'class' => 'form-control', 'div' => 'mb-5'));
                    echo $this->Form->input('adress', array('label' => 'Adresse', 'class' => 'form-control', 'type' => 'text'));
                    ?>
                </div>
            <?php endif; ?>

                <div class="mb-8">
                    <h4 class="fs-6 fw-bold text-gray-800 mb-4 d-flex align-items-center"><span class="bullet bullet-dot bg-danger me-3"></span>Localisation</h4>
                    <div id="map-card">
                        <table class="table align-middle">
                            <tr>
                                <td><label class="form-label fw-semibold text-gray-800">Latitude:</label></td><td><?php echo $this->Form->input('latitude', array( 'id' => 'latitude_mag','label'=>false)); ?></td>
                                <td><label class="form-label fw-semibold text-gray-800">Longitude:</label></td><td><?php echo $this->Form->input('longitude', array( 'id' => 'longitude_mag','label'=>false)); ?></td>
                            </tr>
                        </table>
                        <div id="map-canvas"></div>
                    </div>
                </div>

                <?php
                echo $this->Form->end(array(
                    'label' => 'Envoyer',
                    'class' => 'btn btn-primary',
                    'div' => false
                ));
                ?>
                <div class="text-center mt-5">
                    <?php echo $this->Html->link('Annuler', array('action' => 'index'), array('class' => 'btn btn-light')); ?>
                </div>
            </div>
    </div>
</div>
<script>
    $(function () {
        $("#ClientSecteurId").select2();

        $("#ClientProduits").select2({
            placeholder: '-- Sélectionner les gammes --',
            allowClear: true,
            language: { noResults: function() { return 'Aucune gamme trouvée'; } }
        });

        $('#ClientHopitalSelectAdd').select2({
            tags: true,
            placeholder: '-- Choisir ou créer un hôpital --',
            allowClear: true,
            language: { noResults: function() { return 'Aucun hôpital trouvé'; } },
            createTag: function(params) {
                var term = $.trim(params.term);
                if (!term) return null;
                return { id: '__new__:' + term, text: term + ' (nouveau)', newTag: true };
            }
        });

        $('#ClientActiviteSelectAdd').on('change', function() {
            if ($(this).val() === 'Publique') {
                $('#hopital-field-add').slideDown(200);
            } else {
                $('#hopital-field-add').slideUp(200);
                $('#ClientHopitalSelectAdd').val(null).trigger('change');
            }
        });
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEpnSCwdoRPf5V3vIWy7j6wzjewQRC8uE&amp;"></script>
<script>
    var map;
    var markers = [];
    function initialize() {
        var haightAshbury = new google.maps.LatLng(<?php
                    if (!empty($this->request->data['Client']['latitude'])) {
                        echo $this->request->data['Client']['latitude'];
                        ?>, <?php
                        echo $this->request->data['Client']['longitude'];
                    } else {
                        echo "33.536814 , -7.600853";
                    }
                    ?>);
        var mapOptions = {
            zoom: 10,
            center: haightAshbury,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        google.maps.event.addListener(map, 'click', function (event) {
            addMarker(event.latLng);
            document.getElementById("latitude_mag").value = event.latLng.lat();
            document.getElementById("longitude_mag").value = event.latLng.lng();
        });
    }

    function addMarker(location) {
        deleteOverlays();
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            animation: google.maps.Animation.DROP
        });
        markers.push(marker);
    }
    function deleteOverlays() {
        if (markers) {
            for (i in markers) {
                markers[i].setMap(null);
            }
            markers.length = 0;
        }
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

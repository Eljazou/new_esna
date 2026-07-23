<?php echo $this->element('assets/datatables'); ?>
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{color:#fff !important;}
</style>
<!-- ============================================================
     Modal — potentialité du client
     ============================================================ -->
<div class="modal fade" id="gridSystemModal" tabindex="-1" aria-labelledby="gridModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="gridModalLabel">Merci de remplir la potentialité du client</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <?php echo $this->Form->create('Clientspropose', array('url' => array('action' => 'system_add_info'))); ?>
            <input type="hidden" name="data[Clientspropose][client_id]" class="inputid" value="40">
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Patients par jour</label>
                        <select name="data[Clientspropose][A]" class="form-select" id="ClientsproposeCategoryId" required="required">
                            <option value="">sélectionnez</option>
                            <option value="A">Plus de 20</option>
                            <option value="B">Entre 10 et 20</option>
                            <option value="C">Moins de 10</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Adoption des produits Esnapharm</label>
                        <select name="data[Clientspropose][1]" class="form-select" id="ClientsproposeCategoryId" required="required">
                            <option value="">sélectionnez</option>
                            <option value="1">Exclusif</option>
                            <option value="2">Fidèle</option>
                            <option value="3">Rare</option>
                            <option value="4">Non</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Classification</label>
                        <select name="data[Clientspropose][potentialitev2]" class="form-select" id="ClientsproposeCategoryId" required="required">
                            <option value="">sélectionnez</option>
                            <option value="PCM">PCM</option>
                            <option value="QAM">QAM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">La liste des produits</label>
                        <?php
                        echo $this->Form->input('produits', array('name' => "data[Clientspropose][produits]", 'label' => false, 'class' => 'form-select select2', 'multiple' => "multiple", 'required' => "required"));
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Envoyer">
            </div>
            </form>
        </div>
    </div>
</div>

<div class="row g-5 g-xl-8">
    <!-- ============================================================
         Feuille de route
         ============================================================ -->
    <div class="col-lg-10 mx-auto">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Feuille de route du
                        <?php
                        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                        if (!empty($listes))
                            echo strftime("%A %d %B %Y", strtotime($listes[0]['Feuilleroute']["date"]));
                        $nbDay = date('N', strtotime($listes[0]['Feuilleroute']["date"]));
                        $monday = new DateTime($listes[0]['Feuilleroute']["date"]);
                        $sunday = new DateTime($listes[0]['Feuilleroute']["date"]);
                        $date_debut = $monday->modify('-' . ($nbDay - 1) . ' days')->format('Y-m-d');
                        $date_fin = $sunday->modify('+' . (7 - $nbDay) . ' days')->format('Y-m-d');
                        ?>
                    </span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Semaine du <?php echo $date_debut; ?> au <?php echo $date_fin; ?></span>
                </h3>
                <div class="card-toolbar">
                    <?php
                    if ($listes[0]['Feuilleroute']["valide"] == 0)
                        echo '<span class="badge badge-light-warning fs-7 fw-bold">Feuille en cours de validation</span>';
                    else
                        echo '<span class="badge badge-light-success fs-7 fw-bold">Feuille valide</span>';
                    ?>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table id="example1" class="table table-row-bordered align-middle gy-4">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Type pharmacie</th>
                                <th>Spécialité</th>
                                <th>Activité</th>
                                <th>POT</th>
                                <th>Secteur</th>
                                <th>Visité</th>
                                <th>Distance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <?php
                        $map = "";

                        foreach ($listes as $value):
                            if (isset($value["Client"]["id"])) {
                        ?>
                            <tr <?php if ($value['Feuilleroute']["valide"] == 0) { echo 'class="table-warning"'; } ?>>

                                <td><?php echo $this->Html->link($value["Client"]["nom"] . ' ' . $value["Client"]["prenom"], array('controller' => 'clients', 'action' => 'view', $value["Client"]["id"]), array('class' => 'text-gray-800 text-hover-primary fw-semibold')); ?></td>
                                <td><?php if (isset($types)) echo $types[$value["Client"]["type_id"]]; ?></td>
                                <td><?php echo $value["Client"]["type_pharmacie"]; ?></td>
                                <td><?php echo $categories[$value["Client"]["category_id"]]; ?></td>
                                <td><?php echo $value["Client"]["activite"]; ?></td>
                                <td><?php echo $value["Client"]["potentialite"]; ?></td>
                                <td><?php echo $secteurs[$value["Client"]["secteur_id"]]; ?></td>

                                <td><?php
                                    $visit = 0;
                                    $v = array();
                                    foreach ($visites as $v) {
                                        if ($v["Visite"]["client_id"] == $value["Client"]["id"]) {
                                            $visite = $v;
                                            $visit = 1;
                                            break;
                                        }
                                    }
                                    if ($visit == 0)
                                        echo '<span class="badge badge-light-danger">Non</span>';
                                    else
                                        echo '<span class="badge badge-light-success">Oui</span>';
                                    $lan = $lal = 0;
                                    if ($value["Client"]["longitude"] != null && $value["Client"]["longitude"] != "")
                                        $lan = $value["Client"]["longitude"];
                                    if ($value["Client"]["latitude"] != null && $value["Client"]["latitude"] != "")
                                        $lal = $value["Client"]["latitude"];
                                    $value["Client"]["nom"] = str_replace("'", " ", $value["Client"]["nom"]);
                                    $map = $map . "['" . $value["Client"]["nom"] . "',$lan,$lal,". $visit . "],";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $distance = "--";
                                    if ($visit != 0 && $value["Client"]["longitude"] != "" && $value["Client"]["longitude"] != 0) {
                                        $distance = "Hors zone";
                                        if ($v["Visite"]["longitude"] != "" && $v["Visite"]["longitude"] != 0) {
                                            $lat1 = $value["Client"]["longitude"];
                                            $lon1 = $value["Client"]["longitude"];
                                            $lat2 = $v["Visite"]["longitude"];
                                            $lon2 = $v["Visite"]["longitude"];
                                            $theta = $lon1 - $lon2;
                                            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                                            $dist = acos($dist);
                                            $dist = rad2deg($dist);
                                            $miles = $dist * 60 * 1.1515;
                                            $distance = round($miles * 1.609344, 1) . " Km";
                                        }
                                    }
                                    echo $distance;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($visit == 0) {
                                        echo $this->Html->link('Enlever', array('action' => 'detail_feuille_route', $value['Feuilleroute']["user_id"], $value['Feuilleroute']["date"], $value['Feuilleroute']["id"]), array('class' => 'btn btn-sm btn-light-danger'));
                                    }
                                    if ($value['Feuilleroute']["valide"] == 1) {
                                        if ($visit == 0 && $this->requestAction('/droits/getrole/Visites/add') == 1)
                                            if ($value['Client']['potentialitev2'] == 'NR' || $value['Client']['potentialite'] == 'NR') {
                                                echo "<a data-bs-toggle='modal' data-bs-target='#gridSystemModal' class='btn btn-sm btn-light-primary' onclick='listeid(" . $value["Client"]['id'] . ")'>Visiter</a>";
                                            } else
                                                echo $this->Html->link('Visiter', array('controller' => 'visites', 'action' => 'add', $value["Client"]['id']), array('class' => 'btn btn-sm btn-light-primary'));
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php }
                        endforeach; ?>
                    </table>
                </div>
                <?php
                if ($this->requestAction('/droits/getrole/listes/validerFuilleDeRoute') == 1 && $listes[0]["Feuilleroute"]["user_id"] != AuthComponent::user('id')):
                ?>
                    <div class="d-flex justify-content-end mt-4">
                        <?php echo $this->Html->link("Valider", array('action' => 'validerFuilleDeRoute', $listes[0]['Feuilleroute']["user_id"], $listes[0]['Feuilleroute']["date"]), array('class' => 'btn btn-primary')); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ============================================================
         Map
         ============================================================ -->
    <div class="col-12">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Map</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Localisation des clients de la feuille de route</span>
                </h3>
            </div>
            <div class="card-body">
                <div id="map-canvas" class="w-100" style="height:430px;"></div>
                <input type="hidden" class="mapzoom" value="12">
                <input type="hidden" class="maplatleng" value="0">
            </div>
        </div>
    </div>
</div>

<?php
echo $this->Html->script('jquery.slimscroll.min');
echo $this->Html->script('fastclick');
echo $this->Html->script('demo');
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEpnSCwdoRPf5V3vIWy7j6wzjewQRC8uE&amp;&libraries=places"></script>
<script>

    function listeid(id) {
        $(".inputid").attr("value", id);
        $(".lienid").attr("href", "/visites/add/" + id);
    }
    $(function () {
        $("#ClientsproposeProduits").select2();
        //$("#example1").DataTable();
        $('#example1').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "iDisplayLength": 250,
            "aaSorting": []
        });
    });
</script>

<script>
        var mapzoom = $(".mapzoom").attr("value");
        var mapz = parseInt(mapzoom);
        var locations = [<?php echo $map; ?>];
        var last = parseInt(last);
        var maps = new google.maps.LatLng(33.5719036, -7.5873685);
        //console.log(locations[0][3]+","+locations[last][4]);
        function initialize()
        {

            var mapOptions = {
                zoom: 6 ,
                center: maps,
                mapTypeId: google.maps.MapTypeId.terrain
            };

            map = new google.maps.Map(document.getElementById('map-canvas'),
                    mapOptions);
            google.maps.event.addListenerOnce(map, "zoom_changed", function () {
                mapz = map.getZoom();
                $(".mapzoom").attr("value", mapz);
                //console.log(oldZoom);
            });
            google.maps.event.addListenerOnce(map, "center_changed", function () {
                maps = map.getCenter();
                $(".maplatleng").attr("value", maps);
                //console.log(oldCenter);
            });
            google.maps.event.addListenerOnce(map, "mouseup, click, double_click", function () {
                maps = map.getCenter();
                $(".maplatleng").attr("value", maps);
                mapz = map.getZoom();
                $(".mapzoom").attr("value", mapz);
                //console.log(oldCenter);
            });
            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (var i = 0; i < locations.length; i++) {
                var check = locations[i][3];

                   
                 if (check == 1) {
                    var v = '<?php echo $this->Html->url(array('controller' => '', 'action' => 'img/marker-v.png')); ?>';
                } else{
                    var v = '<?php echo $this->Html->url(array('controller' => '', 'action' => 'img/marker-r.png')); ?>';
                }

                var markerimg = {
                    url: v,
                    size: new google.maps.Size(30, 38),
                    scaledSize: new google.maps.Size(30, 38),
                    labelOrigin: new google.maps.Point(14, 13),
                }



                 if(locations[i][1]!="" && locations[i][2]!=""){
                    marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][2], locations[i][1]),
                    map: map,
                    icon: markerimg,
                    animation: google.maps.Animation.DROP
                })
                google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
                    return function () {
                        infowindow.setContent(locations[i][0] );
                        infowindow.open(map, marker);
                    }
                })(marker, i));

                google.maps.event.addListener(marker, 'mouseout', (function (marker, i) {
                    return function () {
                        infowindow.close(map, marker);
                    }
                })(marker, i));
                }
                else{

                }
                
            }
        }
        google.maps.event.addDomListener(window, 'load', initialize);


        $(window).load(function () {
            var h = $(window).height();
            $('#map-canvas, .annoncesmaps').height("430px");
        });

    </script>

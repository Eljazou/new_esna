<?php
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
$nbDay = date('N', strtotime(date('Y-m-d')));
$monday = new DateTime(date('Y-m-d'));
$date_debut = $monday->modify('-' . ($nbDay - 1) . ' days')->format('Y-m-d');
//echo $date_debut;
?>
<div class="card">

    <div class="card-body">
        <div class="card-header">
            <h3 class="card-title">La liste des feuilles de route à valider</h3>
        </div>

        <table class="table table-row-bordered table-row-gray-300 align-middle gy-4">
            <tbody>
                <tr>
                    <th>VM</th>
                    <th>Date</th>
                    <th>Nombre de clients</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($users as $user):
                    $feuilles = $this->requestAction('/listes/system_get_list_feuille_route_for_validation/' . $user['User']['id'] . '/' . $date_debut);
                    if (!empty($feuilles)):
                        foreach ($feuilles as $value):
                            if ($value['Feuilleroute']["valide"] == 0):
                                ?>
                                <tr>
                                    <td><?php echo $user["User"]["name"] ?></td>
                                    <td><?php echo strftime("%A %d %B %Y", strtotime($value['Feuilleroute']["date"])); ?></td>
                                    <td><?php echo $value[0]["num"] ?></td>
                                    <td><?php echo $this->Html->link('Voir', array('action' => 'detail_feuille_route', $value['Feuilleroute']["user_id"], $value['Feuilleroute']["date"]), array('class' => 'btn btn-primary')); ?></td>
                                </tr>
                                <?php
                            endif;
                        endforeach;
                    endif;
                endforeach;
                ?>
            </tbody>
        </table>

    </div>
</div>
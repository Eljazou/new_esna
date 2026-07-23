<?php echo $this->element('assets/datatables'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo __('Commandes'); ?></h3>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
            <thead>
                <tr>
                    <th>VMP</th>
                    <th>Client</th>
                    <th>Paiement</th>
                    <th>Réduction 2%</th>
                    <th><?php echo __('Quantité des produits'); ?></th>
                    <th><?php echo __('Total en Dhs'); ?></th>
                    <th>Date de création</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?php echo $this->Html->link($commande['User']['name'], array('controller' => 'users', 'action' => 'view', $commande['User']['id'])); ?></td>
                    <td><?php echo $this->Html->link($commande['Client']['nom'].' '.$commande['Client']['prenom'], array('controller' => 'clients', 'action' => 'view', $commande['Client']['id'])); ?></td>
                    <td><?php echo h($commande['Commande']['paiement']); ?>&nbsp;</td>
                    <td><?php if($commande['Commande']['surplace']==null || $commande['Commande']['surplace']=='') echo 'Non';else echo "Oui"; ?>&nbsp;</td>
                    <td><?php $info=$this->requestAction('/commandes/system_get_total_and_quantite/'.$commande['Commande']['id']);
                        $info=explode('||',$info);
                             echo $info[1]; ?></td>
                    <td><?php echo $info[0]*1.2; ?> Dhs</td>
                    <td><?php echo h($commande['Commande']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
								<i class="ki-duotone ki-setting-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>&nbsp;<span class=""></span>
							</button>
                            <ul class="dropdown-menu" role="menu">
                                <li><?php echo $this->Html->link(__('Voir'), array('action' => 'view', $commande['Commande']['id'])); ?></li>
                                <li><?php echo $this->Html->link(__('Editer'), array('action' => 'edit', $commande['Commande']['id'])); ?></li>
                                <li><?php 
                                if($commande['Commande']['archive']==0 && $this->requestAction('/droits/getrole/commandes/archive')==1)
                                {
                                    echo $this->Html->link(__('Valider'), array('action' => 'archive', $commande['Commande']['id'],1));
                                    echo $this->Html->link(__('Archiver'), array('action' => 'archive', $commande['Commande']['id'],-1));
                                }
                                ?></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php
echo $this->Html->script('jquery.slimscroll.min');
echo $this->Html->script('fastclick');
echo $this->Html->script('demo');
?>
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
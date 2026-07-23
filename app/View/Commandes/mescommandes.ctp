<?php echo $this->element('assets/datatables'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo __('Commandes'); ?></h3>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Paiement</th>
                    <th>Réduction 2%</th>
                    <th><?php echo __('Quantité des produits'); ?></th>
                    <th><?php echo __('Total en Dhs'); ?></th>
					<th><?php echo __('Validation'); ?></th>
                    <th>Date de création</th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?php 
                    if($commande['Commande']['client_id']!=null)
                        echo $this->Html->link($commande['Client']['nom'].' '.$commande['Client']['prenom'], array('controller' => 'clients', 'action' => 'view', $commande['Client']['id']));
                    else
                        echo h($commande['Commande']['nom']);
                    ?></td>
                    <td><?php echo h($commande['Commande']['paiement']); ?></td>
                    <td><?php if($commande['Commande']['surplace']==null || $commande['Commande']['surplace']=='') echo 'Non';else echo "Oui"; ?></td>
                    <td><?php $info=$this->requestAction('/commandes/system_get_total_and_quantite/'.$commande['Commande']['id']);
                        $info=explode('||',$info);
                             echo $info[1]; ?></td>
                    <td><?php echo $info[0]*1.2; ?> Dhs</td>
					<td><?php if($commande['Commande']['archive']==0)
						echo '<span class="badge bg-warning">En cours de validation</span>';
					if($commande['Commande']['archive']==1)
						echo '<span class="badge bg-success">Validé</span>'; ?>
					</td>
                    <td><?php echo h($commande['Commande']['created']); ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Voir'), array('action' => 'view', $commande['Commande']['id']), array( 'class' => "btn btn-primary btn-large")); ?>
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
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "searching": false,
			"bSort": false,
            "iDisplayLength": 250,
            "aaSorting": []
        });
    });
</script>
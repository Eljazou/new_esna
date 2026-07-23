<?php echo $this->element('assets/datatables'); ?>
<div class="card">
      <div class="card-header table-responsive">
           <h3 class="card-title"><?php echo __('Packs'); ?></h3>
		 			<?php echo $this->Html->link(__('Ajouter'), array('action' => 'add', ),array('style'=>'float:right;','class'=>'btn bg-primary')); ?>
      </div>
	<div class="card-body">
         <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
		 <thead>
			<tr>
							<th>id</th>
							<th>user_id</th>
							<th>client_id</th>
							<th>nombre</th>
							<th>created</th>
							<th class="actions">Actions</th>
			</tr>
	</thead>
	<?php foreach ($packs as $pack): ?>
	<tr>
		<td><?php echo h($pack['Pack']['id']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($pack['User']['name'], array('controller' => 'users', 'action' => 'view', $pack['User']['id'])); ?></td>
		<td><?php echo $this->Html->link($pack['Client']['id'], array('controller' => 'clients', 'action' => 'view', $pack['Client']['id'])); ?></td>
		<td><?php echo h($pack['Pack']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($pack['Pack']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Voir'), array('action' => 'view', $pack['Pack']['id']),array('class'=>'btn btn-info')); ?>
			<?php echo $this->Html->link(__('Editer'), array('action' => 'edit', $pack['Pack']['id']),array('class'=>'btn btn-warning')); ?>
			<?php echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $pack['Pack']['id']), array('class'=>'btn btn-danger'), __('Etes-vous sur de vouloir supprimer ?')); ?>
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
			<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script>
  $(function () {
    $('#example1').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": true,
            "bSort": false,
            "iDisplayLength": 250,
            "aaSorting": [],
			dom: 'Bfrtip',
			buttons: [
				 'excel'
			]
        });
  });
</script>
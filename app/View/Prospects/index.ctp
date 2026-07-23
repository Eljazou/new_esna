<?php echo $this->element('assets/datatables'); ?>
<?php
        echo $this->Html->css('btn-style');
		?>	
<div class="card">
      <div class="card-header table-responsive">
           <h3 class="card-title"><?php echo __('Prospects'); ?></h3>
		 
		 			<?php
			if( $this->requestAction('/droits/getrole/prospects/add')==1)
					echo $this->Html->link(__(''), array('action' => 'add',),array( 'class'=>'fa fa-plus btn-sc btn btn-outline-success ' ,'style'=>'float:right;'));
				if( $this->requestAction('/droits/getrole/prospects/import')==1)
					echo $this->Html->link("Import (Client et Prospect)", array('action' => 'import'),array( 'class'=>'btn btn-outline-success ' ,'style'=>'float:right;'));
				if( $this->requestAction('/droits/getrole/prospects/export')==1)
					echo $this->Html->link("Export (Client et Prospect)", array('action' => 'export'),array( 'class'=>'btn btn-outline-success ' ,'style'=>'float:right;'));
				if( $this->requestAction('/droits/getrole/rapportprocpects/import_feuille')==1)
					echo $this->Html->link("Import feuille de route", array("controller"=>"rapportprocpects",'action' => 'import_feuille',),array( 'class'=>'btn btn-outline-success ' ,'style'=>'float:right;'));
				if( $this->requestAction('/droits/getrole/rapportprocpects/export_feuille')==1)
					echo $this->Html->link("Export feuille de route", array("controller"=>"rapportprocpects",'action' => 'export_feuille'),array( 'class'=>'btn btn-outline-success ' ,'style'=>'float:right;'));
				?>

      </div>
	<div class="card-body">
         <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4" >
		 <thead>
			<tr>
				<th>societe</th>
				<th>nom</th>
				<th>adresse</th>
				<th>ville</th>
				<th>portable</th>
				<th>categorie</th>
				<th>type</th>
				<th class="actions">Actions</th>
			</tr>
	</thead>
	<tbody>
	<?php foreach ($prospects as $prospect): ?>
	<tr>
		<td><?php echo h($prospect['Prospect']['societe']); ?>&nbsp;</td>
		<td><?php echo $prospect['Prospect']['nom']." ".$prospect['Prospect']['prenom']; ?>&nbsp;</td>
		<td><?php echo $prospect['Prospect']['adresse1']." ".$prospect['Prospect']['adresse2']; ?>&nbsp;</td>
		<td><?php echo h($prospect['Prospect']['ville']); ?>&nbsp;</td>
		<td><?php echo h($prospect['Prospect']['portable']); ?>&nbsp;</td>
		<td><?php echo h($prospect['Prospect']['categorie']); ?>&nbsp;</td>
		<td><?php echo h($prospect['Prospect']['type']); ?>&nbsp;</td>
		<td class="actions">
			<?php
			if( $this->requestAction('/droits/getrole/prospects/view')==1)
				echo $this->Html->link(__(''), array('action' => 'view', $prospect['Prospect']['id']),array('class'=>'fa fa-eye btn-in btn btn-outline-info')); ?>
			<?php 
			if( $this->requestAction('/droits/getrole/prospects/edit')==1)
				echo $this->Html->link(__(''), array('action' => 'edit', $prospect['Prospect']['id']), array('class' => 'fa fa-pencil btn-wr btn btn-outline-warning')); ?>
			<?php 	if( $this->requestAction('/droits/getrole/prospects/delete')==1)
					echo $this->Form->postLink(__(''), array('action' => 'delete', $prospect['Prospect']['id']),array('class'=>'fa fa-trash btn-dn btn btn-outline-danger'), __('Etes-vous sur de vouloir supprimer ?'));?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<div class="paging">
                <?php
                echo $this->Paginator->prev('< ' . __('Précédent'), array(), null, array('class' => 'prev disabled'));
                echo $this->Paginator->numbers(array('separator' => ''));
                echo $this->Paginator->next(__('Suivant') . ' >', array(), null, array('class' => 'next disabled'));
                ?>
            </div>
	</div>
	</div>
	<?php
        echo $this->Html->script('jquery.slimscroll.min');

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
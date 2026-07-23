<div class="card">
	<div class="card-header">
        <h3 class="card-title"><span class="glyphicon glyphicon-plus"></span> <?php echo __('Editer l\'objectif'); ?></h3>
    </div>
	<div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
				<?php echo $this->Form->create('Objectif'); ?>
	<?php
		echo $this->Form->input('id',array('class'=>'form-control'));
		echo $this->Form->input('type_id',array('label' => 'Type','class'=>'form-control'));
		echo $this->Form->input('user_id',array('label' => 'Utilisateur','class'=>'form-control'));
		echo $this->Form->input('objectif',array('label' => 'Objectif','class'=>'form-control'));
	?>
<?php echo $this->Form->end(array('label' => 'Envoyer','class'=>'btn btn-primary btn-large','div' => array('class' => 'card card-body bg-light text-center'))); ?>
</div>
</div>
</div>
</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $this->Form->value('Objectif.id')), null, __('Etes-vous sur de vouloir supprimer  # %s?' , $this->Form->value('Objectif.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Liste des Objectifs'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Liste des Types'), array('controller' => 'types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nouveau Type'), array('controller' => 'types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Liste d\'utilisateurs'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nouveau utilisateur'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>

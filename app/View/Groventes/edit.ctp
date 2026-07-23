<div class="card">
	<div class="card-header">
        <h3 class="card-title"><span class="glyphicon glyphicon-plus"></span> <?php echo __('Edit Grovente'); ?></h3>
    </div>
	<div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
				<?php echo $this->Form->create('Grovente'); ?>
	<?php
		echo $this->Form->input('id',array('class'=>'form-control'));
		echo $this->Form->input('grosiste_id',array('class'=>'form-control'));
		echo $this->Form->input('groproduit_id',array('class'=>'form-control'));
		echo $this->Form->input('user_id',array('class'=>'form-control'));
		echo $this->Form->input('quantite',array('class'=>'form-control'));
		echo $this->Form->input('date',array('class'=>'form-control'));
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Grovente.id')), null, __('Etes-vous sur de vouloir supprimer  # %s?' , $this->Form->value('Grovente.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Groventes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Grosistes'), array('controller' => 'grosistes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grosiste'), array('controller' => 'grosistes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groproduits'), array('controller' => 'groproduits', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Groproduit'), array('controller' => 'groproduits', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>

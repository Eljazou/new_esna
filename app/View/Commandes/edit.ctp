<div class="card">
	<div class="card-header">
        <h3 class="card-title"><span class="glyphicon glyphicon-plus"></span> <?php echo __('Editer la commande'); ?></h3>
    </div>
	<div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
				<?php echo $this->Form->create('Commande'); ?>
	<?php
		echo $this->Form->input('id',array('class'=>'form-control'));
		echo $this->Form->input('user_id',array('label' => 'Utilisateur','class'=>'form-control'));
		echo $this->Form->input('client_id',array('label' => 'Client','class'=>'form-control'));
	?>
<?php echo $this->Form->end(array('label' => 'Envoyer','class'=>'btn btn-primary btn-large','div' => array('class' => 'card card-body bg-light text-center'))); ?>
</div>
</div>
</div>
</div>
</div>

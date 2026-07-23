<div class="card">
    <div class="card-header">
        <h3 class="card-title" style="padding-left: 0px;margin-left: -7px;"><?php echo __('Edit Avence'); ?></h3>
    </div>
    <div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
                    <?php echo $this->Form->create('Avence'); ?>
                    <?php
                    echo $this->Form->input('id', array('class' => 'form-control'));
                    echo $this->Form->input('type', array('class' => 'form-control'));
                    echo $this->Form->input('montant', array('class' => 'form-control'));
                    //echo $this->Form->input('echeances', array('class' => 'form-control'));
                    echo $this->Form->input('motif', array('class' => 'form-control'));
                    ?>
                    <?php echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary btn-large', 'div' => array('class' => 'card card-body bg-light text-center col-md-12'))); ?>
                </div>
            </div>
        </div>
    </div>
</div>
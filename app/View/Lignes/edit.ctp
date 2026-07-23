<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo __('Edit ligne'); ?></h3>
    </div>
    <div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
                    <?php echo $this->Form->create('Ligne');
                    echo $this->Form->input('id', array('class' => 'form-control'));
                    echo $this->Form->input('name', array('class' => 'form-control', 'label' => 'Ligne'));
                    echo $this->Form->input('message_event', array('class' => 'form-control', 'label' => 'Message d\'événement', 'type' => 'textarea', 'style' => 'height: 100px;'));
                    echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary btn-large', 'div' => array('class' => 'card card-body bg-light text-center'))); ?>
                </div>
            </div>
        </div>
    </div>
</div>


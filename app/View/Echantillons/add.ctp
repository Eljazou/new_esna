<div class="card">
    <div class="card-header">
        <h3 class="card-title" style="padding-left: 0px;margin-left: -7px;"> <?php echo __('Ajouter un échantillon'); ?></h3>
    </div>
    <div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
                    <?php echo $this->Form->create('Echantillon');
                     echo $this->Form->input('game_id', array('label' => 'La gamme', 'class' => 'form-control'));
                    echo $this->Form->input('name', array('label' => 'Nom du produit', 'class' => 'form-control'));
                   echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary btn-large', 'div' => array('class' => 'card card-body bg-light text-center col-md-12'))); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"> <?php echo __('Modifier le document'); ?></h3>
    </div>
    <div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
                    <?php echo $this->Form->create('Document'); 
                    echo $this->Form->input('id', array('class' => 'form-control'));
                    $sizes = array('Attestation de Travail' => 'Attestation de Travail',
                            'Attestation de Salaire' => 'Attestation de Salaire',
                            'Attestation de domiciliation de Salaire' => 'Attestation de domiciliation de Salaire',
                            'Attestation de Congé'=>'Attestation de Congé',
                            "Bulletins de Paie"=>'Bulletins de Paie',
                            "Bordereau de déclaration de Salaire"=>"Bordereau de déclaration de Salaire",
                            "Déclaration de Maladie"=>"Déclaration de Maladie");
                        echo $this->Form->input('document', array('options' => $sizes,'class'=>'form-control'));
                        echo $this->Form->input('description', array('label' => "Si vous avez des spicification",'class'=>'form-control'));
                        echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary btn-large', 'div' => array('class' => 'card card-body bg-light text-center'))); ?>
                </div>
            </div>
        </div>
    </div>
</div>

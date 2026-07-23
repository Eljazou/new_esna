<div class="card">
    <div class="card-header">
        <h3 class="card-title">Modifier la potentialité</h3>
    </div>
    <div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
                    <?php echo $this->Form->create('Pot');
						 echo $this->Form->input('id');
						 echo $this->Form->input('game_id', array('label' => 'Gamme', 'class' => 'form-control'));
						 echo $this->Form->input('user_id', array('label' => 'VM', 'class' => 'form-control'));
						 echo $this->Form->input('nb_patient', array('label' => 'nombre de patient/j', 'class' => 'form-control'));
						 $types=["A"=>"A","B"=>"B","C"=>"C"];
						 echo $this->Form->input('pot_patient', array("options"=>$types,'label' => 'potentialité de patient', 'class' => 'form-control'));
						 
						 echo $this->Form->input('nb_indication', array('label' => 'nombre de indication/j', 'class' => 'form-control'));
						 $types=["H"=>"H","M"=>"M","L"=>"L"];
						 echo $this->Form->input('pot_indication', array("options"=>$types,'label' => "potentialité de l'indication", 'class' => 'form-control'));
						 
						 echo $this->Form->input('nb_prescription', array('label' => 'nombre de prescription', 'class' => 'form-control'));
						 $types=["H"=>"H","M"=>"M","L"=>"L"];
						 echo $this->Form->input('pot_prescription', array("options"=>$types,'label' => "potentialité de prescription", 'class' => 'form-control'));
						 echo $this->Form->input('commentaire', array('class' => 'form-control'));
					echo $this->Form->end(array('label' => 'Editer',"required"=>"required", 'class' => 'btn btn-primary btn-large', 'div' => array('class' => 'card card-body bg-light text-center col-md-12'))); ?>
                </div>
            </div>
        </div>
    </div>
</div>


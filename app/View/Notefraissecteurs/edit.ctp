<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Note frais secteurs</h3>
            </div>



            <div class="card-body">
                <?php echo $this->Form->create('Notefraissecteur'); ?>
                <?php
				echo $this->Form->input('id');
                echo $this->Form->input('ville', array("options" => $villes, 'class' => 'form-control'));
                echo $this->Form->input('destination', array("options" => $villes, 'class' => 'form-control'));
                $options = array("Ville" => 'Ville de départ', 'destination'=>'destination');
                echo $this->Form->input('nuit',array('options' => $options,'class'=>'form-control'));
                echo $this->Form->input('urbain', array('class' => 'form-control'));
                echo $this->Form->input('interville', array('class' => 'form-control'));
                echo $this->Form->input('hotel', array('class' => 'form-control'));
                echo $this->Form->input('restaurant', array('class' => 'form-control'));
                echo $this->Form->input('divers', array('class' => 'form-control'));
                ?>

            </div>
            <div class="card-footer">
                <?php echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-success', 'div' => array('class' => 'card card-body bg-light text-center'))); ?>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
           $(function () {
        $("#NotefraissecteurVille, #NotefraissecteurDestination").select2();
    });
     </script>
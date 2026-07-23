<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo __('Editer'); ?></h3>
    </div>
    <div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
                    <?php echo $this->Form->create('Autoechantiant'); ?>
                    <?php
                    echo $this->Form->input('id', array('class' => 'form-control'));
                    $data=$this->request->data["Autoechantiant"]["gadjets"];
                    $data= explode("||", $data);
                    for ($i = 0; $i < 5; $i++) {
                        echo '<div class="card-header"><h4> '.($i+1) .' echantillon</h4>';
                        if(isset($data[$i]))
                        {
                            $info= explode("&&", $data[$i]);
                            echo $this->Form->input('a.'.$i.'.echantillons', array('label' => "Echantillon",'class' => 'form-control',
                                'type'=>'select', 'options'=>$echantillons, 'default'=>$info[0]));
                            echo $this->Form->input('a.'.$i.'.nombre', array('label' => "Nombre de boite",'class' => 'form-control','value'=>$info[1]));
                        }
                        else
                        {
                            echo $this->Form->input('a.'.$i.'.echantillons', array('label' => "Echantillon",'class' => 'form-control'));
                            echo $this->Form->input('a.'.$i.'.nombre', array('label' => "Nombre de boite",'class' => 'form-control'));
                        }
                        echo "</div>";
                    }
                    ?>
                    <?php echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary btn-large', 'div' => array('class' => 'card card-body bg-light text-center'))); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
      <div class="card-header table-responsive">
           <h3 class="card-title">Ajouter le nombre de contacts à atteindre par région et par produit</h3>
      </div>
	  <?php echo $this->Form->create('Odpobjectif'); ?>
	  <div class="card">
			<div class="card-body">
				<div class="col-lg-6">
					<div class="card">
						<div class="card-body payment-form">
							<?php
								echo $this->Form->input('date_debut',array('class'=>'form-control'));
								echo $this->Form->input('date_fin',array('class'=>'form-control'));
								 ?>
						</div>
					</div>
				</div>
			</div>
		</div>

	<div class="card-body">
         <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
		 <thead>
			<tr>
				<th>Regions</th>
				<?php $region_odp=array("CASA"=>"CASA","ORIENT"=>"ORIENT","RABAT"=>"RABAT","MARRAKECH"=>"MARRAKECH","TANGER"=>"TANGER","AGADIR"=>"AGADIR"); 
					 foreach($region_odp as $k=>$v)
						echo "<th>$v</th>";
				?>
			</tr>
	</thead>
	<?php 
	
	foreach ($brochures as $id=>$v): 
		echo $this->Form->hidden("brochure.$id");
	?>
	<tr>
		<td> <?php echo $v; ?></td>
		<?php $region_odp=array("CASA"=>"CASA","ORIENT"=>"ORIENT","RABAT"=>"RABAT","MARRAKECH"=>"MARRAKECH","TANGER"=>"TANGER","AGADIR"=>"AGADIR"); 
					 foreach($region_odp as $k=>$v)
						echo "<td>".$this->Form->input("brochure.$id.$v",array("label"=>false,'class'=>'form-control'))."</td>";
				?>
	</tr>
<?php endforeach; ?>
	</table>
	</div>
	</div>
	
<?php echo $this->Form->end(array('label' => 'Envoyer','class'=>'btn btn-primary btn-large','div' => array('class' => 'card card-body bg-light text-center col-md-12'))); ?>


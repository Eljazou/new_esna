<?php echo $this->element('assets/datatables'); ?>
<div class="col-12">
<div class="card">
    <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
        <thead>
            <tr>
				<th>Liste</th>
                <th>Type</th>
                <th>Client</th>
                <th>Region</th>
                <th>Ville</th>
                <th>Secteur</th>
                <th>Spécialité</th>
                <th>Tendance</th>
                <th>POT</th>
                <th>Activite</th>
                <th>VM</th>
				<th>Ligne</th>
            </tr>
        </thead>
        <?php foreach ($data as $k=>$vv):
				$k=explode("--",$k);
				$nom_liste=$k[1];
				$k=$k[0];
                foreach ($vv["client"] as $v):  ?>
            <tr>
				<td><?php echo $nom_liste; ?>&nbsp;</td>
				<td><?php echo $types[$v['Client']['type_id']]; ?>&nbsp;</td>
                <td><?php echo $v['Client']['nom']." ".$v['Client']['prenom']; ?>&nbsp;</td>
                <?php 
				$region=$ville=$secteur="";
				foreach($secteurs as $s)
					{
						if($v['Client']['secteur_id']==$s["Secteur"]["id"])
						{
							$region=$s["Secteur"]["region"];
							$ville=$s["Secteur"]["ville"];
							$secteur=$s["Secteur"]["secteur"];
							break;
						}
					}?>
				<td><?php echo $region; ?>&nbsp;</td>
				<td><?php echo $ville; ?>&nbsp;</td>
				<td><?php echo $secteur; ?>&nbsp;</td>
                <td><?php echo $categories[$v['Client']['category_id']]; ?>&nbsp;</td>
				<td><?php if($v['Client']['category1_id']!="" && $v['Client']['category1_id']!=null)
							echo $categories[$v['Client']['category1_id']]; ?>&nbsp;</td>
                <td><?php echo $v['Client']['potentialite']; ?>&nbsp;</td>
                <td><?php echo $v['Client']['activite']; ?>&nbsp;</td>
                <td><?php echo $k; ?>&nbsp;</td>
				<td><?php 
					foreach($lignes as $ligne)
					{
						if($k==$ligne["users"]["name"])
						{
							echo $ligne["lignes"]["name"];
							break;
						}
					}?>&nbsp;</td>
            </tr>
        <?php endforeach; 
        endforeach;
        ?>
    </table>
</div>
</div>

<?php
echo $this->Html->script('fastclick');
echo $this->Html->script('demo');
echo $this->Html->script('jquery.flot.min');
echo $this->Html->script('jquery.flot.resize.min');
echo $this->Html->script('jquery.flot.pie.min');
echo $this->Html->script('jquery.flot.categories.min');
echo $this->Html->script('jquery.slimscroll.min');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script>
    $(function () {
        //$("#example1").DataTable();
        $('#example1').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "bSort": false,
            "iDisplayLength": 250,
            "aaSorting": [],
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'print'
            ]
        });
    });
</script>

<?php
/**
 * AJAX fragment: rendered with the 'login' layout (flash + content only) and
 * injected into #tabclient by Clients/index.ctp. DataTables is NOT included
 * here on purpose -- the parent page already loaded it, and this layout has
 * no fetch('script') block, so an include would be silently dropped.
 */
?>
<style>
    
	.dt-button{width:auto;float:left;margin:5px;font-size:16px;line-height:22px;padding:3px 8px;background:#337ab7;color:#fff; }
	.dt-button:hover{color:#fff;background:#1a486f;}
</style>
<div class="card">
    <div class="card-body">
       <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
            <thead>
                <tr>
					<th>Code</th>
                    <th>Type</th>
                    <th>Nom & prénom</th>
					<th>Activité</th>
					<th>Region</th>
					<th>Ville</th>
                    <th>Secteur</th>
                    <th>Spécialité</th>
					<th>Tendance</th>
                    <th>Potentialité</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
			<tfoot>
                <tr>
					<th>Code</th>
                    <th>Type</th>
                    <th>Nom & prénom</th>
					<th>Activité</th>
					<th>Region</th>
					<th>Ville</th>
                    <th>Secteur</th>
                    <th>Spécialité</th>
					<th>Tendance</th>
                    <th>Potentialité</th>
                    <th>Actions</th>
                </tr>
           </tfoot>
<?php foreach ($clients as $client): ?>
                <tr>
					<td><?php $typ=substr($client['Category']['name'], 0, 3);
							$typ = strtoupper($typ);
							echo $client['Secteur']["code_region"].$client['Secteur']["code_ville"].$client['Secteur']["code_secteur"].$typ.$client['Client']['id'];?>
					</td>
                    <td><?php echo $this->Html->link($client['Type']['name'], array('controller' => 'types', 'action' => 'view', $client['Type']['id']),array("target"=>"_blanck")); ?></td>
                    <td><?php echo $this->Html->link($client['Client']['nom'].' '.$client['Client']['prenom'], array('action' => 'view', $client['Client']['id']),array("target"=>"_blanck")); ?>&nbsp;</td>
					<td><?php echo h($client['Client']['activite']); ?>&nbsp;</td>
					<td><?php echo h($client['Secteur']['region']); ?>&nbsp;</td>
					<td><?php echo h($client['Secteur']['ville']); ?>&nbsp;</td>
                    <td><?php echo $this->Html->link($client['Secteur']['secteur'], array('controller' => 'secteurs', 'action' => 'view', $client['Secteur']['id']),array("target"=>"_blanck")); ?></td>
                    <td><?php
                            echo $this->Html->link($client['Category']['name'], array('controller' => 'categories', 'action' => 'view', $client['Category']['id']),array("target"=>"_blanck"));                            
                        ?>
                    </td>
					<td><?php echo $this->Html->link($client['Category1']['name'], array('controller' => 'categories', 'action' => 'view', $client['Category1']['id']),array("target"=>"_blanck")); ?></td>
                    <td><?php echo h($client['Client']['potentialitev2']); ?>&nbsp;</td>
                    <td class="actions">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="ki-duotone ki-setting-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>&nbsp;<span class=""></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><?php if ($this->requestAction('/droits/getrole/clients/view') == 1)
                            echo $this->Html->link(__('Voir'), array('action' => 'view', $client['Client']['id']),array("target"=>"_blanck"));
                        ?></li>
                                <li><?php if ($this->requestAction('/droits/getrole/clients/edit') == 1)
                            echo $this->Html->link(__('Editer'), array('action' => 'edit', $client['Client']['id']),array("target"=>"_blanck"));
                        ?></li>
                                <li><?php if ($this->requestAction('/droits/getrole/clients/archive') == 1)
                            echo $this->Html->link(__('Archiver'), array('action' => 'archive', $client['Client']['id'], 0),array("target"=>"_blanck"));
                        ?></li>
                            </ul>
                        </div>
                    </td>
                </tr>
<?php endforeach; ?>
        </table>
   </div>
</div>
<?php
/**/
/*echo $this->Html->script('jquery.slimscroll.min');
echo $this->Html->script('fastclick');
echo $this->Html->script('demo');*/
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script>
//$(function () {});
	$(document).ready(function() {
        //$("#example1").DataTable();
      $('#example1').DataTable({
			"paging": true,
            "searching": true,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "iDisplayLength": 50,
			dom: 'Bfrtip',
			buttons: [
				 'csv', 'excel', 'print'
			]
        });
    });
	/* $('#example1').DataTable({
				dom: 'Bfrtip',
				buttons: [
				 'csv', 'excel', 'print'
				]
	});*/

$(document).ready(function() {
		   var conte = 0;		
		 $('#example1 tfoot th').each(function(){
			var title = $(this).text();
			$(this).html('<input type="text" placeholder="'+title+'" class="'+conte+'"/>');
			conte = conte+1;
		});
	 
 // DataTable
    var table = $('#example1').DataTable();
 
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
});
</script>
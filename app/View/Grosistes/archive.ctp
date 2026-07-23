<?php echo $this->element('assets/datatables'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo __('Grosistes'); ?></h3>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
            <thead>
                <tr>
                    <th>Ref</th>
                    <th>Nom</th>
                    <th>Responsable</th>
                    <th>Region</th>
                    <th>Date d'ajout</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
	<?php foreach ($grosistes as $grosiste): ?>
            <tr>
                <td><?php echo h($grosiste['Grosiste']['id']); ?>&nbsp;</td>
                <td><?php echo h($grosiste['Grosiste']['name']); ?>&nbsp;</td>
                <td><?php echo $this->requestAction('/users/system_get_name_user/'.$grosiste['Grosiste']['super_id']); ?>&nbsp;</td>
                <td><?php echo h($grosiste['Grosiste']['region']); ?>&nbsp;</td>
                <td><?php echo h($grosiste['Grosiste']['created']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Désarchiver'), array('action' => 'archive', $grosiste['Grosiste']['id'],1)); ?>
                </td>
            </tr>
<?php endforeach; ?>
        </table>
    </div>
</div>
	<?php
        echo $this->Html->script('jquery.slimscroll.min');
        echo $this->Html->script('fastclick');
        echo $this->Html->script('demo');
        ?>
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
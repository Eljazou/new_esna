<?php echo $this->element('assets/datatables'); ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style type="text/css">
    :root {
        --primary: #6C63F5;
        --primary-light: #ede9ff;
    }

    body, .card, table, .dropdown-menu {
        font-family: 'Poppins', sans-serif;
    }

    .card {
        border-radius: 18px !important;
        border: none !important;
        box-shadow: 0 4px 16px rgba(108, 99, 245, 0.06) !important;
        background: #fff !important;
    }

    .card-header {
        border: none !important;
        padding: 22px 24px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title {
        font-size: 15.5px;
        font-weight: 700;
        color: #2b2b45;
    }

    .card-body {
        padding: 8px 24px 24px;
    }

    /* Table */
    table.dataTable thead th,
    #example1 thead th {
        background: #f4f2ff;
        color: #5b52e0;
        font-weight: 700;
        font-size: 13px;
        border: none !important;
    }

    table.table-row-bordered td, table.table-row-bordered th {
        border-color: #eef0fa !important;
    }

    table.table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #fbfbff;
    }

    #example1 td a {
        color: var(--primary);
        font-weight: 500;
    }

    #example1 td a:hover {
        color: #5479f7;
        text-decoration: underline;
    }

    /* Actions dropdown */
    td.actions .btn-group .btn {
        background: var(--primary-light) !important;
        color: var(--primary) !important;
        border: none !important;
        border-radius: 20px !important;
        padding: 6px 16px !important;
        font-weight: 600 !important;
        font-size: 13px !important;
    }

    td.actions .btn-group .btn:hover,
    td.actions .btn-group .btn:focus {
        background: var(--primary) !important;
        color: #fff !important;
    }

    td.actions .dropdown-menu {
        border-radius: 12px !important;
        border: none !important;
        box-shadow: 0 8px 24px rgba(108, 99, 245, .18) !important;
        padding: 6px !important;
        overflow: hidden;
    }

    td.actions .dropdown-menu li a {
        border-radius: 8px !important;
        padding: 8px 14px !important;
        font-size: 13.5px !important;
        color: #2b2b45 !important;
    }

    td.actions .dropdown-menu li a:hover {
        background: var(--primary-light) !important;
        color: var(--primary) !important;
    }

    /* ===== DataTables controls: length, search, info, pagination ===== */
    .dataTables_wrapper {
        padding-top: 4px;
    }

    .dataTables_length,
    .dataTables_filter,
    .dataTables_info {
        color: #6b6b85 !important;
        font-size: 13.5px;
    }

    .dataTables_length select {
        border: 1.5px solid #e7e6f7 !important;
        border-radius: 8px !important;
        padding: 4px 10px !important;
        font-size: 13.5px;
        color: #2b2b45;
        box-shadow: none !important;
        margin: 0 6px;
    }

    .dataTables_filter input {
        border: 1.5px solid #e7e6f7 !important;
        border-radius: 20px !important;
        padding: 7px 16px !important;
        font-size: 13.5px !important;
        margin-left: 8px !important;
        box-shadow: none !important;
    }

    .dataTables_filter input:focus {
        border-color: var(--primary) !important;
        outline: none;
    }

    .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        border: 1.5px solid transparent !important;
        color: #6b6b85 !important;
        padding: 6px 12px !important;
        margin-left: 4px !important;
        background: transparent !important;
    }

    .dataTables_paginate .paginate_button:hover {
        background: var(--primary-light) !important;
        color: var(--primary) !important;
        border-color: transparent !important;
    }

    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button.current:hover {
        background: var(--primary) !important;
        color: #fff !important;
        border-color: var(--primary) !important;
    }

    .dataTables_paginate .paginate_button.disabled,
    .dataTables_paginate .paginate_button.disabled:hover {
        color: #c7c7d8 !important;
        background: transparent !important;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after {
        color: #a9a4f0 !important;
        opacity: .6;
    }
</style>

<?php //debug($listes,0,0);?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo __('Les listes archivées'); ?></h3>

    </div>
    <div class="card-body">
        <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
            <thead>
                <tr>
                    <th>Liste</th>
                    <th>Collaborateur</th>
                    <th>Date de création</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>

            <?php foreach ($listes as $l): ?>
                <tr>
                    <td><?php echo $l['Liste']['name']; ?>&nbsp;</td>
                    <td> <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'view', $l['User']['id'])); ?>"> <?php echo $l['User']['name']; ?></a></td>
                    <td><?php echo $l['Liste']['created']; ?>&nbsp;</td>
                    <td class="actions">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="ki-duotone ki-setting-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>&nbsp;<span class=""></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">

                                <?php echo '<li>' . $this->Html->link(__('Désarchiver'), array('action' => 'archive', $l['Liste']['id'], 1)) . '</li>'; ?>
                            </ul>
                        </div>
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
    $(function() {
        $("#example1").DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false
        });
    });
</script>

<?php echo $this->element('assets/datatables'); ?>
<?php
echo $this->Html->css('btn-style');
echo $this->Html->css('daterangepicker');
$objectif = 0;
$clientappel = $prospectappel = $pencours = $cencours = 0;
foreach ($clientfeuilles as $prospectfeuille) {
    if ($prospectfeuille['Prospectfeuille']['etat'] == "En cours") {
        if ($prospectfeuille['Client']['type_pharmacie'] == "Client")
            $cencours++;
        else
            $pencours++;
    }
    if ($prospectfeuille['Prospectfeuille']['etat'] == "Terminer" || $prospectfeuille['Prospectfeuille']['etat'] == "A traiter") {
        if ($prospectfeuille['Client']['type_pharmacie'] == "Client")
            $clientappel++;
        else
            $prospectappel++;
    }
    $objectif = $prospectfeuille['Prospectcompagne']['objectif'];
}
$porcentage = 0;
if ($objectif != 0)
    $porcentage = round((($clientappel + $prospectappel) / $objectif * 100), 0);
?>	

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style type="text/css">
    input[type=text] {
        border-radius: 0px;
    }
    .fa-clock-o {
        position: relative;
        left: -11px;
        top: 9px;
        color: white;
        cursor: pointer;
        float: left;
    }
    .calendar{
        border-radius: 0px;
        padding: 6px 16px;
        margin-right: -12px;
        float: left;
    }
    a {
        color: #0083d0;
        cursor: pointer;
    }

    /* ===== Design system restyle (fdr) — Metronic-style compact cards ===== */
    .fdr-wrapper{
        font-family:'Poppins',sans-serif;
        color:#3a3a4a;
    }

    .fdr-stats-row{
        display:flex;
        gap:16px;
        flex-wrap:wrap;
        align-items:stretch;
        margin-bottom:24px;
    }
    .fdr-stats-row .col-md-4{
        flex:1 1 0;
        width:auto;
        min-width:230px;
        padding:0;
        float:none;
        display:flex;
    }

    /* Metronic-like KPI card: white bg, small icon symbol, compact height */
    .fdr-wrapper .info-box{
        position:relative;
        width:100%;
        background:#fff !important;
        border-radius:10px !important;
        box-shadow:0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04) !important;
        border:1px solid #eef0f6 !important;
        overflow:hidden !important;
        min-height:96px;
        height:auto;
        display:flex !important;
        align-items:center;
        gap:14px;
        padding:16px 18px;
        z-index:1;
        box-sizing:border-box;
    }
    .fdr-wrapper .info-box > *{
        position:relative;
        z-index:2;
    }
    /* neutralize any theme "ribbon"/banner decoration that may be injected into info-box variants */
    .fdr-wrapper .info-box:before,
    .fdr-wrapper .info-box:after,
    .fdr-wrapper .info-box .ribbon,
    .fdr-wrapper .info-box [class*="ribbon"]{
        display:none !important;
    }

    .fdr-wrapper .info-box-icon{
        height:46px !important;
        width:46px !important;
        min-width:46px;
        border-radius:10px !important;
        display:flex !important;
        align-items:center;
        justify-content:center;
        background:transparent !important;
    }
    .fdr-wrapper .info-box-icon i{
        font-size:20px !important;
        color:inherit !important;
    }

    .fdr-wrapper .info-box.bg-primary .info-box-icon{ background:#e8f6fb !important; color:#3ab7de !important; }
    .fdr-wrapper .info-box.bg-warning .info-box-icon{ background:#fdf5e2 !important; color:#e0ab1f !important; }
    .fdr-wrapper .info-box.bg-success .info-box-icon{ background:#e6f9ef !important; color:#2fb374 !important; }

    .fdr-wrapper .info-box.bg-primary,
    .fdr-wrapper .info-box.bg-warning,
    .fdr-wrapper .info-box.bg-success{
        background:#fff !important;
    }

    .fdr-wrapper .info-box-content{
        display:flex;
        flex-direction:column;
        justify-content:center;
        flex:1;
        padding:0;
        min-width:0;
    }
    .fdr-wrapper .info-box-text{
        font-size:11.5px;
        font-weight:700;
        letter-spacing:.4px;
        text-transform:uppercase;
        color:#9a9ab5;
        opacity:1;
        margin-bottom:2px;
    }
    .fdr-wrapper .info-box-number{
        font-size:18px;
        font-weight:700;
        color:#2b2b45;
        display:block;
        margin-top:0;
        line-height:1.2;
    }

    .fdr-wrapper .progress{
        background:#eef0f6;
        height:5px;
        margin:8px 0 4px 0;
        border-radius:6px;
    }
    .fdr-wrapper .progress .bar_total{
        background:#2fb374;
        border-radius:6px;
    }
    .fdr-wrapper .progress-description{
        font-size:11.5px;
        color:#9a9ab5;
        opacity:1;
    }

    .fdr-wrapper .card{
        background:#fff !important;
        border:none !important;
        border-radius:18px !important;
        box-shadow:0 4px 20px rgba(108,99,245,0.07) !important;
        overflow:hidden;
    }
    .fdr-wrapper .card-header.table-responsive{
        border:none !important;
        display:flex;
        align-items:center;
        gap:12px;
        padding:20px 24px 14px 24px;
    }
    .fdr-wrapper .card-header.table-responsive:before{
        content:'';
        width:7px;
        height:22px;
        min-width:7px;
        border-radius:4px;
        background:linear-gradient(180deg,#6C63F5,#8c7ef2);
    }
    .fdr-wrapper .card-title{
        font-size:16px;
        font-weight:600;
        color:#2d2b45;
        margin:0;
    }
    .fdr-wrapper .card-body{
        padding:20px 24px 24px 24px;
    }
    .fdr-wrapper table.dataTable thead th{
        background:#faf9ff !important;
        color:#4a4863 !important;
        font-weight:600 !important;
        border-bottom:2px solid #ece9fb !important;
    }
    .fdr-wrapper table.dataTable tbody td{
        font-size:13.5px;
        color:#454358;
        vertical-align:middle;
    }
    .fdr-wrapper table.table-striped tbody tr:nth-child(odd){
        background:#fbfaff;
    }
    .fdr-wrapper table.dataTable tbody tr[style*="36f4a1"]{
        background-color:#e3f9ee !important;
    }
    .fdr-wrapper table.dataTable tbody tr[style*="f7c5c6"]{
        background-color:#fdecec !important;
    }
    .fdr-wrapper .btn.btn-outline-info{
        border-radius:999px !important;
        border:1.5px solid #d8d3fb !important;
        color:#6C63F5 !important;
        background:transparent !important;
        font-weight:600;
        font-size:13px;
        padding:6px 16px !important;
    }
    .fdr-wrapper .btn.btn-outline-info:hover{
        background:#f1effe !important;
    }
    .fdr-wrapper .dataTables_filter input{
        border-radius:999px !important;
        border:1.5px solid #e7e5f7 !important;
        padding:6px 14px !important;
        font-size:13px;
    }
</style>	


<div class="fdr-wrapper">
<div class="row">
    <div class="col-md-12">
        <!-- /.info-box -->
        <div class="fdr-stats-row">
        <div class="col-md-4">
            <div class="info-box bg-primary">
                <span class="info-box-icon"><i class="ki-duotone ki-messages"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Prospect</span>
                    <span class="info-box-number"><?php echo $prospectappel; ?> Appel</span>

                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <!-- Info Boxes Style 2 -->
        <div class="col-md-4">
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="ki-duotone ki-people"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Clients</span>
                    <span class="info-box-number"><?php echo $clientappel; ?> Appel</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div> 

        <!-- /.info-box -->
        <div class="col-md-4">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="ki-duotone ki-calculator"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total</span>
                    <span class="info-box-number"><?php echo $prospectappel + $clientappel . "/" . $objectif; ?> Appel/jour</span>

                    <div class="progress">
                        <div class="progress-bar bar_total" style="width:<?php echo $porcentage; ?>%;" ></div>
                    </div>
                    <span class="progress-description">vous êtes à <?php echo $porcentage; ?>% de la journée</span>

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        </div>

    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header table-responsive">
                <h3 class="card-title">Feuille de route</h3>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
                    <thead>
                        <tr>
                            <th>Société</th>
                            <th>Secteur</th>
                            <th>Campagne</th>
                            <th>Type client</th>
                            <th>État</th>
                            <th>Date d'appel</th>
                            <th class="actions">#</th>
                        </tr>
                    </thead>
                    <?php foreach ($clientfeuilles as $prospectfeuille):  ?>
                        <tr
                        <?php
                        if ($prospectfeuille['Prospectfeuille']['etat'] == "Terminer" || $prospectfeuille['Prospectfeuille']['etat'] == "A traiter")
                            echo 'style="background-color: #36f4a1c4;"';
                        if ($prospectfeuille['Prospectfeuille']['etat'] == "Annuler")
                            echo 'style="background-color: #f7c5c6c4;"';
                        ?> >
                            <td><?php echo $this->Html->link($prospectfeuille['Client']['nom'], array('controller' => 'clients', 'action' => 'view', $prospectfeuille['Client']['id'])); ?></td>
							<td><?php echo $secteurs[$prospectfeuille['Client']['secteur_id']]; ?>&nbsp;</td>
                            <td><?php echo $this->Html->link($prospectfeuille['Prospectcompagne']['name'], array('controller' => 'prospectcompagnes', 'action' => 'view', $prospectfeuille['Prospectcompagne']['id'])); ?></td>
                            <td><?php echo $prospectfeuille['Client']['type_pharmacie']; ?>&nbsp;</td>
                            <td><?php echo $prospectfeuille['Prospectfeuille']['etat']; ?>&nbsp;</td>
                            
                            <td><?php 
							if(!empty($prospectfeuille['Rapportprocpect']))
								echo $prospectfeuille['Rapportprocpect']['created']; ?>&nbsp;</td>
                            <td class="actions">
                                <?php 
                                if ($prospectfeuille['Prospectfeuille']['rappel'] != null) {
                                    $dat = explode(" ", $prospectfeuille['Prospectfeuille']['rappel']);
                                    $date = explode("-", $dat[0]);
                                    $heure = explode(":", $dat[1]);
                                    echo "A appeler le $date[2]/$date[1]/$date[0] à $heure[0]:$heure[1]";
                                }
                                if ($this->requestAction('/droits/getrole/rapportprocpects/ajouter') == 1) {
                                    if (!in_array($prospectfeuille['Prospectfeuille']['etat'], ["Terminer", "Annuler","A traiter"]))
                                        echo $this->Html->link(" Appeler", array('action' => 'ajouter', $prospectfeuille['Client']['id'], $prospectfeuille['Prospectcompagne']['id'], $prospectfeuille['Prospectfeuille']['id']), array('class' => 'ion-android-call btn-in btn btn-outline-info'));
                                    else
                                        echo $prospectfeuille['Prospectfeuille']['motif'];
                                }
                                ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php
echo $this->Html->script('jquery.slimscroll.min');
echo $this->Html->script('fastclick');
echo $this->Html->script('demo');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<?php
echo $this->Html->script('daterangepicker');
?>
<script>
    var date = "";
    $(function () {
        $('#reservationtime').daterangepicker({format: 'MM/DD/YYYY',
            locale: {
                "format": "YYYY-MM-DD",
                "separator": "--",
                "applyLabel": "Valider",
                "cancelLabel": "Annuler",
                "fromLabel": "De",
                "toLabel": "à",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Dim",
                    "Lun",
                    "Mar",
                    "Mer",
                    "Jeu",
                    "Ven",
                    "Sam"
                ],
                "monthNames": [
                    "Janvier",
                    "Février",
                    "Mars",
                    "Avril",
                    "Mai",
                    "Juin",
                    "Juillet",
                    "Août",
                    "Septembre",
                    "Octobre",
                    "Novembre",
                    "Décembre"
                ],
                "firstDay": 1
            },
            clickApply: function (e) {
                this.updateInputText();
            }
        });
        $('#reservationtime').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            var endDate = picker.endDate;
            date = startDate + "--" + endDate;
        });
    });
</script>

<script>
    $(function () {
        $('#example1').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": true,
            "bSort": false,
            "iDisplayLength": 250,
            "aaSorting": [],
            dom: 'Bfrtip'
                    //,
                    //buttons: [
                    //'excel'
                    //]
        });
    });
</script>

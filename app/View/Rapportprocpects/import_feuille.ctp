<style>
    #import-feuille-route{
        --accent:#9b90e0;
        --accent-dark:#7e71cf;
        --accent-light:#f4f2fc;
        --accent-pale:#ece7fb;
        --border-color:#ece9f9;
        --text-dark:#2d2b42;
        --text-muted:#8b87a3;
        --radius-lg:16px;
        --radius-md:12px;
        --radius-sm:8px;
        --shadow-card:0 2px 14px rgba(108,92,231,0.06);
    }

    /* Everything below is scoped under #import-feuille-route (an ID) so it
       reliably out-specifies the theme's existing skin/panel CSS, which is
       often written as ".skin-blue .card { ... !important }" and
       can otherwise beat plain class selectors even when we also use !important. */

    #import-feuille-route .card{
        background:#fff !important; border:1px solid var(--border-color) !important;
        border-radius:var(--radius-lg) !important; box-shadow:var(--shadow-card) !important; overflow:hidden !important;
    }
    #import-feuille-route .card > .card-header{
        background:var(--accent-light) !important; border-bottom:1px solid var(--border-color) !important;
        padding:16px 24px !important; display:flex !important; align-items:center !important;
    }
    #import-feuille-route .card > .card-header .card-title{
        color:var(--text-dark) !important; font-size:16px !important; font-weight:700 !important;
        display:flex !important; align-items:center !important;
    }
    #import-feuille-route .card > .card-header .card-title:before{
        content:"\f0ee"; font-family:"FontAwesome"; display:inline-flex; align-items:center; justify-content:center;
        width:32px; height:32px; border-radius:50%; margin-right:10px; font-size:14px;
        background:#fff; color:var(--accent-dark); flex:0 0 auto;
    }
    #import-feuille-route .card > .card-body{ padding:24px !important; }

    /* Inner panel (upload card) */
    #import-feuille-route .col-lg-6 .card{
        box-shadow:none !important; border:1px dashed var(--accent-pale) !important;
    }
    #import-feuille-route .col-lg-6 .card .card-body{ padding:22px !important; }

    #import-feuille-route .payment-form input[type="file"]{
        border:1px solid var(--border-color) !important; border-radius:var(--radius-sm) !important;
        background:#fafafa !important; padding:10px 12px !important; font-size:14px !important;
        color:var(--text-dark) !important; width:100% !important; box-shadow:none !important;
    }
    #import-feuille-route .payment-form input[type="file"]:focus{
        border-color:var(--accent) !important; background:#fff !important; outline:none !important;
    }

    #import-feuille-route .payment-form .card.text-center{
        background:transparent !important; border:none !important; box-shadow:none !important;
        padding:18px 0 0 0 !important;
    }
    #import-feuille-route .payment-form input[type="submit"].btn-primary{
        -webkit-appearance:none !important; appearance:none !important;
        background:var(--accent) !important; border:none !important; border-radius:var(--radius-sm) !important;
        color:#fff !important; padding:11px 26px !important; font-weight:600 !important; font-size:14px !important;
        box-shadow:0 3px 10px rgba(108,92,231,0.25) !important; cursor:pointer !important;
    }
    #import-feuille-route .payment-form input[type="submit"].btn-primary:before{
        font-family:"FontAwesome"; content:"\f093"; margin-right:8px;
    }
    #import-feuille-route .payment-form input[type="submit"].btn-primary:hover{
        background:var(--accent-dark) !important;
    }
</style>

<div id="import-feuille-route">
<div class="card">
    <div class="card-header">
        <h3 class="card-title" style="padding-left: 0px;margin-left: -7px;">Importer un fichier exel (Feuille de route)</h3>
    </div>
    <div class="card-body">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body payment-form">
                    <?php echo $this->Form->create('Prospectfeuille', array('type' => 'file')); ?>
                    <?php
					
                    echo $this->Form->file('file', array('class' => 'form-control'));
                    ?>
                    <?php echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary btn-large', 'div' => array('class' => 'well text-center col-md-12'))); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

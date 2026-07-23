<style type="text/css">
    #edit-affaire-wrapper {
        --accent: #00a7d0;
        --accent-dark: #008da0;
        --border-color: #ece9f9;
        --text-dark: #2d2b42;
        --text-muted: #8b87a3;
        --radius-lg: 16px;
        --radius-md: 12px;
        --radius-sm: 8px;
        --shadow-card: 0 2px 14px rgba(0, 167, 208, 0.06);
    }

    /* Modern Rounded Layout Card */
    #edit-affaire-wrapper .card {
        background: #fff !important;
        border: 1px solid var(--border-color) !important;
        border-radius: var(--radius-lg) !important;
        box-shadow: var(--shadow-card) !important;
        overflow: hidden !important;
        margin-bottom: 24px !important;
    }

    /* Header Components Structural Realignment */
    #edit-affaire-wrapper .card-header {
        padding: 20px 24px !important;
        background: #fff !important;
        border-bottom: 1px solid var(--border-color) !important;
        width: 100% !important;
        float: none !important;
    }

    #edit-affaire-wrapper .card-title {
        font-size: 20px !important;
        font-weight: 800 !important;
        color: var(--text-dark) !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Workspace Content Formatting */
    #edit-affaire-wrapper .card-body {
        padding: 24px !important;
    }

    /* Nested Inner Blueprint Panels Stripping */
    #edit-affaire-wrapper .card-body .card {
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        margin: 0 !important;
    }
    #edit-affaire-wrapper .card-body .card-body {
        padding: 0 !important;
    }

    /* Clean Input Field Rows Structure Layout */
    #edit-affaire-wrapper .form-group {
        margin-bottom: 20px !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 6px !important;
    }

    #edit-affaire-wrapper .form-group label {
        font-size: 13px !important;
        font-weight: 700 !important;
        color: var(--text-dark) !important;
        text-transform: capitalize !important;
        margin: 0 !important;
    }

    /* Interactive UI Fields Architecture styling */
    #edit-affaire-wrapper .form-control {
        width: 100% !important;
        height: 44px !important;
        padding: 10px 16px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        color: var(--text-dark) !important;
        background-color: #fff !important;
        border: 1px solid var(--border-color) !important;
        border-radius: var(--radius-sm) !important;
        box-shadow: none !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
    }

    #edit-affaire-wrapper .form-control:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px rgba(0, 167, 208, 0.1) !important;
        outline: 0 !important;
    }

    /* Form Workspace Footer Architecture Elements */
    #edit-affaire-wrapper .card-footer {
        background: transparent !important;
        border-top: none !important;
        padding: 12px 0 0 0 !important;
    }

    #edit-affaire-wrapper .card.text-center {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        text-align: left !important;
    }

    /* Core Submission Call To Action Element button styling */
    #edit-affaire-wrapper .btn-outline-info,
    #edit-affaire-wrapper input[type="submit"] {
        background: var(--accent) !important;
        border: none !important;
        color: #fff !important;
        border-radius: var(--radius-sm) !important;
        padding: 12px 30px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        box-shadow: 0 4px 14px rgba(0, 167, 208, 0.25) !important;
        cursor: pointer !important;
        transition: background 0.2s ease !important;
    }

    #edit-affaire-wrapper .btn-outline-info:hover,
    #edit-affaire-wrapper input[type="submit"]:hover {
        background: var(--accent-dark) !important;
        color: #fff !important;
    }
</style>

<div id="edit-affaire-wrapper">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo __('Editer une affaire'); ?></h3>
        </div>
        <div class="card-body">
            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-body payment-form">
                        <?php echo $this->Form->create('Prospectaffaire'); ?>
                        <?php
                        // Keeps ID track cleanly mapped internally without creating an empty field row
                        echo $this->Form->input('id', array('type' => 'hidden'));
                        
                        echo $this->Form->input('name', array(
                            "label" => "Nom", 
                            'class' => 'form-control',
                            'div' => array('class' => 'mb-5')
                        ));
                        ?>
                    </div>
                    <div class="card-footer">
                        <?php echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-outline-info', 'div' => array('class' => 'card card-body bg-light text-center'))); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
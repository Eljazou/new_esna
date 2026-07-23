<?php
echo $this->Html->css("image-uploader.min"); 
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style type="text/css">
    :root {
        --primary-color: #7c6ff0;
        --primary-gradient: linear-gradient(135deg, #7c6ff0 0%, #6355e6 100%);
        --primary-soft: #f2efff;
        --card-border-radius: 16px;
        --text-dark: #1f2940;
        --text-muted: #94a3b8;
        --border-color: #e2e8f0;
    }

    body, .metronic-card, .form-control {
        font-family: 'Poppins', sans-serif !important;
    }

    /* Outer Wrapper */
    .metronic-form-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 20px 0;
    }

    /* Metronic Card Container */
    .metronic-card {
        background: #ffffff;
        border: none;
        border-radius: var(--card-border-radius);
        box-shadow: 0 4px 20px rgba(22, 32, 77, 0.04);
        width: 100%;
        max-width: 720px;
        overflow: hidden;
    }

    /* Card Header */
    .metronic-card-header {
        padding: 24px 28px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .hero-icon-box {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 12px;
        background: var(--primary-soft);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-icon-box svg {
        width: 22px;
        height: 22px;
        stroke: var(--primary-color);
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .hero-title-group h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.3;
    }

    .hero-title-group p {
        margin: 2px 0 0;
        font-size: 12.5px;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Card Body */
    .metronic-card-body {
        padding: 28px !important;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }

    .form-group-custom label {
        font-weight: 600;
        font-size: 13px;
        color: var(--text-dark);
        display: block;
        margin-bottom: 8px;
    }

    .form-group-custom .form-control {
        border: 1px solid var(--border-color) !important;
        border-radius: 10px !important;
        height: 44px !important;
        padding: 10px 16px !important;
        font-size: 14px !important;
        box-shadow: none !important;
        width: 100%;
        color: var(--text-dark);
        background-color: #f8fafc;
        transition: all 0.2s ease-in-out;
    }

    .form-group-custom .form-control:focus {
        background-color: #ffffff;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(124, 111, 240, 0.15) !important;
        outline: none;
    }

    input[type="file"].form-control {
        padding: 8px 12px !important;
        height: auto !important;
    }

    /* Metronic Image Uploader Overrides */
    .image-uploader {
        border: 2px dashed #dbe0e8 !important;
        border-radius: 12px !important;
        background: #f8fafc !important;
        transition: all 0.2s ease;
        padding: 12px !important;
    }

    .image-uploader:hover {
        border-color: var(--primary-color) !important;
        background: var(--primary-soft) !important;
    }

    .image-uploader .upload-text i {
        color: var(--primary-color) !important;
    }

    /* Submit Action Bar */
    .metronic-form-actions {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 20px 0 0 !important;
        margin-top: 16px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }

    .metronic-form-actions input[type="submit"] {
        background: var(--primary-gradient) !important;
        border: none !important;
        border-radius: 10px !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        padding: 11px 32px !important;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(124, 111, 240, 0.25);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .metronic-form-actions input[type="submit"]:hover {
        opacity: 0.95;
        box-shadow: 0 6px 16px rgba(124, 111, 240, 0.35);
        transform: translateY(-1px);
    }
</style>

<div class="metronic-form-wrapper">
    <div class="metronic-card">
        <!-- Header -->
        <div class="metronic-card-header">
            <div class="hero-icon-box">
                <svg viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="hero-title-group">
                <h3><?php echo __('Ajouter une brochure'); ?></h3>
                <p>Téléchargez vos documents et visuels associés</p>
            </div>
        </div>

        <!-- Body -->
        <div class="metronic-card-body">
            <?php echo $this->Form->create('Brochure', array('type' => 'file')); ?>

            <div class="form-group-custom">
                <?php echo $this->Form->input('category_id', array(
                    'label' => 'Catégorie', 
                    'class' => 'form-control',
                    'div' => false
                )); ?>
            </div>

            <div class="form-group-custom">
                <?php echo $this->Form->input('game_id', array(
                    'label' => 'Gamme', 
                    'class' => 'form-control',
                    'div' => false
                )); ?>
            </div>

            <div class="form-group-custom">
                <?php echo $this->Form->input('name', array(
                    'label' => 'Nom', 
                    'class' => 'form-control',
                    'div' => false
                )); ?>
            </div>

            <div class="form-group-custom">
                <label for="BrochureLogo">Logo</label>
                <?php echo $this->Form->file('logo', array('class' => 'form-control')); ?>
            </div>

            <!-- Image Uploader Component -->
            <div class="form-group-custom" style="margin-top: 24px;">
                <label>Images de brochure</label>
                <div class="input-images" style="width: 100%;"></div>
            </div>

            <!-- Submit -->
            <?php echo $this->Form->end(array(
                'label' => 'Ajouter', 
                'class' => 'btn btn-primary', 
                'div' => array('class' => 'metronic-form-actions')
            )); ?>
        </div>
    </div>
</div>

<script>
    function handlefiles(v) {   
        var photos = $(".input-images .uploaded-image").length;
        var dataurl = null;
        var vv = 'file' + v;
        var filesToUpload = document.getElementById(vv).files;

        if(parseInt(filesToUpload.length) > 4) {
            alert("Vous ne pouvez télécharger qu'un maximum de 4 fichiers");
            setTimeout(() => {
                $(".uploaded div").remove();
            }, 500);
        } else {
            var photos = $(".input-images .uploaded-image").length;
            var file = filesToUpload[0];

            var img = document.createElement("img");
            var reader = new FileReader();

            reader.onload = function (e) {
                img.src = e.target.result;

                img.onload = function () {
                    var canvas = document.createElement("canvas");
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0);

                    var MAX_WIDTH = 1200;
                    var MAX_HEIGHT = 840;
                    var width = img.width;
                    var height = img.height;

                    if (width > height) {
                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }
                    } else {
                        if (height > MAX_HEIGHT) {
                            width *= MAX_HEIGHT / height;
                            height = MAX_HEIGHT;
                        }
                    }
                    canvas.width = width;
                    canvas.height = height;
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, width, height);

                    dataurl = canvas.toDataURL("image/jpeg");
                    var input_hidden = $("<input>", { 
                        type: "hidden",
                        name: "data[Brochure][file][" + photos + "]",
                        multiple: "" 
                    }).appendTo($(".uploaded-image").attr("data-index", photos));

                    $($("input[name='data[Brochure][file][" + photos + "]'")).attr("value", dataurl);
                    var fd = new FormData();
                    fd.append("image", dataurl);
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>

<?php echo $this->Html->script("image-uploader.min"); ?>
<script>
    $(function () {
        $('div[class^="input-images"]').imageUploader();
    });
</script>
<div id="first_page">
    <div id="title_section">
        <h1><?= $main['name'] ?></h1>

        <div class="main_data">
            <?php if ($main['type_img_link']): ?>
            <img id="car_model_img" src="https://infocar.md<?= $main['type_img_link'] ?>" alt="">
            <?php endif ?>

            <?php foreach ($main['main_data'] as $title => $value): ?>
            <div><b><?= $title ?>:</b> <?= $value ?></div>
            <?php endforeach ?>
        </div>
    </div>
    <hr>

    <?php require 'registration.php' ?>
</div>

<style>
    #registration_data_table td {
        text-align: right;
    }

    #registration_data_table th {
        text-align: left;
    }

    #car_model_img {
        --width:  70px;
        float: left;
        width:  var(--width);
        margin-right: 20px;
    }
</style>
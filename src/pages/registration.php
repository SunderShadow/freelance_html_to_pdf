<?php /** @var \Tools\Parser\ReportParser $parser */?>
<div id="first_page">
    <div id="title_section">
        <h1><?= $parser->car_main_data->name?></h1>

        <div class="main_data">
            <img id="car_model_img" src="https://infocar.md<?= $parser->car_main_data->model_img_link ?>" alt="">
            <div><b>VIN:</b> <?= $parser->car_main_data->VIN ?></div>
            <div><b>Anul fabricației</b> <?= $parser->car_main_data->manufacture_year ?></div>
            <div><b>Num. înmatriculare</b> <?= $parser->car_main_data->state_number ?></div>
        </div>
    </div>
    <hr>

    <h2>Datele înmatriculare</h2>

    <table id="registration_data_table" class="colored_table">
        <tbody>
        <?php foreach ($parser->registration_data_storage as $key => $value): ?>
            <tr>
                <th><?= $key ?></th>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
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
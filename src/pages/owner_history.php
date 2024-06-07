<?php /** @var \Tools\Parser\ReportParser $parser */?>
<div class="page">
    <h2 id="owner_history_title">Istoric al schimbării proprietarilor</h2>
    <table id="owner_history_table" class="colored_table">
        <tbody>
        <?php foreach ($parser->owners_history as $key => $value): ?>
            <tr>
                <td><span class="history_number"><?= $key + 1 ?></span></td>
                <td><?= $value ?></td>
            </tr>
            <tr><hr class="vertical_ruler"></tr>
        <?php endforeach; ?>
        <tr>
            <td><span class="history_number"></span></td>
            <td>până în prezent</td>
        </tr>
        </tbody>
    </table>
</div>
<style>
    #owner_history_title {
        margin: 0;
    }

    #owner_history_table {
        margin-top: 1cm;

        border-spacing: 0;
        border-collapse: collapse;
    }

    .history_number {
        display: inline-block;

        border: 2px solid #000;
        border-radius: 100%;
        width: 5mm;
        height: 5mm;
        padding-left: 2mm;
        padding-bottom: 2mm;
        box-sizing: border-box;
    }

    .vertical_ruler {
        display: inline-block;
        position: relative;
        top: -1px;

        left: 3.8mm;
        width: 2px;
        height: 12mm;

        padding: 0;
        margin: 0;

        background: black;
    }
</style>
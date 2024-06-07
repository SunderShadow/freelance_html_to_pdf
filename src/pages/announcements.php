<?php /** @var \Tools\Parser\ReportParser $parser */?>

<div class="page">
    <h2>Anunțuri</h2>
    <?php $announcement = $parser->announcements[0] ?>
    <?php foreach ($parser->announcements as $announcement): ?>
        <h3><?= $announcement->title ?></h3>
        <span><?= $announcement->date ?></span>
        <table class="announcements_img_table">
            <?php foreach (array_chunk($announcement->images, 3) as $chunk): ?>
            <tr>
                <?php foreach ($chunk as $img_link): ?>
                    <td><img src="<?= $parser->host_url . $img_link?>" alt=""></td>
                <?php endforeach ?>
            </tr>
            <?php endforeach ?>
        </table>

        <table class="announcement_props_table colored_table">
            <?php foreach ($announcement->properties as $title => $value): ?>
                <tr>
                    <th><?= $title ?></th>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach?>
        </table>
        <?php if ($announcement->comment !== ''): ?>
            <h4>Comment:</h4>
            <div class="announcement_comment">
                <?= $announcement->comment ?>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</div>

<style>
    .announcements_img_table {
        --img-per-row: 3;
    }

    .announcements_img_table img {
        --img-per-row: 3;
        width: calc(var(--page-width) / var(--img-per-row) - 5px);
    }

    .announcement_props_table th {
        text-align: left;
    }

    .announcement_comment {
        background-color: #eaeaea;
        padding: .5rem 1rem;
    }
</style>
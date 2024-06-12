<?php if ($insurance_history['history']): ?>
<div class="page">
    <h2><?= $insurance_history['title'] ?></h2>
        <?php foreach ($insurance_history['history'] as $i => $history_item): ?>
            <div class="insurance_history">
                <span class="insurance_history_index"><?= $i ?></span>
                <?php foreach ($history_item as $title => $value): ?>
                    <div class="insurance_info">
                        <div><b><?= $title ?></b></div>
                        <div><?= $value ?></div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endforeach ?>
</div>

<style>
    .insurance_history {
        position: relative;
        border: 1px solid #000;
        padding: 30px;
        box-sizing: border-box;
    }

    .insurance_history + .insurance_history {
        margin-top: 1rem;
    }

    .insurance_info + .insurance_info {
        margin-top: 1cm;
    }

    .insurance_history_index {
        position: absolute;
        right: 20px;
        top: 20px;
    }
</style>
<?php endif ?>
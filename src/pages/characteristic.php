<?php
$side_width_ruler_svg = base64_encode(
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 398 7" class="IconSvg IconSvg_name_SvgArrowHorisontalLong IconSvg_size_24 VinReportTechInfo__arrowHorizontalIcon"><path fill="#000" fill-rule="evenodd" d="M387.626 7 398 3.538 387.626 0v3H10.374V0L0 3.462 10.374 7V4h377.252z" clip-rule="evenodd" opacity="0.24"></path></svg>'
);
$front_width_ruler_svg = base64_encode(
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 184 7" class="IconSvg IconSvg_name_SvgArrowHorisontalShort IconSvg_size_24 VinReportTechInfo__arrowHorizontalIcon"><path fill="#000" fill-rule="evenodd" d="M173.627 7 184 3.538 173.627 0v3H10.373V0L0 3.462 10.373 7V4h163.254z" clip-rule="evenodd" opacity="0.23"></path></svg>'
);
$height_ruler_svg = base64_encode(
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 129" class="IconSvg IconSvg_name_SvgArrowVertical IconSvg_size_24 VinReportTechInfo__bodyHeightArrow"><path fill="#000" fill-rule="evenodd" d="M7.016 8.905 3.611 0 0 8.905h3.007v111H0l3.531 8.893 3.485-8.893H4.009v-111z" clip-rule="evenodd" opacity="0.24"></path></svg>'
);
?>
<div class="page">
    <h2><?= $characteristics['title'] ?></h2>
    <?php if (isset($characteristics['side']) && isset($characteristics['front'])): ?>
    <table class="car_tech_info_table">
        <tr>
            <td>
                <img id="side_img" class="cart_tech_info_img" src="https://infocar.md<?= $characteristics['side']['img']  ?>" alt="">
                <img id="side_ruler_height" class="cart_tech_info_ruler_height" src="data:image/svg+xml;base64,<?= $height_ruler_svg ?>" alt="">
                <img id="side_ruler_width" class="cart_tech_info_ruler_width" src="data:image/svg+xml;base64,<?= $side_width_ruler_svg ?>" alt="">

                <span id="side_width" class="cart_tech_info_width">
                    <?= $characteristics['side']['width'] ?>
                </span>

                <span id="side_height" class="cart_tech_info_height">
                    <?= $characteristics['side']['height'] ?>
                </span>
            </td>
            <td>
                <img id="front_img" class="cart_tech_info_img front_img" src="https://infocar.md<?= $characteristics['front']['img'] ?>" alt="">
                <img class="cart_tech_info_ruler_width" src="data:image/svg+xml;base64,<?= $front_width_ruler_svg ?>" alt="">

                <span id="front_width" class="cart_tech_info_width">
                    <?= $characteristics['front']['width'] ?>
                </span>
            </td>
        </tr>
    </table>
    <?php endif ?>
    <?php if ($characteristics['properties']): ?>
    <table id="characteristic_table" class="colored_table">
        <?php foreach ($characteristics['properties'] as $title => $value): ?>
            <tr>
                <th><?= $title ?></th>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach ?>
    </table>
    <?php endif ?>
</div>
<style>
    #side_img, #front_img {
        height: 45mm;
    }

    #side_img {
        display: inline;
        width: 12cm;
        transform: translate(-5mm, 7mm);
    }

    #side_ruler_height {
        position: relative;
        height: 45mm;

        transform: translate(-5mm, 7mm);
    }

    #side_height {
        position: relative;
        left: 113mm;
        bottom: 32mm;
        background: #fff;
    }

    #side_width {
        position: relative;
        left: -61mm;
        bottom: 0;
        background: #fff;
    }

    #front_img {
        width: 60mm;
        transform: translate(-5mm, -5mm);
    }

    #front_width {
        position: relative;
        bottom: 0;
        right: 32mm;
        background-color: #fff;
    }

    .car_tech_info_table td {
        position: relative;
    }


    .cart_tech_info_height {
        position: relative;
        bottom: 28mm;
        left: 50mm;
    }

    #characteristic_table th {
        text-align: left;
    }

    #characteristic_table td {
        text-align: right;
    }
</style>
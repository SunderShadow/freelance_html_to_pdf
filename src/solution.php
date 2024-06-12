<?php
require __DIR__ . "/../vendor/autoload.php";

$parser = new \Tools\Parser\ParserAccumulator();

ini_set('memory_limit', -1);

const HOST_NAME = "https://infocar.md/report/";

const LINKS = [
    "e0fae1971821c8d630e71e3fa9bffbb6",
    "af2fac78cd5687a99df003e51d6f9fe8",
    "cf4743dbd10131c5850478e44686a2b8",
    "c94a9e6c3bed9a602740ad39d9a19fe4",
    "c94a9e6c3bed9a602740ad39d9a19fe4",
    "67cd167eee437ac777ec0441a11e81a5",
    "74669b44f6c689f1f905201fd3bd03d9",
    "3be9035a46759e317275863de09444b7",
    "7adf7a8d8c387aec401088377ed30af9",
    "1288220503a99dd93a01365452f3d281",
    "2bf0f28b9f164362a4801c895237e1d0",
    "60d17a34a2fa9eb2a8a774fae232e848",
    "d75e33229c0358560d32526f1f2d03a4",
    "8d28ea0d139b94603fc438d3894be667"
];

$converter = new \Tools\Converter();

foreach (LINKS as $link) {
    $converter = new \Tools\Converter();
    $start = time();
    echo $link, PHP_EOL;
    $converter->loadHtmlFile(HOST_NAME . $link);
    $converter->convertToPDF();
    $converter->savePDF(__DIR__ . '/pdf/' . $link . '.pdf');

    echo "Time = ", (time() - $start), PHP_EOL;
    unset($converter);
}


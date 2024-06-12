<?php
require_once('vendor/autoload.php');
$converter = new \Tools\Converter();
$converter->loadHtmlFile($_GET['url']);
$converter->convertToPDF();
header("Content-type:application/pdf");
echo $converter->getPDF();

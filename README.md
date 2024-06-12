```php
$converter = new \Tools\Converter();
$converter->loadHtmlFile('https://infocar.md/report/f1a45f1c1faf727ad4e6d6bb430b12ad');
$converter->convertToPDF();
$converter->savePDF('tmp.pdf');
```
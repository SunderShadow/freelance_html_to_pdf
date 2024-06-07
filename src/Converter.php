<?php

namespace Tools;

use Dompdf\Dompdf;
use Dompdf\Options;
use Tools\Parser\ReportParser;

class Converter
{
    protected string $templateFilepath = __DIR__ . '/pages/index.php';

    protected ReportParser $parser;

    protected string $convertedPDF;

    public function __construct()
    {
        $this->parser = new \Tools\Parser\ReportParser();
    }


    /**
     * @throws \Exception
     */
    public function loadHtmlFile(string $filepath)
    {
        $this->parser->parseDocument($filepath);
    }

    public function convert()
    {
        $parser = $this->parser;
        $html = (function ($parser) {
            ob_start();
            require 'pages/index.php';
            return ob_get_clean();
        })($parser);

        $options = new Options();
        $options->set('enable_remote', true);

        $pdf = new Dompdf($options);

        $pdf->loadHtml($html);
        $pdf->setPaper('A4');
        $pdf->render();

        ob_start();
        $pdf->stream();
        $this->convertedPDF = ob_get_clean();
    }

    public function getPDF(): string
    {
        return $this->convertedPDF;
    }

    public function savePDF(string $filepath)
    {
        $f_stream = fopen($filepath, 'w');
        fwrite($f_stream, $this->getPDF());
        fclose($f_stream);
    }

    public function setTemplateFilepath(string $filepath)
    {
        $this->templateFilepath = $filepath;
    }
}
<?php

namespace Tools;

use Dompdf\Dompdf;
use Dompdf\Options;

class Converter
{
    protected Dompdf $dompdf;

    protected View $view;

    protected Parser $parser;

    public function __construct()
    {
        $this->parser = new Parser();
        $this->view   = new View();
        $this->setupDomPDF();
    }

    protected function setupDomPDF()
    {
        $options = new Options();
        $options->set('enable_remote', true);

        $this->dompdf = new Dompdf($options);
        $this->dompdf->setPaper('A4');
    }

    public function loadHtmlFile(string $filepath)
    {
        $this->parser->parseFile($filepath);
    }

    public function convertToPDF()
    {
        $data = $this->parser->getData();
        $html = $this->view->viewWithoutRender('index', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->render();
    }

    public function getPDF(): string
    {
        return $this->dompdf->output();
    }

    public function savePDF(string $filepath)
    {
        $f_stream = fopen($filepath, 'w');
        fwrite($f_stream, $this->getPDF());
        fclose($f_stream);
    }
}
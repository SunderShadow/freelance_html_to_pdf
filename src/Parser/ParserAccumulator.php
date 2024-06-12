<?php

namespace Tools\Parser;

use DOMDocument;
use DOMXPath;

class ParserAccumulator implements ParserAccumulatorInterface
{
    /** @var ParserInterface[] */
    protected array $parsers = [];

    protected array $data = [];

    public function register(array $parsers): void
    {
        $this->parsers = $parsers;
    }

    public function parse(DOMDocument $dom): void
    {
        $XPath = new DOMXPath($dom);

        foreach ($this->parsers as $key => $parser)
        {
            $this->data[$key] = $parser->parse($XPath);;
        }
    }

    public function parseFile(string $filePath): void
    {
        $domDocument = new DOMDocument();
        $domDocument->loadHTMLFile($filePath, LIBXML_NOWARNING | LIBXML_NOERROR);

        $this->parse($domDocument);
    }

    public function getData(): array
    {
        return $this->data;
    }
}
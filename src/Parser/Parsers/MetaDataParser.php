<?php

namespace Tools\Parser\Parsers;

use DOMXPath;
use Tools\Parser\ParserInterface;

class MetaDataParser implements ParserInterface
{
    public function parse(DOMXPath $XPath): array
    {
        $elements = $XPath->query('/html/body/main/div');

        $reportDate     = explode(':', $elements[1]->textContent);
        $validUntilDate = explode(':', $elements[2]->textContent);

        return [
            trim($reportDate[0]) => trim($reportDate[1]),
            trim($validUntilDate[0]) => trim($validUntilDate[1])
        ];
    }
}
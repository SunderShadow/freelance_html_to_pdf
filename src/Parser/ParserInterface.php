<?php

namespace Tools\Parser;

use DOMXPath;

interface ParserInterface
{
    /**
     * Parse code part and get array
     * @param DOMXPath $XPath
     * @return array
     */
    public function parse(DOMXPath $XPath): array;
}
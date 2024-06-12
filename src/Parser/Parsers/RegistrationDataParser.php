<?php

namespace Tools\Parser\Parsers;

use DOMNode;
use DOMXPath;
use Tools\Parser\ParserInterface;

class RegistrationDataParser implements ParserInterface
{
    public function parse(DOMXPath $XPath): array
    {
        $titleNode = $XPath->query('/html/body/section/h2[1]')[0];
        $propsNode = $titleNode->nextSibling->nextSibling;

        return [
            'title' => $titleNode->textContent,
            'props' => $this->parseProps($propsNode)
        ];
    }

    protected function parseProps(DOMNode $propsNode): array
    {
        $data = [];

        foreach ($propsNode->childNodes as $node) {
            if ($node->nodeName === '#text') {
                continue;
            }

            $titleNode = $node->firstChild;
            $valueNode = $titleNode->nextSibling;

            $data[$titleNode->textContent] = $valueNode->textContent;
        }

        return $data;
    }
}
<?php

namespace Tools\Parser\Parsers;

use DOMNode;
use DOMXPath;
use Tools\Parser\ParserInterface;

class MainDataParser implements ParserInterface
{
    public function parse(DOMXPath $XPath): array
    {
        $titleNode    = $XPath->query('/html/body/section/h1[1]')[0];

        $carTypeNode  = $titleNode->nextSibling->nextSibling;

        if ($carTypeNode->nodeName !== 'img') {
            $carTypeNode = $titleNode;
        }

        $divMainData  = $carTypeNode->nextSibling->nextSibling;
        $modelImgNode = $divMainData->nextSibling->nextSibling->nextSibling->nextSibling;

        return [
            'name'           => $titleNode->textContent,
            'type_img_link'  => $carTypeNode->nodeName === 'img' ? $carTypeNode->attributes[1]->textContent : null,
            'main_data'      => $this->parseMainData($divMainData),
            'model_img_link' => $this->getModelImg($modelImgNode)
        ];
    }

    private function parseMainData(DOMNode $div): array
    {
        $data = [];

        $node = $div->firstChild;
        for ($i = intdiv($div->childNodes->count(), 3); $i > 0; $i--)
        {
            $node  = $node->nextSibling;
            $key   = trim($node->textContent);
            $node  = $node->nextSibling;
            $value = trim(substr($node->textContent, 2));
            $node  = $node->nextSibling ? $node->nextSibling->nextSibling : $node->nextSibling;

            $data[$key] = $value;
        }

        return $data;
    }

    private function getModelImg(DOMNode $potentialImgNode)
    {
        $modelImg = null;
        if ($potentialImgNode->nodeName === 'img') {
            $modelImg = $potentialImgNode->attributes[1]->textContent;
        }

        return $modelImg;
    }
}
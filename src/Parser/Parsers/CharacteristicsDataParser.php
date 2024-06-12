<?php

namespace Tools\Parser\Parsers;

use DOMNode;
use DOMXPath;
use Tools\Parser\ParserInterface;

class CharacteristicsDataParser implements ParserInterface
{
    public function parse(DOMXPath $XPath): array
    {
        $titleNode      = $XPath->query('/html/body/section/h2[5]')[0];
        $propertiesNode = $titleNode->nextSibling->nextSibling->nextSibling->nextSibling;

        return [
            'title'      => $titleNode->textContent,
            ...$this->getImages($XPath),
            'properties' => $this->getProperties($propertiesNode)
        ];
    }

    protected function getImages(DOMXPath $XPath): array
    {
        if (!$XPath->query('/html/body/section/section[contains(@class, "VinReportTechInfo")]')[0]) {
            return [];
        }

        $sideImgNode    = $XPath->query('/html/body/section/section[contains(@class, "VinReportTechInfo")]/div/div/descendant::img[contains(@class, "VinReportTechInfo__bodySideImage")]')[0];
        $sideHeightNode = $XPath->query('/html/body/section/section[contains(@class, "VinReportTechInfo")]/div/div/descendant::div[contains(@class, "VinReportTechInfo__bodyHeightValue")]')[0];
        $sideWidthNode  = $XPath->query('/html/body/section/section[contains(@class, "VinReportTechInfo")]/div/div/descendant::div[contains(@class, "VinReportTechInfo__bodySize")]')[0];

        $frontImgNode    = $XPath->query('/html/body/section/section[contains(@class, "VinReportTechInfo")]/div/div/descendant::img[contains(@class, "VinReportTechInfo__bodyFrontImage")]')[0];
        $frontHeightNode = $XPath->query('/html/body/section/section[contains(@class, "VinReportTechInfo")]/div/div/descendant::div[contains(@class, "VinReportTechInfo__bodyClearanceValue")]')[0];
        $frontWidthNode  = $XPath->query('/html/body/section/section[contains(@class, "VinReportTechInfo")]/div/div/descendant::div[contains(@class, "VinReportTechInfo__bodySize")]')[1];

        return [
            'side' => [
                'img'    => $sideImgNode->attributes[1]->textContent,
                'height' => trim($sideHeightNode->textContent),
                'width'  => trim($sideWidthNode->textContent)
            ],
            'front' => [
                'img'    => $frontImgNode->attributes[1]->textContent,
                'height' => trim($frontHeightNode->textContent),
                'width'  => trim($frontWidthNode->textContent)
            ]
        ];
    }

    protected function getProperties(DOMNode $propertiesNode): array
    {
        $data = [];

        foreach ($propertiesNode->childNodes as $node)
        {
            if ($node->nodeName === '#text') {
                continue;
            }

            $data[trim($node->firstChild->textContent)] = trim($node->firstChild->nextSibling->textContent);
        }

        return $data;
    }
}
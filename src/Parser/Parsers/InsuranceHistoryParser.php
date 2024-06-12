<?php

namespace Tools\Parser\Parsers;

use DOMNodeList;
use DOMXPath;
use Tools\Parser\ParserInterface;

class InsuranceHistoryParser implements ParserInterface
{
    public function parse(DOMXPath $XPath): array
    {
        $titleNode    = $XPath->query('/html/body/section/h2[4]')[0];
        $historyNodes = $XPath->query('/html/body/section/h2[4]/following-sibling::div[following-sibling::h2]/ul[@class="prop"]');

        return [
            'title'   => $titleNode->textContent,
            'history' => $this->getInsuranceNodes($historyNodes)
        ];
    }


    protected function getInsuranceNodes(DOMNodeList $historyNodes): array
    {
        $data = [];
        foreach ($historyNodes as $ul) {
            $pData = [];
            foreach ($ul->childNodes as $p) {
                if ($p->nodeName === '#text') {
                    continue;
                }

                $titleNode = $p->firstChild->nextSibling;
                $valueNode = $titleNode->nextSibling->nextSibling;

                $pData[trim($titleNode->textContent)] = trim($valueNode->textContent);
            }
            $data[] = $pData;
        }

        return $data;
    }
}
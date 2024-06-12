<?php

namespace Tools\Parser\Parsers;

use DOMNodeList;
use DOMXPath;
use Tools\Parser\ParserInterface;

class OwnersHistoryParser implements ParserInterface
{
    public function parse(DOMXPath $XPath): array
    {
        $titleNode = $XPath->query('/html/body/section/h2[3]')[0];
        $elements  = $XPath->query('/html/body/section/h2[3]/following::div[@class="period"]/div[@class="period-dates"]');

        return [
            'title'   => $titleNode->textContent,
            'history' => $this->getOwnersHistoryDates($elements)
        ];
    }

    protected function getOwnersHistoryDates(DOMNodeList $dateNodes): array
    {
        $data = [];

        foreach ($dateNodes as $node) {
            $data[] = trim($node->textContent);
        }

        return $data;
    }
}
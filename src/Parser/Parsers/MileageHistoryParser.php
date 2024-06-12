<?php

namespace Tools\Parser\Parsers;

use DOMNode;
use DOMXPath;
use Tools\Parser\ParserInterface;

class MileageHistoryParser implements ParserInterface
{
    public function parse(DOMXPath $XPath): array
    {
        $titleNode        = $XPath->query('/html/body/section/h2[2]')[0];
        $historyTableNode = $titleNode->nextSibling->nextSibling;

        return [
            'title'   => $titleNode->textContent,
            'history_table' => $historyTableNode->nodeName === 'table' ? $this->parseHistoryTable($historyTableNode) : null
        ];
    }

    protected function parseHistoryTable(DOMNode $historyTableNode)
    {

        $rows = [];
        foreach ($historyTableNode->childNodes as $tr) {
            $columns = [];
            if ($tr->nodeName === '#text') {
                continue;
            }

            foreach ($tr->childNodes as $th) {
                if ($th->nodeName === '#text') {
                    continue;
                }
                $columns[] = trim($th->textContent);
            }
            $rows[] = $columns;
        }

        return $rows;
    }
}
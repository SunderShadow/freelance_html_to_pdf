<?php

namespace Tools\Parser;

use DOMNode;

class ReportMetaParser
{
    private ReportMetaStorage $meta;

    public function __construct()
    {
        $this->meta = new ReportMetaStorage();
    }

    public function parse(DOMNode $node): ReportMetaParser
    {
        $date        = explode(':', $node->childNodes[3]->textContent)[1];
        $valid_until = explode(':', $node->childNodes[5]->textContent)[1];

        $this->meta->report_date = trim($date);
        $this->meta->valid_until = trim($valid_until);

        return $this;
    }

    public function getMeta(): ReportMetaStorage {
        return $this->meta;
    }
}
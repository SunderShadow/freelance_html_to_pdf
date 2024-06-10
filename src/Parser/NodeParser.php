<?php

namespace Tools\Parser;

use DOMNode;

interface NodeParser
{
    /**
     * @param DOMNode[] $nodes
     * @return int offset
     */
    public function parse(array $nodes): int;

    public function getData();
}
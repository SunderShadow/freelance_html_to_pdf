<?php

namespace Tools\Parser;

use DOMNode;

interface NodeParser
{
    /**
     * @param DOMNode[] $nodes
     * @return void
     */
    public function parse(array $nodes): void;

    public function getData();
}
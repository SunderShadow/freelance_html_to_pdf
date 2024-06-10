<?php

namespace Tools\Parser\Sections;

use Tools\Parser\NodeParser;

class RegistrationDataParser implements NodeParser
{
    protected array $storage;

    public function __construct()
    {
        $this->storage = [];
    }

    public function parse(array $nodes): int
    {
        $table_data = $nodes[1];

        $table_nodes = $table_data->childNodes;
        foreach ($table_nodes as $table_node)
        {
            if ($table_node->nodeName !== '#text')
            {
                $this->storage[$table_node->childNodes[0]->textContent] = $table_node->childNodes[1]->textContent;
            }
        }

        return 0;
    }

    public function getData(): array
    {
        return $this->storage;
    }
}
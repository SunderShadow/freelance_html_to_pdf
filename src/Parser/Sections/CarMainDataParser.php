<?php

namespace Tools\Parser\Sections;

use DOMNodeList;
use Tools\Parser\NodeParser;
use Tools\Parser\Storages\CarMainDataStorage;

class CarMainDataParser implements NodeParser
{
    private $storage;

    public function __construct()
    {
        $this->storage = new CarMainDataStorage();
    }

    public function parse(array $nodes): int
    {
        /** @var DOMNodeList $main_data_nodes */
        $main_data_nodes = $nodes[2]->childNodes;

        $this->storage->name              = $nodes[0]->textContent;
        $this->storage->model_img_link    = $nodes[1]->attributes->getNamedItem('src')->textContent;
        $this->storage->car_img_link      = $nodes[4]->attributes->getNamedItem('src')->textContent;

        $this->storage->manufacture_year  = trim(explode(':', $main_data_nodes->item(2)->textContent)[1]);
        $this->storage->VIN               = trim(explode(':', $main_data_nodes->item(6)->textContent)[1]);
        $this->storage->state_number      = trim(explode(':', $main_data_nodes->item(10)->textContent)[1]);

        return 0;
    }

    public function getData(): CarMainDataStorage
    {
        return $this->storage;
    }
}
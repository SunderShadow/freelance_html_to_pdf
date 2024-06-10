<?php

namespace Tools\Parser;

use DOMElement;
use DOMNode;
use DOMNodeList;
use Tools\Parser\Sections\CarMainDataParser;
use Tools\Parser\Sections\RegistrationDataParser;
use Tools\Parser\Storages\AnnouncementStorage;
use Tools\Parser\Storages\CarMainDataStorage;
use Tools\Parser\Storages\CarMileageStorage;

class ReportSectionParser
{
    public CarMainDataStorage $car_main_data;

    public array $registration_data_storage = [];

    /** @var CarMileageStorage[] */
    public array $car_mileage = [];

    public array $owners_history = [];

    public array $insurance_history = [];

    public array $characteristic = [];

    /** @var AnnouncementStorage[]  */
    public array $announcements = [];

    public array $car_tech_info = [];

    public function __construct()
    {
        $this->car_main_data = new CarMainDataStorage();
    }

    public function parse(DOMElement $rootNode)
    {
        $nodes = [];
        foreach ($rootNode->childNodes as $node) {
            if ($node->nodeName !== '#text') {
                $nodes[] = $node;
            }
        }

        $mainDataParser = new CarMainDataParser();
        $mainDataParser->parse(array_slice($nodes, 0, 6));
        $this->car_main_data = $mainDataParser->getData();

        $registrationDataParser = new RegistrationDataParser();
        $registrationDataParser->parse(array_slice($nodes, 6, 4));
        $this->registration_data_storage = $registrationDataParser->getData();

        $this->parseCarMileage(array_slice($nodes, 10, 4));
        $offset = $this->parseOwnersHistory($nodes, 14);
        $offset = $this->parseInsuranceHistory($nodes, $offset);
        $this->parseCharacteristic(array_slice($nodes, $offset, 3));
        $this->parseAnnouncements(array_slice($nodes, $offset + 3));
    }

    /**
     * @param DOMNode[] $nodes
     * @return void
     */
    private function parseCarMileage(array $nodes)
    {
        foreach ($nodes[1]->childNodes as $node) {
            if (
                $node->nodeName !== '#text'
                && $node->childElementCount === 3
            ) {
                $this->car_mileage[] = $storage = new CarMileageStorage();

                $storage->date    = $node->childNodes[3]->textContent;
                $storage->mileage = $node->childNodes[5]->textContent;
            }
        }

        array_shift($this->car_mileage);
    }

    /**
     * @param DOMNode[] $nodes
     * @return int offset
     */
    private function parseOwnersHistory(array $nodes, int $offset): int
    {
        $start_counter = $history_counter = $offset + 1;
        $node = $nodes[$history_counter];
        do
        {
            $this->owners_history[] = $node->childNodes[3]->textContent;
            $node = $nodes[++$history_counter];
        } while ($node->nodeName !== 'h2');

        return $offset + $history_counter - $start_counter;
    }

    /**
     * @param DOMNode[] $nodes
     * @return int offset
     */
    private function parseInsuranceHistory(array $nodes, $offset): int
    {
        $offset += 2;
        $nodes = array_slice($nodes, $offset);

        $insurance_count = 0;
        foreach ($nodes as $node)
        {
            if ($node->nodeName !== 'div') {
                break;
            }

            $insurance_count++;
            $insurance_table = $node->childNodes[3]->childNodes;

            $insurance_data = [];
            foreach ($insurance_table as $table_item_node)
            {
                if ($table_item_node->nodeName !== '#text')
                {
                    $insurance_data[$table_item_node->childNodes[1]->textContent] = trim($table_item_node->childNodes[3]->textContent);
                }
            }
            $this->insurance_history[] = $insurance_data;
        }

        return $offset + $insurance_count;
    }

    /**
     * @param DOMNode[] $nodes
     * @return void
     */
    private function parseCharacteristic(array $nodes)
    {
        $car_tech_info_nodes = $nodes[1]->childNodes[1]->firstChild->childNodes;
        $car_tech_info_side_node = $car_tech_info_nodes[0];
        $car_tech_info_front_node = $car_tech_info_nodes[1];

        $this->car_tech_info = [
            'side' => [
                'img' => $car_tech_info_side_node->childNodes[0]->childNodes[1]->attributes[1]->textContent,
                'width' => trim($car_tech_info_side_node->childNodes[4]->textContent),
                'height' => trim($car_tech_info_side_node->childNodes[2]->textContent)
            ],
            'front' => [
                'img' => $car_tech_info_front_node->childNodes[1]->attributes[1]->textContent,
                'width' => trim($car_tech_info_front_node->childNodes[3]->textContent),
                'height' => trim($car_tech_info_front_node->childNodes[2]->textContent)
            ]
        ];

        foreach ($nodes[2]->childNodes as $table_item)
        {
            if ($table_item->nodeName !== "#text")
            {
                $this->characteristic[$table_item->childNodes[0]->textContent] = $table_item->childNodes[1]->textContent;
            }
        }
    }

    /**
     * @param DOMNode[] $nodes
     * @return void
     */
    private function parseAnnouncements(array $nodes)
    {
        array_shift($nodes);

        if ($nodes[0]->nodeName === 'p') {
            array_shift($nodes);
        }

        foreach ($nodes as $node)
        {
            if ($node->nodeName !== 'div')
            {
                break;
            }

            $data = new AnnouncementStorage();
            $data->date       = trim($node->childNodes[2]->textContent);
            $data->title      = trim($node->childNodes[3]->textContent);
            $data->images     = [];
            $data->properties = [];
            if ($node->childNodes[11] !== null) {
                $data->comment    = trim($node->childNodes[11]->textContent);
            } else {
                $data->comment = '';
            }

            $images_nodes = $node->childNodes[5]->childNodes;

            foreach ($images_nodes as $img_node)
            {
                if ($img_node->nodeName !== '#text')
                {
                    $data->images[] = $img_node->childNodes[1]->attributes[2]->textContent;
                }
            }

            $properties_nodes = $node->childNodes[7]->childNodes;
            foreach ($properties_nodes as $proprty_node)
            {
                if ($proprty_node->nodeName !== '#text')
                {
                    $data->properties[trim($proprty_node->childNodes[0]->textContent)] = trim($proprty_node->childNodes[1]->textContent);
                }
            }

            $this->announcements[] = $data;
        }
    }
}
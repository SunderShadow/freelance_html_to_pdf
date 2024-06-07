<?php

namespace Tools\Parser;

use DOMDocument;
use Exception;
use Tools\Parser\ReportSection\AnnouncementStorage;
use Tools\Parser\ReportSection\CarMainDataStorage;
use Tools\Parser\ReportSection\RegistrationDataStorage;
use Tools\Parser\ReportSection\ReportSectionParser;

class ReportParser
{
    private DOMDocument $dom_root;

    public string $host_url;

    public ReportMetaStorage $meta;

    public CarMainDataStorage $car_main_data;

    public array $registration_data_storage;

    public array $car_mileage = [];

    public array $owners_history = [];

    public array $insurance_history = [];

    public array $characteristic = [];

    /** @var AnnouncementStorage[]  */
    public array $announcements = [];

    public array $car_tech_info = [];

    function __construct()
    {
        $this->dom_root = new DOMDocument('1.0', 'UTF-8');
    }

    /**
     * @throws Exception
     */
    function parseDocument(string $link_to_dom)
    {
        if (!$data = file_get_contents($link_to_dom)) {
            throw new Exception('Wrong link path: ' . $link_to_dom);
        }
        $parsed_url = parse_url($link_to_dom);
        $this->host_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];

        $this->parse($data);
    }

    function parse(string $domContent)
    {
        $this->dom_root->loadHTML($domContent,  LIBXML_NOWARNING | LIBXML_NOERROR);

        $dom_main_node = $this->dom_root->getElementsByTagName('main')->item(0);

        $meta_parser = new ReportMetaParser();

        $dom_report_section_node = $this->dom_root->getElementsByTagName('section')->item(0);

        $parser = new ReportSectionParser();
        $parser->parse($dom_report_section_node);

        $this->meta = $meta_parser->parse($dom_main_node)->getMeta();

        $this->car_main_data                = $parser->car_main_data;
        $this->registration_data_storage    = $parser->registration_data_storage;
        $this->car_mileage                  = $parser->car_mileage;
        $this->owners_history               = $parser->owners_history;
        $this->insurance_history            = $parser->insurance_history;
        $this->characteristic               = $parser->characteristic;
        $this->announcements                = $parser->announcements;
        $this->car_tech_info                = $parser->car_tech_info;
    }
}
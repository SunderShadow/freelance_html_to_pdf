<?php

namespace Tools;

use DOMDocument;
use Tools\Parser\ParserAccumulator;
use Tools\Parser\ParserAccumulatorInterface;

class Parser
{
    public ParserAccumulatorInterface $parser;
    public function __construct()
    {
        $this->parser = new ParserAccumulator();
        $this->parser->register(static::setParsers());
    }

    static protected function setParsers(): array
    {
        return [
            'meta'               => new \Tools\Parser\Parsers\MetaDataParser(),
            'main'               => new \Tools\Parser\Parsers\MainDataParser(),
            'registration'       => new \Tools\Parser\Parsers\RegistrationDataParser(),
            'mileage_history'    => new \Tools\Parser\Parsers\MileageHistoryParser(),
            'owners_history'     => new \Tools\Parser\Parsers\OwnersHistoryParser(),
            'insurance_history'  => new \Tools\Parser\Parsers\InsuranceHistoryParser(),
            'characteristics'    => new \Tools\Parser\Parsers\CharacteristicsDataParser(),
            'announcements'      => new \Tools\Parser\Parsers\AnnouncementsParser()
        ];
    }

    public function parse(DOMDocument $dom): void
    {
        $this->parser->parse($dom);
    }

    public function parseFile(string $filePath): void
    {
        $this->parser->parseFile($filePath);
    }

    public function getData(): array
    {
        return $this->parser->getData();
    }
}
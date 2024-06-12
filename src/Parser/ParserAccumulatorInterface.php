<?php

namespace Tools\Parser;

use DOMDocument;

interface ParserAccumulatorInterface
{
    /**
     * Register new parser like
     * @param array $parsers
     * @return void
     * @example register(['someData' => new ParserInterface()])
     */
    public function register(array $parsers): void;

    /**
     * Parses data using registered parsers
     * @param DOMDocument $dom
     * @return void
     */
    public function parse(DOMDocument $dom): void;

    public function parseFile(string $filePath): void;

    /**
     * Return data like
     * @example ['someData' => [1, 2, 3, ...]]
     * @return mixed
     */
    public function getData(): array;
}
<?php

namespace Tools\Parser;

interface DOMParser
{
    public function parse(string $dom): void;

    public function getData();
}
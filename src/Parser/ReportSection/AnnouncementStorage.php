<?php

namespace Tools\Parser\ReportSection;

class AnnouncementStorage
{
    public string $title;

    public string $date;

    /** @var string[] */
    public array $images;

    public array $properties;

    public string $comment;
}
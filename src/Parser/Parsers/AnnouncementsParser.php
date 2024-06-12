<?php

namespace Tools\Parser\Parsers;

use DOMNodeList;
use DOMXPath;
use Tools\Parser\ParserInterface;

class AnnouncementsParser implements ParserInterface
{
    public function parse(DOMXPath $XPath): array
    {
        $titleNode = $XPath->query('/html/body/section/h2[6]')[0];
        if (!$titleNode) {
            return [];
        }

        $announcements = $XPath->query('/html/body/section/h2[6]/following-sibling::div[@class="list-div"]');

        return [
            'title' => $titleNode->textContent,
            'announcements' => $this->getAnnouncementsData($announcements)
        ];
    }

    protected function getAnnouncementsData(DOMNodeList $announcementsNodes): array
    {
        $data = [];

        foreach ($announcementsNodes as $node) {
            $announcementData = [
                'images'     => [],
                'properties' => []
            ];

            $dateNode       = $node->firstChild->nextSibling->nextSibling;
            $titleNode      = $dateNode->nextSibling;
            $imagesNode     = $titleNode->nextSibling->nextSibling;
            $propertiesNode = $imagesNode->nextSibling->nextSibling;

            foreach ($imagesNode->childNodes as $imageNode) {
                if ($imageNode->nodeName === '#text') {
                    continue;
                }

                $announcementData['images'][] = $imageNode->firstChild->nextSibling->attributes[2]->textContent;
            }

            foreach ($propertiesNode->childNodes as $propertyNode) {
                if ($propertyNode->nodeName === '#text') {
                    continue;
                }

                $key = $propertyNode->firstChild->textContent;
                $value = $propertyNode->firstChild->nextSibling->textContent;

                $announcementData['properties'][$key] = $value;
            }

            $announcementData['date']  = trim($dateNode->textContent);
            $announcementData['title'] = trim($titleNode->textContent);
            $announcementData['comment'] = trim($node->childNodes[$node->childNodes->count() - 2]->textContent);

            $data[] = $announcementData;
        }

        return $data;
    }
}
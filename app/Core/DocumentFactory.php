<?php

declare(strict_types=1);

namespace App\Core;

use DiDom\Document;

class DocumentFactory
{
    public function create(string $url): Document
    {
        return new Document($url, true);
    }
}

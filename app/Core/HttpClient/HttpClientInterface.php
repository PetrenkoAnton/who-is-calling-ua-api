<?php

declare(strict_types=1);

namespace App\Core\HttpClient;

interface HttpClientInterface
{
    public function getContent(string $url): string;
}

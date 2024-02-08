<?php

declare(strict_types=1);

namespace App\Core\HttpClient;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function getResponse(string $url): ResponseInterface;
}

<?php

declare(strict_types=1);

namespace App\Core\HttpClient;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    /**
     * @throws ClientExceptionInterface
     */
    public function getContent(string $url): string;

    public function getResponse(string $url): ResponseInterface;
}

<?php

declare(strict_types=1);

namespace App\Core\HttpClient;

use Psr\Http\Client\ClientExceptionInterface;

interface HttpClientInterface
{
    /**
     * @throws ClientExceptionInterface
     */
    public function getContent(string $url): string;
}

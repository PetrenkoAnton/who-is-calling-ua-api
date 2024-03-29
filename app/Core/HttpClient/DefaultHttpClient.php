<?php

declare(strict_types=1);

namespace App\Core\HttpClient;

use App\Core\HttpClient\UserAgent\UserAgentInterface;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class DefaultHttpClient implements HttpClientInterface
{
    public function __construct(private readonly UserAgentInterface $userAgent)
    {
    }

    public function getResponse(string $url): ResponseInterface
    {
        $client = new Client(([
            'headers' => [
                'User-Agent' => $this->userAgent->getValue(),
            ],
        ]));

        return $client->get($url);
    }
}

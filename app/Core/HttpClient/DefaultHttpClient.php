<?php

declare(strict_types=1);

namespace App\Core\HttpClient;

use App\Core\HttpClient\UserAgent\UserAgentInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DefaultHttpClient implements HttpClientInterface
{
    public function __construct(private readonly UserAgentInterface $userAgent)
    {

    }

    /**
     * @throws GuzzleException
     */
    public function getContent(string $url): string
    {
        $client = new Client(([
            'headers' => [
                'User-Agent' => $this->userAgent->getAgent(),
            ]
        ]));

        return $client->get($url)->getBody()->getContents();
    }
}

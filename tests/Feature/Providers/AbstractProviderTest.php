<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\HttpClient\DefaultHttpClient;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\Providers\CIProvider;
use App\Core\Providers\ProviderInterface;
use Tests\TestCase;

class AbstractProviderTest extends TestCase
{
    public function testSuccessfulParseComments(string $phone, array $expectedComments)
    {
        $comments = $this->getProvider($phone)->getComments($phone);

        $this->assertIsArray($comments);
        $this->assertCount(count($expectedComments), $comments);

        foreach ($expectedComments as $key => $value)
            $this->assertEquals($value, $comments[$key]);
    }

    private function getProvider(string $phone): ProviderInterface
    {
        $providerClass = $this->getProviderClass();

        $path = __DIR__ . \sprintf('/../data/%s-%s.html', $providerClass::getEnum()->name, $phone);
        $content = \file_get_contents($path);

        $httpClient = $this->createMock(DefaultHttpClient::class);
        $httpClient
            ->method('getContent')
            ->willReturn($content);

        $this->app
            ->when(CIProvider::class)
            ->needs(HttpClientInterface::class)
            ->give(function () use ($httpClient) {
                return $httpClient;
            });

        return $this->app->make($providerClass);
    }
}

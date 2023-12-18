<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\HttpClient\DefaultHttpClient;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\Providers\ProviderInterface;
use Tests\TestCase;

class AbstractProviderTest  extends TestCase
{
    public function testSuccessfulParseComments(string $phone, array $expectedComments)
    {
        $comments = $this->getProvider($phone)->getComments($phone);

        $this->assertIsArray($comments);
        $this->assertCount(count($expectedComments), $comments);

        foreach ($expectedComments as $key => $value)
            $this->assertEquals($value, $comments[$key]);
    }

    protected function getProvider(string $phone): ProviderInterface
    {
        $providerClass = $this::PROVIDER_CLASS;

        $path = __DIR__ . \sprintf('/../data/%s-%s.html', $providerClass::CODE, $phone);
        $content = \file_get_contents($path);

        $httpClient = $this->createMock(DefaultHttpClient::class);
        $httpClient
            ->method('getContent')
            ->willReturn($content);

        $this->app
            ->when($providerClass)
            ->needs(HttpClientInterface::class)
            ->give($httpClient);

        return $this->app->make($providerClass);
    }
}

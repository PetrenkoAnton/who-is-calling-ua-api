<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\Formatters\UrlFormatters\UrlFormatterCollection;
use App\Core\HttpClient\DefaultHttpClient;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\Providers\ProviderInterface;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class AbstractProviderTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testSuccessfulParseComments(string $phone, array $expectedComments)
    {
        $comments = $this->getProvider($phone)->getComments($phone);

        $this->assertIsArray($comments);
        $this->assertCount(count($expectedComments), $comments);

        foreach ($expectedComments as $key => $value)
            $this->assertEquals($value, $comments[$key]);
    }

    /**
     * @throws Exception
     */
    private function getProvider(string $phone): ProviderInterface
    {
        $providerClass = $this->getProviderClass();
        $providerEnum = $providerClass::getEnum();

        $path = __DIR__ . \sprintf('/../data/%s-%s.html', $providerEnum->name, $phone);
        $content = \file_get_contents($path);

        $urlFormatters = $this->app->make(UrlFormatterCollection::class);

        $url = $urlFormatters->getFirstFor($providerEnum)->format($phone);

        $httpClient = $this->createMock(DefaultHttpClient::class);
        $httpClient
            ->method('getContent')
            ->with($url)
            ->willReturn($content);

        $this->app
            ->when($providerClass)
            ->needs(HttpClientInterface::class)
            ->give(fn () => $httpClient);


        return $this->app->make($providerClass);
    }
}

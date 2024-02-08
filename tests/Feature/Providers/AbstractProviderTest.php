<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\Formatters\UrlFormatters\UrlFormatterCollection;
use App\Core\HttpClient\DefaultHttpClient;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\Providers\ProviderInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tests\TestCase;

use function count;
use function file_get_contents;
use function sprintf;

abstract class AbstractProviderTest extends TestCase
{
    abstract public function getProviderClass(): string;

    /**
     * @throws Exception
     */
    public function testSuccessfulParseComments(string $phone, array $expectedComments): void
    {
        $comments = $this->getProvider($phone)->getComments($phone);

        $this->assertIsArray($comments);
        $this->assertCount(count($expectedComments), $comments);

        foreach ($expectedComments as $key => $value) {
            $this->assertEquals($value, $comments[$key]);
        }
    }

    /**
     * @throws Exception
     */
    private function getProvider(string $phone): ProviderInterface
    {
        $providerClass = $this->getProviderClass();
        $providerEnum = $providerClass::getEnum();

        $path = __DIR__ . sprintf('/../data/%s-%s.html', $providerEnum->name, $phone);
        $content = file_get_contents($path);

        $urlFormatters = $this->app->make(UrlFormatterCollection::class);

        $url = $urlFormatters->getFirstFor($providerEnum)->format($phone);

        $stream = $this->createMock(StreamInterface::class);
        $stream
            ->method('getContents')
            ->willReturn($content);

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($stream);

        $httpClient = $this->createMock(DefaultHttpClient::class);
        $httpClient
            ->method('getResponse')
            ->with($url)
            ->willReturn($response);

        $this->app
            ->when($providerClass)
            ->needs(HttpClientInterface::class)
            ->give(fn () => $httpClient);

        return $this->app->make($providerClass);
    }
}

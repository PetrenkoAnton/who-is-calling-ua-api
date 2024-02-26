<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\HttpClient\DefaultHttpClient;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\Providers\ProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tests\TestCase;

use function count;
use function file_get_contents;
use function sprintf;

abstract class AbstractProviderTest extends TestCase
{
    abstract public function getProviderClass(): string;

    public function testSuccessfulParseComments(string $phone, array $expectedComments): void
    {
        $comments = $this->getProvider($phone)->getComments($phone);

        $this->assertIsArray($comments);
        $this->assertCount(count($expectedComments), $comments);

        foreach ($expectedComments as $key => $value) {
            $this->assertEquals($value, $comments[$key]);
        }
    }

    private function getProvider(string $phone): ProviderInterface
    {
        $providerClass = $this->getProviderClass();
        $providerEnum = $providerClass::ENUM;

        $path = __DIR__ . sprintf('/../data/%s-%s.html', $providerEnum->name, $phone);
        $content = file_get_contents($path);

        // @phpstan-ignore-next-line
        $this->mockHttpResponse($content);

        return $this->app->make($providerClass);
    }

    private function mockHttpResponse(string $content): void
    {
        $stream = $this->createConfiguredMock(StreamInterface::class, [
            'getContents' => $content,
        ]);

        $response = $this->createConfiguredMock(ResponseInterface::class, [
            'getBody' => $stream,
        ]);

        $httpClient = $this->createConfiguredMock(DefaultHttpClient::class, [
            'getResponse' => $response,
        ]);

        $this->app->bind(HttpClientInterface::class, fn () => $httpClient);
    }
}

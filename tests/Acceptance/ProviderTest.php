<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\UrlFormatterCollection;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\Parsers\ParserCollection;
use App\Core\ProviderEnum;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class ProviderTest extends TestCase
{
    /**
     * @group smoke
     */
    public function testDp(): void
    {
        $providers = ProviderEnum::cases();

        foreach ($this->dp() as $k => $v) {
            $providers = array_filter($providers, fn ($provider) => $provider != $v[0]);
        }

        if (count($providers)) {
            $asString = implode(' | ', array_column($providers, 'name'));
            $this->fail(sprintf('No tests for providers: %s', $asString));
        }

        $this->assertEmpty($providers);
    }

    /**
     * @group smoke
     * @dataProvider dp
     */
    public function testProviderContentAvailable(ProviderEnum $enum, string $pn): void
    {
        $this->checkSkipped($enum);

        $url = $this->getUrl($enum, $pn);

        try {
            $response = $this->getResponse($url);
        } catch (ClientException $e) {
            switch ($e->getCode()) {
                case 403:
                    $this->markTestIncomplete(sprintf('Blocked (403): %s', $url));
                case 404:
                    $this->fail(sprintf('Not found (404): %s', $url));
                default:
                    $this->fail(sprintf('Error (%d): %s', $e->getCode(), $e->getMessage()));
            }
        }

        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getBody()->getContents();

        $html = $this->app->make(DocumentFactory::class)->create($content);

        $parser = $this->app->make(ParserCollection::class)->getFirstFor($enum);

        $expression = $parser->getCommentsExpression();

        if (!$html->count($expression)) {
            $this->markTestIncomplete(sprintf('Updated structure or deleted comments: %s', $url));
        }
    }

    public static function dp(): array
    {
        return [
            ProviderEnum::CF->name => [ProviderEnum::CF, '672907523'],
            ProviderEnum::CI->name => [ProviderEnum::CI, '443211864'],
            ProviderEnum::KC->name => [ProviderEnum::KC, '661541508'],
            ProviderEnum::KZ->name => [ProviderEnum::KZ, '631885006'],
            ProviderEnum::SL->name => [ProviderEnum::SL, '631885006'],
            ProviderEnum::TD->name => [ProviderEnum::TD, '445855178'],
        ];
    }

    private function getResponse(string $url): ResponseInterface
    {
        $httpClient = $this->app->make(HttpClientInterface::class);
        return $httpClient->getResponse($url);
    }

    private function getUrl(ProviderEnum $enum, string $pn): string
    {
        $urlFormatterCollection = $this->app->make(UrlFormatterCollection::class);
        $urlFormatter = $urlFormatterCollection->getFirstFor($enum);

        return $urlFormatter->format($pn);
    }

    private function checkSkipped(ProviderEnum $enum): void
    {
        $providerEnv = \sprintf('%s_PROVIDER', $enum->name);

        if (!env($providerEnv)) {
            $this->markTestSkipped(\sprintf('%s=false', $providerEnv));
        }
    }
}

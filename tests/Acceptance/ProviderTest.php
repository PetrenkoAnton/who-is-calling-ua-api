<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use App\Core\DocumentFactory;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\ProviderEnum;
use App\Core\Providers\CFProvider;
use App\Core\Providers\CIProvider;
use App\Core\Providers\KCProvider;
use App\Core\Providers\KZProvider;
use App\Core\Providers\SLProvider;
use App\Core\Providers\TDProvider;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

use function array_column;
use function array_filter;
use function count;
use function env;
use function implode;
use function sprintf;

class ProviderTest extends TestCase
{
    /**
     * @group smoke
     */
    public function testDp(): void
    {
        $providers = ProviderEnum::cases();

        foreach ($this->dp() as $p) {
            $providers = array_filter($providers, fn ($provider) => $provider !== $p[0]::ENUM);
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
    public function testProviderContentAvailable(string $providerClass, string $pn): void
    {
        $provider = $this->app->make($providerClass);

        $this->checkSkipped($provider->getEnum());

        $url = $provider->getUrl($pn);

        try {
            $response = $this->getResponse($url);
        } catch (ClientException $e) {
            switch ($e->getCode()) {
                case 403:
                    $this->markTestIncomplete(sprintf('Blocked (403): %s', $url));
                    // no break
                case 404:
                    $this->fail(sprintf('Not found (404): %s', $url));
                    // no break
                default:
                    $this->fail(sprintf('Error (%d): %s', $e->getCode(), $e->getMessage()));
                    // no break
            }
        }

        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getBody()->getContents();

        $html = $this->app->make(DocumentFactory::class)->create($content);

        $expression = $provider->parser->getCommentsExpression();

        if (!$html->count($expression)) {
            $this->markTestIncomplete(sprintf('Updated structure or deleted comments: %s', $url));
        }
    }

    public static function dp(): array
    {
        return [
            CFProvider::ENUM->name => [CFProvider::class, '672907523'],
            CIProvider::ENUM->name => [CIProvider::class, '443211864'],
            KCProvider::ENUM->name => [KCProvider::class, '661541508'],
            KZProvider::ENUM->name => [KZProvider::class, '631885006'],
            SLProvider::ENUM->name => [SLProvider::class, '631885006'],
            TDProvider::ENUM->name => [TDProvider::class, '445855178'],
        ];
    }

    private function getResponse(string $url): ResponseInterface
    {
        $httpClient = $this->app->make(HttpClientInterface::class);

        return $httpClient->getResponse($url);
    }

    private function checkSkipped(ProviderEnum $enum): void
    {
        $providerEnv = sprintf('%s_PROVIDER', $enum->name);

        if (!env($providerEnv)) {
            $this->markTestSkipped(sprintf('%s=false', $providerEnv));
        }
    }
}

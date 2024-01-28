<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use App\Core\DocumentFactory;
use App\Core\Formatters\OutputPNFormatter;
use App\Core\Formatters\UrlFormatters\CFUrlFormatter;
use App\Core\Formatters\UrlFormatters\UrlFormatterCollection;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\Parsers\CIParser;
use App\Core\Parsers\ParserCollection;
use App\Core\ProviderEnum;
use App\Core\Providers\AbstractProvider;
use App\Core\Providers\CFProvider;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class ProviderTest extends TestCase
{
    private HttpClientInterface $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = $this->app->make(HttpClientInterface::class);
    }

    /**
     * @group smoke
     * @group +
     */
    public function testCFProviderContentAvailable(): void
    {
        $enum = CFProvider::getEnum();
        $pn = '672907524';

        $this->checkSkipped($enum);

        $response = $this->getResponse($enum, $pn);

        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getBody()->getContents();

        $html = $this->app->make(DocumentFactory::class)->create($content);

        $exists = $html->has('.reviews');

        var_dump($exists); die;

        $parser = $this->app->make(ParserCollection::class)->getFirstFor($enum);
        $expression = $parser->getExpression();
        var_dump($expression); die;

        var_dump($response->getBody()->getContents()); die;
    }

    private function getResponse(ProviderEnum $enum, string $pn): ResponseInterface
    {
        $httpClient = $this->app->make(HttpClientInterface::class);
        $response = $httpClient->getResponse($this->getUrl($enum, $pn));

        return $response;
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

        if (!env($providerEnv))
        {
            $this->markTestSkipped(\sprintf('%s disabled', $providerEnv));
        }
    }
}

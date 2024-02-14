<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\UrlFormatterCollection;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\Parsers\ParserCollection;
use App\Core\ProviderEnum;
use DiDom\Element;
use DiDom\Exceptions\InvalidSelectorException;
use Psr\Http\Client\ClientExceptionInterface;

use function getenv;
use function sprintf;
use function strtoupper;

abstract class AbstractProvider implements ProviderInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly DocumentFactory $documentFactory,
        private readonly ParserCollection $parsers,
        private readonly UrlFormatterCollection $urlFormatters,
    ) {
    }

    public function getUrl(string $phone): string
    {
        return $this->urlFormatters->getFirstFor($this->getEnum())->format($phone);
    }

    public function enable(): bool
    {
        $key = sprintf('%s_PROVIDER', strtoupper($this->getEnum()->name));

        return (bool) getenv($key, false);
    }

    /**
     * @return array<string>
     *
     * @throws InvalidSelectorException
     * @throws ClientExceptionInterface
     */
    public function getComments(string $phone): array
    {
        $outputComments = [];

        $enum = $this->getEnum();
        $parser = $this->parsers->getFirstFor($enum);

        $content = $this->httpClient->getResponse($this->getUrl($phone))->getBody()->getContents();

        $document = $this->documentFactory->create($content);
        $comments = $document->find($parser->getCommentsExpression());

        foreach ($comments as $comment) {
            /** @var Element $comment */
            if (!$parser->ignore($comment->text())) {
                $outputComments[] = $parser->format($comment->text());
            }
        }

        return $outputComments;
    }
}

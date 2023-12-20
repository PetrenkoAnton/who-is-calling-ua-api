<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\Formatters\UrlFormatters\UrlFormatterCollection;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\Parsers\ParserCollection;
use App\Core\DocumentFactory;
use App\Core\ProviderEnum;
use DiDom\Element;
use DiDom\Exceptions\InvalidSelectorException;
use Psr\Http\Client\ClientExceptionInterface;

abstract class AbstractProvider implements ProviderInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly DocumentFactory $documentFactory,
        private readonly ParserCollection $parsers,
        private readonly UrlFormatterCollection $urlFormatters,
    ) {}

    abstract static function getEnum(): ProviderEnum;

    // TODO! Add test
    public function getUrl(string $phone): string
    {

        return $this->urlFormatters->getFirstFor($this->getEnum())->format($phone);
    }

    public function enable(): bool
    {
        $key = sprintf('%s_PROVIDER', strtoupper($this->getEnum()->name));
        return (bool)\env($key);
    }

    /**
     * @throws InvalidSelectorException
     * @throws ClientExceptionInterface
     */
    public function getComments(string $phone): array
    {
        $outputComments = [];

        $enum = $this->getEnum();
        $parser = $this->parsers->getFirstFor($enum);

        $content = $this->httpClient->getContent($this->getUrl($phone));

        $document = $this->documentFactory->create($content);
        $comments = $document->find($parser->getExpression());

        foreach ($comments as $comment)
            /** @var $comment Element */
            if (!$parser->ignore($comment->text()))
                $outputComments[] = $parser->format($comment->text());

        return $outputComments;
    }
}

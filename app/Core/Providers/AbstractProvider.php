<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\UrlFormatterInterface;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\Parsers\ParserInterface;
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
        public readonly ParserInterface $parser,
        private readonly UrlFormatterInterface $urlFormatter,
    ) {
    }

    abstract public function getEnum(): ProviderEnum;

    public function getUrl(string $phone): string
    {
        return $this->urlFormatter->format($phone);
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

        $content = $this->httpClient->getResponse($this->getUrl($phone))->getBody()->getContents();

        $document = $this->documentFactory->create($content);
        $comments = $document->find($this->parser->getCommentsExpression());

        foreach ($comments as $comment) {
            /** @var Element $comment */
            if (!$this->parser->ignore($comment->text())) {
                $outputComments[] = $this->parser->format($comment->text());
            }
        }

        return $outputComments;
    }
}

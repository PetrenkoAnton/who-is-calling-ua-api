<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\HttpClient\HttpClientInterface;
use App\Core\Parsers\ParserInterface;
use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\UrlFormatterInterface;
use DiDom\Element;

abstract class AbstractProvider implements ProviderInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly DocumentFactory $documentFactory,
        private readonly ParserInterface $commentFormatter,
        private readonly UrlFormatterInterface $urlFormatter,
    ) {}

    public function getName(): string
    {
        return $this::NAME;
    }

    public function getComments(string $phone): array
    {
        $outputComments = [];

        $content = $this->httpClient->getContent($this->urlFormatter->format($phone));

        var_dump($content);
        die;

        $document = $this->documentFactory->create($content);
        $comments = $document->find($this->commentFormatter->getExpression());

        foreach ($comments as $comment)
            /** @var $comment Element */
            if (!$this->commentFormatter->ignore($comment->text()))
                $outputComments[] = $this->commentFormatter->format($comment->text());

        return $outputComments;
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use App\Helpers\CommentFormatterInterface;
use App\Helpers\UrlFormatterInterface;
use DiDom\Element;

abstract class AbstractSearchProvider implements SearchProviderInterface
{
    public function __construct(
        private readonly DocumentFactory $documentFactory,
        private readonly CommentFormatterInterface $commentFormatter,
        private readonly UrlFormatterInterface $urlFormatter,
    ) {}

    public function getName(): string
    {
        return $this::NAME;
    }

    public function getComments(string $phone): array
    {
        $outputComments = [];

        $document = $this->documentFactory->create($this->urlFormatter->format($phone));
        $comments = $document->find($this->commentFormatter->getExpression());

        foreach ($comments as $comment)
            /** @var $comment Element */
            $outputComments[] = $this->commentFormatter->format($comment->text());

        return $outputComments;
    }
}

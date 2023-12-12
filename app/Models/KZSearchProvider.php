<?php

declare(strict_types=1);

namespace App\Models;

use App\Helpers\CommentFormatter;
use DiDom\Element;
use DiDom\Exceptions\InvalidSelectorException;

class KZSearchProvider implements SearchProviderInterface
{
    public const NAME = 'ktozvonil.net';

    public function __construct(
        public readonly DocumentFactory $documentFactory,
        private readonly CommentFormatter $commentFormatter,
    )
    {
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @throws InvalidSelectorException
     */
    public function getComments(string $phone): array
    {
        $outputComments = [];
        $url = 'https://ktozvonil.net/nomer/' . $phone;

        $document = $this->documentFactory->create($url);
        $comments = $document->find('.comments .content');

        foreach ($comments as $comment)
            /** @var $comment Element */
            $outputComments[] = $this->commentFormatter->kzformat($comment->text());

        return $outputComments;
    }
}

<?php

namespace App\Models;

use DiDom\Document;
use DiDom\Element;
use DiDom\Exceptions\InvalidSelectorException;

class TDSearchProvider implements SearchProviderInterface
{
    public const NAME = 'telefonnyjdovidnyk.com.ua';

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
        $url = 'https://www.telefonnyjdovidnyk.com.ua/nomer/' . $phone;

        $document = new Document($url, true);
        $comments = $document->find('.comment-item .comment .comment-text');

        foreach ($comments as $comment)
            /** @var $comment Element */
            $outputComments[] = $comment->text();

        return $outputComments;
    }
}

<?php
declare(strict_types=1);

namespace App\Services;

use DiDom\Document;
use DiDom\Element;
use DiDom\Exceptions\InvalidSelectorException;
use JetBrains\PhpStorm\ArrayShape;

class SearchService
{
    /**
     * @throws InvalidSelectorException
     */
    #[ArrayShape(['phone' => "string", 'comments' => "array", 'from_cache' => "boolean"])]
    public function search(string $number): array
    {
        $outputComments = [];
        $url = 'https://www.telefonnyjdovidnyk.com.ua/nomer/' . $number;

        $document = new Document($url, true);
        $comments = $document->find('.comment-item .comment .comment-text');

        foreach ($comments as $comment)
            /** @var $comment Element */
            $outputComments[] = $comment->text();

        return [
            'phone' => $number,
            'comments' => $outputComments,
            'from_cache' => false,
        ];
    }
}

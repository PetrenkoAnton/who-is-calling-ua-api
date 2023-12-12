<?php

declare(strict_types=1);

namespace App\Models;

use DiDom\Document;
use DiDom\Element;
use DiDom\Exceptions\InvalidSelectorException;

class KZSearchProvider implements SearchProviderInterface
{
    public const NAME = 'ktozvonil.net';

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

        $document = new Document($url, true);
        $comments = $document->find('.comments .content');


        foreach ($comments as $comment)
            /** @var $comment Element */
            $outputComments[] = $comment->text();

        return $outputComments;
    }
}

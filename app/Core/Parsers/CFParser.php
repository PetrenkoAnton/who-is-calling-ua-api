<?php

declare(strict_types=1);

namespace App\Core\Parsers;

class CFParser extends AbstractParser implements ParserInterface
{
    public function getCommentsExpression(): string
    {
        return '.review .review_comment';
    }

    public function getIgnoreCommentsList(): array
    {
        return [
            'Цей відгук прихований модератором. Причина:',
        ];
    }
}

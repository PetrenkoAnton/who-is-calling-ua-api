<?php

declare(strict_types=1);

namespace App\Core\Parsers;

class CIParser extends AbstractParser implements ParserInterface
{
    public function getCommentsExpression(): string
    {
        return '.comment .summary p';
    }

    /**
     * @return array<string>
     */
    public function getIgnoreCommentsList(): array
    {
        return [
            'Цей коментар був на прохання тимчасово видалений',
        ];
    }
}

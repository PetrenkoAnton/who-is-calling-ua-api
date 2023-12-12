<?php

declare(strict_types=1);

namespace App\Models;

class TestSearchProvider implements SearchProviderInterface
{
    public const NAME = 'test.test';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getComments(string $phone): array
    {
        return [
            'test 1',
            'test 2',
        ];
    }
}

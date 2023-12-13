<?php

declare(strict_types=1);

namespace App\Models;

class TestSearchProvider implements SearchProviderInterface
{
    public const NAME = 'test';

    public function enable(): bool
    {
        return (bool) env('TEST_SEARCH_PROVIDER');
    }

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

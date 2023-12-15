<?php

declare(strict_types=1);

namespace App\Models\SearchProviders;

class TestSearchProvider extends AbstractSearchProvider implements SearchProviderInterface
{
    public const NAME = 'test';

    public function enable(): bool
    {
        return (bool)\env('TEST_SEARCH_PROVIDER');
    }

    public function getComments(string $phone): array
    {
        return [
            'test 1',
            'test 2',
        ];
    }
}

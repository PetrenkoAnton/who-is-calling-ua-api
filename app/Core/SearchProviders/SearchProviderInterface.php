<?php

declare(strict_types=1);

namespace App\Core\SearchProviders;

interface SearchProviderInterface
{
    public function enable(): bool;

    public function getName(): string;

    public function getComments(string $phone): array;
}
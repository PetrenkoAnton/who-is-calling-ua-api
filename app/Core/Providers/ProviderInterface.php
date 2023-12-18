<?php

declare(strict_types=1);

namespace App\Core\Providers;

interface ProviderInterface
{
    public function enable(): bool;

    public function getName(): string;

    public function getCode(): string;

    public function getComments(string $phone): array;
}

<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\ProviderEnum;
use Collection\Collectable;

interface ProviderInterface extends Collectable
{
    public function getEnum(): ProviderEnum;

    public function enable(): bool;

    /**
     * @return array<string>
     */
    public function getComments(string $phone): array;

    public function getUrl(string $phone): string;
}

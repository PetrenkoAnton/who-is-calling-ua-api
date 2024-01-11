<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\ProviderEnum;
use Collection\Collectable;

interface ProviderInterface extends Collectable
{
    public static function getEnum(): ProviderEnum;

    public function enable(): bool;

    public function getComments(string $phone): array;

    public function getUrl(string $phone): string;
}

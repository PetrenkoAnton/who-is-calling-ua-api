<?php

declare(strict_types=1);

namespace App\Core\Dto;

use Dto\Dto as BaseDto;
use Dto\KeyCase;
use Illuminate\Contracts\Support\Arrayable;

class Dto extends BaseDto implements Arrayable
{
    public function toArray(KeyCase $keyCase = KeyCase::CAMEL_CASE): array
    {
        return parent::toArray($keyCase);
    }
}

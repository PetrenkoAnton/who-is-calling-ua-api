<?php

declare(strict_types=1);

namespace App\Core\Dto;

class InfoDtoFactory
{
    public function create(array $data): InfoDto
    {
        return new InfoDto($data);
    }
}

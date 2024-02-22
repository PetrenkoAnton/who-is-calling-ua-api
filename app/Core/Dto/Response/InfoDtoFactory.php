<?php

declare(strict_types=1);

namespace App\Core\Dto\Response;

class InfoDtoFactory
{
    /**
     * @param array{version: string, providers: string[], supportedCodes: int[]} $data
     */
    public function create(array $data): InfoDto
    {
        return new InfoDto($data);
    }
}

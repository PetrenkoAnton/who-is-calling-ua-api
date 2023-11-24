<?php
declare(strict_types=1);

namespace App\Services;

class SearchService
{
    public function search(string $number): array
    {
        return [
            'phone' => $number,
            'status' => 123,
        ];
    }
}

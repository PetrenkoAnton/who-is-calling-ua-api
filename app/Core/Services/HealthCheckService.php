<?php

declare(strict_types=1);

namespace App\Core\Services;

use Illuminate\Support\Facades\Cache;

use function time;

class HealthCheckService
{
    public const KEY = 'health-check';

    public function check(): bool
    {
        return $this->checkCache();
    }

    private function checkCache(): bool
    {
        $input = time();

        Cache::put(self::KEY, $input);

        return $input === (int) Cache::pull(self::KEY);
    }
}

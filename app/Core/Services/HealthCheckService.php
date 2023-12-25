<?php

declare(strict_types=1);

namespace App\Core\Services;

use Illuminate\Support\Facades\Cache;

class HealthCheckService
{
    public function check(): bool
    {
        return $this->checkCache();
    }

    private function checkCache(): bool
    {
        $key = 'health-check';
        $input = time();

        Cache::put($key, $input);

        return $input === (int)Cache::pull($key);
    }
}

<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @var array<string>
     */
    protected $commands = [];

    /**
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    }
}

<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\KeyGenerateCommand;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @var string[] $commands
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $commands = [
        KeyGenerateCommand::class,
    ];
}

<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function env;
use function file_get_contents;
use function file_put_contents;
use function preg_quote;
use function preg_replace;
use function sprintf;

class KeyGenerateCommand extends Command
{
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
    protected $signature = 'key:generate';
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
    protected $description = 'Set the APP_KEY';

    public function handle(): void
    {
        $key = Str::random(32);

        file_put_contents($this->laravel->basePath('.env'), preg_replace(
            $this->keyReplacementPattern(),
            'APP_KEY=' . $key,
            (string) file_get_contents($this->laravel->basePath('.env')),
        ));

        $this->info("Application key [$key] set successfully.");
    }

    private function keyReplacementPattern(): string
    {
        $escaped = preg_quote('=' . env('APP_KEY'), '/');

        return sprintf('/^APP_KEY%s/m', $escaped);
    }
}

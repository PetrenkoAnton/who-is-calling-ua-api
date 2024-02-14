<?php

declare(strict_types=1);

namespace Tests\Support;

use function rename;
use function sprintf;

class VersionRenameHelper
{

    private const PATH = '/../../';
    private const VERSION = 'VERSION';
    private const VERSION_RENAME = 'VERSION_RENAME';

    public static function rename(): void
    {
        $path = __DIR__ . self::PATH . self::VERSION;

        is_file($path)
            ? rename($path, self::VERSION_RENAME)
            : die(sprintf('Invalid path for %s file: %s', $path));
    }

    public static function rollback(): void
    {
        $path = __DIR__ . self::PATH . self::VERSION_RENAME;

        if (is_file($path)) {
            rename($path, self::VERSION);
        }
    }
}

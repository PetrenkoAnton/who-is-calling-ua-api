<?php

declare(strict_types=1);

namespace App\Core\Dto\Response;

use App\Core\Dto\Dto;
use Dto\KeyCase;

/**
 * @method string getVersion()
 * @method string[] getProviders()
 * @method int[] getSupportedCodes()
 */
class InfoDto extends Dto
{
    protected string $version;
    /**
     * @var string[]
     */
    protected array $providers;
    /**
     * @var int[]
     */
    protected array $supportedCodes;

    public function toArray(KeyCase $keyCase = KeyCase::SNAKE_CASE): array
    {
        return parent::toArray($keyCase);
    }
}

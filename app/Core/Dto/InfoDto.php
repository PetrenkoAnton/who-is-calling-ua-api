<?php

declare(strict_types=1);

namespace App\Core\Dto;

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
}

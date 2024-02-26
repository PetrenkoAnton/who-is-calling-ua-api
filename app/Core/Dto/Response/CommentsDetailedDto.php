<?php

declare(strict_types=1);

namespace App\Core\Dto\Response;

use App\Core\Dto\Dto;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoCollection;

/**
 * @method string getPn()
 * @method string[] getComments()
 * @method ProviderDtoCollection getProviders()
 */
class CommentsDetailedDto extends Dto
{
    protected string $pn;
    /**
     * @var string[]
     */
    protected array $comments;
    protected ProviderDtoCollection $providers;
}

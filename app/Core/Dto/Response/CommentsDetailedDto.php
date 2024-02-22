<?php

declare(strict_types=1);

namespace App\Core\Dto\Response;

use App\Core\Dto\Dto;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoCollection;
use Dto\KeyCase;

/**
 * @method string getPn()
 * @method bool isCache()
 * @method string[] getComments()
 * @method ProviderDtoCollection getProviders()
 */
class CommentsDetailedDto extends Dto
{
    protected string $pn;
    protected bool $cache;
    /**
     * @var string[]
     */
    protected array $comments;
    protected ProviderDtoCollection $providers;

    public function toArray(KeyCase $keyCase = KeyCase::SNAKE_CASE): array
    {
        return parent::toArray($keyCase);
    }
}

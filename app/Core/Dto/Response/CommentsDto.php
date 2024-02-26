<?php

declare(strict_types=1);

namespace App\Core\Dto\Response;

use App\Core\Dto\Dto;

/**
 * @method string getPn()
 * @method bool isCache()
 * @method string[] getComments()
 */
class CommentsDto extends Dto
{
    protected string $pn;
    protected bool $cache;
    /**
     * @var string[]
     */
    protected array $comments;
}

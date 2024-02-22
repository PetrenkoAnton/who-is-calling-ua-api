<?php

declare(strict_types=1);

namespace App\Core\Dto\Response\CommentsDetailedDto;

use App\Core\Dto\Dto;

/**
 * @method string getName()
 * @method string getUrl()
 * @method string getCode()
 * @method string[] getComments()
 */
class ProviderDto extends Dto
{
    protected string $name;
    protected string $url;
    protected string $code;
    /**
     * @var string[]
     */
    protected array $comments;
}

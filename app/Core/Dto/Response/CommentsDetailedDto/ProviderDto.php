<?php

declare(strict_types=1);

namespace App\Core\Dto\Response\CommentsDetailedDto;

use App\Core\Dto\Dto;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDto\ErrorDto;

/**
 * @method string getName()
 * @method string getUrl()
 * @method string getCode()
 * @method string[] getComments()
 * @method ErrorDto|null getError()
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
    protected ?ErrorDto $error;
}

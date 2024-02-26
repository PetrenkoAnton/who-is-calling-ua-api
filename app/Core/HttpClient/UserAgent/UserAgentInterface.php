<?php

declare(strict_types=1);

namespace App\Core\HttpClient\UserAgent;

interface UserAgentInterface
{
    public function getValue(): string;
}

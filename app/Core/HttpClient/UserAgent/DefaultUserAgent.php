<?php

declare(strict_types=1);

namespace App\Core\HttpClient\UserAgent;

class DefaultUserAgent implements UserAgentInterface
{
    public function __construct(private readonly ?string $agent = null)
    {

    }

    public function getAgent(): string
    {
        return $this->agent 
            ?? env('DEFAULT_USER_AGENT', 'Mozilla/5.0 (Linux; Android 13; SM-G998B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/537.36');
    }
}

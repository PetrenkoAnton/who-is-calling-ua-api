<?php

declare(strict_types=1);

namespace App\Core\HttpClient\UserAgent;

use function array_rand;
use function config;
use function getenv;

class DefaultUserAgent implements UserAgentInterface
{
    public function getValue(): string
    {
        $defaultUserAgent = getenv('DEFAULT_USER_AGENT', false);

        $availableUserAgents = config('user_agent.available');
        $randomUserAgent = $availableUserAgents[array_rand($availableUserAgents, 1)];

        return getenv('USE_RANDOM_USER_AGENT', false) ? $randomUserAgent : $defaultUserAgent;
    }
}

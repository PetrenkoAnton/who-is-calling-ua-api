<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\HttpClient\UserAgent\DefaultUserAgent;
use Tests\TestCase;

class DefaultUserAgentTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dpTestGetValue
     */
    public function testGetValue(string $useRandomUserAgent, string $defaultUserAgent): void
    {
        putenv('USE_RANDOM_USER_AGENT=' . $useRandomUserAgent);
        putenv('DEFAULT_USER_AGENT=' . $defaultUserAgent);

        $this->assertEquals((bool)$useRandomUserAgent, getenv('USE_RANDOM_USER_AGENT'));

        $userAgent = $this->app->make(DefaultUserAgent::class);

        if ((bool)$useRandomUserAgent) {
            $this->assertContains($userAgent->getValue(), config('user_agent.available'));
            $this->assertNotContains($defaultUserAgent, config('user_agent.available'));
        } else {
            $this->assertEquals($defaultUserAgent, $userAgent->getValue());
        }
    }

    public static function dpTestGetValue(): array
    {
        return [
            [
                '0',
                // No current value in config('user_agent.available')
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.3',
            ],
            [
                '0',
                // No current value in config('user_agent.available')
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:102.0) Gecko/20100101 Firefox/102.',
            ],
            [
                '1',
                // No current value in config('user_agent.available')
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.3',
            ],
            [
                '1',
                // No current value in config('user_agent.available'
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:102.0) Gecko/20100101 Firefox/102.',
            ],
        ];
    }
}

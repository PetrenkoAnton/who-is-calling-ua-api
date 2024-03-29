<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\HttpClient\UserAgent\DefaultUserAgent;
use Tests\TestCase;

use function config;
use function getenv;
use function putenv;

class DefaultUserAgentTest extends TestCase
{
    public function tearDown(): void
    {
        putenv('USE_RANDOM_USER_AGENT=1');
        // phpcs:ignore
        putenv('DEFAULT_USER_AGENT=Mozilla/5.0 (Linux; Android 13; SM-G998B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/537.36');

        parent::tearDown();
    }

    /**
     * @group ok
     * @dataProvider dpTestGetValue
     */
    public function testGetValue(string $useRandomUserAgent, string $defaultUserAgent): void
    {
        putenv('USE_RANDOM_USER_AGENT=' . $useRandomUserAgent);
        putenv('DEFAULT_USER_AGENT=' . $defaultUserAgent);

        $this->assertEquals((bool) $useRandomUserAgent, getenv('USE_RANDOM_USER_AGENT'));

        $userAgent = $this->app->make(DefaultUserAgent::class);

        if ((bool) $useRandomUserAgent) {
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
                // phpcs:ignore
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
                // phpcs:ignore
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

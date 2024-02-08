<?php

declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Formatters\OutputPNFormatter;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\ProviderInterface;
use App\Core\Services\Internal\CommentsService;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

class SearchService
{
    public function __construct(
        private readonly ProviderCollection $searchProviders,
        private readonly OutputPNFormatter $formatter,
        private CommentsService $commentsService,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function search(string $phone, bool $useCache = true): array
    {
        if (!$useCache) {
            Cache::delete($phone);
        }

        if ($cache = Cache::has($phone)) {
            $data = Cache::get($phone);
        } else {
            $providers = [];

            foreach ($this->searchProviders->getEnabled()->getItems() as $provider) {
                /** @var ProviderInterface $provider */

                $comments = [];
                $err = null;

                try {
                    $this->commentsService->addComments(($comments = $provider->getComments($phone)));
                    // TODO! Temporary error handler.
                } catch (RuntimeException $e) {
                    $err = [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                    ];
                }

                $providers[] = [
                    'name' => $provider->getEnum()->value,
                    'url' => $provider->getUrl($phone),
                    'code' => $provider->getEnum()->name,
                    'comments' => $comments,
                    'err' => $err,
                ];
            }

            $data = ['comments' => $this->commentsService->getUniqueComments()] + ['providers' => $providers];

            Cache::set($phone, $data);
        }

        return [
            'pn' => $this->formatter->format($phone),
            'cache' => $cache,
        ] + $data;
    }
}

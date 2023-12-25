<?php

declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Formatters\OutputPNFormatter;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\ProviderInterface;
use App\Core\CommentsService\CommentsServiceInterface;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\ArrayShape;

class SearchService
{
    public function __construct(
        private readonly ProviderCollection $searchProviders,
        private readonly OutputPNFormatter $formatter,
        private CommentsServiceInterface $commentsService,
    )
    {
    }

    #[ArrayShape(['pn' => "string", 'providers' => "array", 'cache' => "bool"])]
    public function search(string $pn, bool $useCache = true,): array
    {
        if (!$useCache)
            Cache::delete($pn);

        if ($cache = Cache::has($pn)) {
            $data = Cache::get($pn);
        } else {
            $providers = [];

            foreach ($this->searchProviders->getEnabled()->getItems() as $provider) {
                /** @var ProviderInterface $provider */

                $comments = [];
                $err = [];

                try {
                    $this->commentsService->addComments(($comments = $provider->getComments($pn)));
                    // TODO! Temporary error handler.
                } catch (\RuntimeException $e) {
                    $err = ['err' => $e->getMessage()];
                }

                $providers[] = [
                        'name' => $provider->getEnum()->value,
                        'url' => $provider->getUrl($pn),
                        'code' => $provider->getEnum()->name,
                        'comments' => $comments,
                    ] + $err;
            }

            $data = ['comments' => $this->commentsService->getUniqueComments()] + ['providers' => $providers];

            Cache::set($pn, $data);
        }

        return [
                'pn' => $this->formatter->format($pn),
                'cache' => $cache,
            ] + $data;
    }
}

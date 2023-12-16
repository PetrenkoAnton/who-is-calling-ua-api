<?php

declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Formatters\OutputPNFormatter;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\ProviderInterface;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\ArrayShape;

class SearchService
{
    public function __construct(
        private readonly ProviderCollection $searchProviders,
        private readonly OutputPNFormatter $formatter,
    )
    {
    }

    #[ArrayShape(['pn' => "string", 'providers' => "array", 'c' => "bool"])]
    public function search(string $phone, bool $useCache = true): array
    {
        if (!$useCache)
            Cache::delete($phone);

        if ($c = Cache::has($phone)) {
            $providers = Cache::get($phone);
        } else {
            $providers = [];

            foreach ($this->searchProviders->getEnabled()->getItems() as $provider) {
                /** @var ProviderInterface $provider */

                $comments = [];
                $err = [];

                try {
                    $comments = $provider->getComments($phone);
                    // TODO! Temporary error handler.
                } catch (\RuntimeException $e) {
                    $err = ['err' => $e->getMessage()];
                }

                $providers[] = [
                        'name' => $provider->getName(),
                        'comments' => $comments,
                    ] + $err;
            }

            Cache::set($phone, $providers);
        }

        return [
            'pn' => $this->formatter->format($phone),
            'providers' => $providers,
            'c' => $c,
        ];
    }
}

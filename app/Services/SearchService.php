<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\OutputPhoneNumberFormatter;
use App\Models\SearchProviderCollection;
use App\Models\SearchProviderInterface;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\ArrayShape;

class SearchService
{
    public function __construct(
        private readonly SearchProviderCollection $searchProviders,
        private readonly OutputPhoneNumberFormatter $formatter,
    )
    {
    }

    #[ArrayShape(['phone' => "string", 'providers' => "array", 'from_cache' => "bool"])]
    public function search(string $phone, bool $useCache = true): array
    {
        if (!$useCache)
            Cache::delete($phone);

        if ($fromCache = Cache::has($phone)) {
            $providers = Cache::get($phone);
        } else {
            $providers = [];

            foreach ($this->searchProviders->getEnabled()->getItems() as $provider)
                /** @var SearchProviderInterface $provider */
                $providers[] = [
                    'provider' => $provider->getName(),
                    'comments' => $provider->getComments($phone),
                ];

            Cache::set($phone, $providers);
        }

        return [
            'phone' => $this->formatter->format($phone),
            'providers' => $providers,
            'from_cache' => $fromCache,
        ];
    }
}

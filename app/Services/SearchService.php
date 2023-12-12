<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\SearchProviderInterface;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\ArrayShape;

class SearchService
{
    public function __construct(private readonly SearchProviderInterface $searchProvider)
    {
    }

    #[ArrayShape(['phone' => "string", 'providers' => "array", 'from_cache' => "bool"])]
    public function search(string $phone, bool $useCache = true): array
    {
        if (!$useCache)
            Cache::delete($phone);

        if ($fromCache = Cache::has($phone)) {
            $comments = Cache::get($phone);
        } else {
            $comments = $this->searchProvider->getComments($phone);
            Cache::set($phone, $comments);
        }

        return [
            'phone' => $phone,
            'providers' => [
                [
                    'provider' => $this->searchProvider->getName(),
                    'comments' => $comments,
                ],
            ],
            'from_cache' => $fromCache,
        ];
    }
}

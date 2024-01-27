<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Core\Services\SearchService;
use App\Core\Validators\PNRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class SearchController extends Controller
{
    public function __construct(
        private readonly SearchService $service,
        private readonly PNRule $phoneRule,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function search(Request $request): array
    {
        $this->validate($request, [
            'c' => 'boolean',
            'pn' => ['required', $this->phoneRule],
        ]);

        $c = !$request->has('c') || $request->get('c');

        return $this->service->search((string)$request->get('pn'), $c);
    }
}

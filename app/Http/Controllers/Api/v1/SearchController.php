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

    public function search(Request $request): JsonResponse
    {
        $this->validate($request, [
            'c' => 'boolean',
            'pn' => ['required', $this->phoneRule],
        ]);

        $c = !$request->has('c') || $request->get('c');

        return \response()->json($this->service->search((string)$request->get('pn'), $c));
    }
}

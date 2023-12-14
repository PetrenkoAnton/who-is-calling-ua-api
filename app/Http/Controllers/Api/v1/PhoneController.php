<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Rules\PhoneRule;
use App\Services\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class PhoneController extends Controller
{
    public function __construct(
        private readonly SearchService $service,
        private readonly PhoneRule $phoneRule,
    ) {}

    public function search(Request $request): JsonResponse
    {
        $this->validate($request, [
            'c' => 'boolean',
            'p' => ['required', $this->phoneRule],
        ]);

        $c = !$request->has('c') || (bool) $request->get('c');

        return \response()->json($this->service->search((string) $request->get('p'), $c));
    }
}

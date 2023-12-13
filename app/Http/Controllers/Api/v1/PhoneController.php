<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Services\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class PhoneController extends Controller
{
    public function __construct(
        private readonly SearchService $service,
    ) {}

    public function search(Request $request): JsonResponse
    {
        $this->validate($request, [
            'c' => 'boolean',
            'phone' => 'required|numeric|min:440000001|max:999999999'
        ]);

        $c = !$request->has('c') || (bool) $request->get('c');

        return \response()->json($this->service->search((string) $request->get('phone'), $c));
    }
}

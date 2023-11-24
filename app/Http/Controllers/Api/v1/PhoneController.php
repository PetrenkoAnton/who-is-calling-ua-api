<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

class PhoneController extends Controller
{
    public function get(string $number): JsonResponse
    {
        return \response()->json(['phone' => $number]);
    }
}

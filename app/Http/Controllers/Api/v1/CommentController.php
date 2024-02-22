<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Core\Dto\Response\CommentsDetailedDto;
use App\Core\Dto\Response\CommentsDto;
use App\Core\Services\CommentService;
use App\Core\Validators\PNRule;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

/**
 * @codeCoverageIgnore
 */
class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $service,
        private readonly PNRule $phoneRule,
    ) {
    }

    public function index(Request $request): CommentsDto
    {
        $this->validate($request, [
            'c' => 'boolean',
            'pn' => ['required', $this->phoneRule],
        ]);

        $c = !$request->has('c') || $request->get('c');

        return $this->service->search((string) $request->get('pn'), $c);
    }

    public function detailed(Request $request): CommentsDetailedDto
    {
        $this->validate($request, [
            'pn' => ['required', $this->phoneRule],
        ]);

        return $this->service->detailedSearch((string) $request->get('pn'));
    }
}

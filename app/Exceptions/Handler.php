<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

use function json_decode;

class Handler extends ExceptionHandler
{
    /**
     * @var array<string>
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    // phpcs:ignore SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
    public function render($request, Throwable $exception): JsonResponse
    {
        $rendered = parent::render($request, $exception);

        $error = $rendered ? json_decode($rendered->content()) : $exception->getMessage();
        $code = $rendered ? $rendered->getStatusCode() : $exception->getCode();

        return new JsonResponse(
            [
                'error' => $error,
                'code' => $code,
            ],
            $code,
        );
    }
}

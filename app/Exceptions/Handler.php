<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

use function array_keys;
use function array_map;
use function array_values;
use function getenv;

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
        switch ($exception) {
            case $exception instanceof NotFoundHttpException:
                $message = 'Not Found';
                $code = 404;

                break;
            case $exception instanceof ValidationException:
                $message = [
                    'validation' => array_map(fn ($key, $messages) => [
                        'attribute' => $key,
                        'info' => $messages[0] ?? 'No info',
                    ], array_keys($exception->errors()), array_values($exception->errors())),
                ];
                $code = 422;

                break;
            default:
                $message = getenv('APP_DEBUG', true)
                    ? $exception->getMessage()
                    : 'Internal Server Error';
                $code = 500;

                break;
        }

        $data = [
            'error' => $message,
            'code' => $code,
        ];

        return new JsonResponse(
            data: $data,
            status: $code,
            headers: ['Content-Type' => 'application/json'],
        );
    }
}

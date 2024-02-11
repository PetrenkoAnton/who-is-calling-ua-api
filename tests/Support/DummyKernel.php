<?php

declare(strict_types=1);

namespace Codeception\Lib\Connector\Lumen;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Dummy kernel to satisfy the parent constructor of the LumenConnector class.
 */
class DummyKernel implements HttpKernelInterface
{
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true): Response
    {
        //
    }
}

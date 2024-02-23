<?php

declare(strict_types=1);

/**
 * @api {get} /api/v1/unsupported Common errors
 * @apiVersion 1.0.0
 * @apiName Common errors
 * @apiDescription Common errors
 * @apiGroup errors
 *
 * @apiErrorExample {json} Not Found:
 * HTTP/1.1 404 Not Found
 * {
 *   "error": "Not found",
 *   "code": 404,
 * }
 *
 * @apiErrorExample {json} Internal Server Error:
 * HTTP/1.1 500 Internal Server Error
 * {
 *   "error": "Internal Server Error",
 *   "code": 500,
 * }
 */

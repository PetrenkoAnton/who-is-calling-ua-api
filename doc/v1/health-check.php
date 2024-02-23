<?php

declare(strict_types=1);

/**
 * @api {get} /api/v1/health-check health-check
 * @apiVersion 1.0.0
 * @apiName Get health-check
 * @apiDescription health-check
 * @apiGroup health-check
 *
 * @apiSuccessExample {json} Success result:
 * HTTP/1.1 200 OK
 * {
 *   "health-check": "success"
 * }
 *
 * @apiErrorExample {json} Failed result:
 * HTTP/1.1 500 Internal Server Error
 * {
 *   "health-check": "fail"
 * }
 */

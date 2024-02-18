<?php

declare(strict_types=1);

/**
 * @api {get} /api/v1/search Get comments
 * @apiVersion 1.0.0
 * @apiName Get comments
 * @apiDescription Get comments
 * @apiGroup search
 *
 * @apiQuery {Number{440000001-999999999}} phone Phone number (pn)
 * @apiQuery {Number=0,1} [c] Cache
 *
 * @apiSuccessExample {json} Success result:
 *     HTTP/1.1 200 OK
 *     {
 *       "pn": "067 000-00-01",
 *       "cache": false,
 *       "comments": [],
 *       "providers": []
 *     }
 */

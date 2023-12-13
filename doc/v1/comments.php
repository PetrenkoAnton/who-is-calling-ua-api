<?php

declare(strict_types=1);

/**
 * @api {get} /api/v1/phone/:phone Get comments
 * @apiVersion 1.0.0
 * @apiName Get comments
 * @apiDescription Get comments
 * @apiGroup Get comments
 *
 * @apiParam {Number{440000001-999999999}} phone Phone number
 * @apiQuery {Number=0,1} [c] Cache
 *
 * @apiSuccessExample {json} Success result:
 *     HTTP/1.1 200 OK
 *     {
 *       "phone": "0670000001",
 *       "providers": []
 *     }
 *
 * @apiSuccessExample {json} No providers:
 *     HTTP/1.1 200 OK
 *     {
 *       "phone": "0670000001",
 *       "providers": []
 *     }
 */

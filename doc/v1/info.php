<?php

declare(strict_types=1);

/**
 * @api {get} /api/v1/info [GET] info
 * @apiVersion 1.0.0
 * @apiName Get info
 * @apiDescription Get info
 * @apiGroup info
 *
 * @apiSuccessExample {json} Success result:
 * HTTP/1.1 200 OK
 * {
 *   "version": "1.0.0",
 *   "providers": [
 *     "callfilter.app",
 *     "callinsider.com.ua",
 *     "kto-zvonil.com.ua",
 *     "ktozvonil.net",
 *     "slick.ly",
 *     "telefonnyjdovidnyk.com.ua"
 *   ],
 *   "supported_codes": [
 *     44,
 *     50,
 *     63,
 *     66,
 *     67,
 *     68,
 *     73,
 *     93,
 *     95,
 *     96,
 *     97,
 *     98,
 *     99
 *   ]
 * }
 */

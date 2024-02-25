# who-is-calling-ua-api

[![PHP Version](https://img.shields.io/packagist/php-v/petrenkoanton/who-is-calling-ua-api)](https://packagist.org/packages/petrenkoanton/who-is-calling-ua-api)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/petrenkoanton/who-is-calling-ua-api.svg)](https://packagist.org/packages/petrenkoanton/who-is-calling-ua-api)
[![Total Downloads](https://img.shields.io/packagist/dt/petrenkoanton/who-is-calling-ua-api.svg)](https://packagist.org/packages/petrenkoanton/who-is-calling-ua-api)
[![License](https://img.shields.io/packagist/l/petrenkoanton/who-is-calling-ua-api)](https://packagist.org/packages/petrenkoanton/who-is-calling-ua-api)

[![PHP Composer](https://github.com/petrenkoanton/who-is-calling-ua-api/actions/workflows/tests.yml/badge.svg)](https://github.com/petrenkoanton/who-is-calling-ua-api/actions/workflows/tests.yml)
[![Coverage Status](https://coveralls.io/repos/github/PetrenkoAnton/who-is-calling-ua-api/badge.svg?branch=main)](https://coveralls.io/github/PetrenkoAnton/who-is-calling-ua-api?branch=main)
[![type-coverage](https://shepherd.dev/github/petrenkoanton/who-is-calling-ua-api/coverage.svg)](https://shepherd.dev/github/petrenkoanton/who-is-calling-ua-api)
[![PHPStan Level 8](https://img.shields.io/badge/PHPStan-Level%208-brightgreen)](https://github.com/petrenkoanton/who-is-calling-ua-api)
[![Build Status](https://github.com/petrenkoanton/who-is-calling-ua-api/workflows/coding-style/badge.svg)](https://github.com/petrenkoanton/who-is-calling-ua-api/actions)

[Installation](#installation) | [Functionality](#functionality) | [Usage](#usage) | | [For developers](#for-developers) | [License](#license) | [Related projects](#related-projects)

## Installation

### Requirements

Utils:
- make
- [docker-compose](https://docs.docker.com/compose/gettingstarted)

### Setup

```bash
make init
```

### Default values

From [.env.example](./.env.example):
```dotenv
APP_PORT=8080

USE_RANDOM_USER_AGENT=1
DEFAULT_USER_AGENT='Mozilla/5.0 (Linux; Android 13; SM-G998B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/537.36'

# callfilter.app
CF_PROVIDER=1
# callinsider.com.ua
CI_PROVIDER=1
# kto-zvonil.com.ua
KC_PROVIDER=1
# ktozvonil.net
KZ_PROVIDER=1
# slick.ly
SL_PROVIDER=1
# telefonnyjdovidnyk.com.ua
TD_PROVIDER=1
```

### Close app
```bash
make down
```

## Functionality

### Providers

[ProviderEnum](./app/Core/ProviderEnum.php)

| Url                                                                  | Internal Code |
|:---------------------------------------------------------------------|:-------------:|
| [callfilter.app](https://callfilter.app/)                            |      CF       |
| [callinsider.com.ua](https://www.callinsider.com.ua/)                |      CL       |
| [kto-zvonil.com.ua](http://kto-zvonil.com.ua/)                       |      KC       |
| [ktozvonil.net](https://ktozvonil.net/)                              |      KZ       |
| [slick.ly](https://slick.ly/)                                        |      SL       |
| [telefonnyjdovidnyk.com.ua](https://www.telefonnyjdovidnyk.com.ua/)  |      TD       |

### Supported phone number codes

[config](./config/pn.php)

| Providers | Codes              |
|:----------|:-------------------|
| Vodafone  | 50, 66, 95, 99     |
| lifecell  | 63, 73, 93         |
| kyivstar  | 67, 68, 96, 97, 98 |
| etc       | 44                 |

## Usage

### apidoc

[localhost:8080/doc](http://localhost:8080/doc/index.html)

### Postman collection

[collection.json](who-is-calling-ua-api-local.postman_collection.json)

### Short examples

Request:

**[GET]** http://localhost:8080/api/v1/comments?pn=672341456&c=0

Response:
```json
{
    "pn": "044 355-15-91",
    "cache": false,
    "comments": [
        "Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.",
        "ушасили",
        "Робот-шахрай спокушає призом",
        "виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)",
        "(програвалася запис / робот)",
        "програвався запис (програвалася запис / робот)",
        "так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)",
        "Говорив молодий чоловік, стандартні фрази - комп'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. \r Однозначно шахраї. (програвалася запис / робот)",
        "Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)"
    ]
}
```

---

Request:

**[GET]** http://localhost:8080/api/v1/comments_detailed?pn=672341456

Response:
```json
{
    "pn": "044 355-15-91",
    "comments": [
        "Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.",
        "ушасили",
        "Робот-шахрай спокушає призом",
        "мне тільки що дзвонили ЗАРАРИ сдохніть",
        "виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)",
        "(програвалася запис / робот)",
        "програвався запис (програвалася запис / робот)",
        "так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)",
        "Говорив молодий чоловік, стандартні фрази - комп'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. \r Однозначно шахраї. (програвалася запис / робот)",
        "Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)"
    ],
    "providers": [
        {
            "name": "telefonnyjdovidnyk.com.ua",
            "url": "https://www.telefonnyjdovidnyk.com.ua/nomer/0443551591",
            "code": "TD",
            "comments": [
                "Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.",
                "ушасили",
                "Робот-шахрай спокушає призом"
            ],
            "error": null
        },
        {
            "name": "ktozvonil.net",
            "url": "https://ktozvonil.net/nomer/0443551591",
            "code": "KZ",
            "comments": [

            ],
            "error": null
        },
        {
            "name": "callinsider.com.ua",
            "url": "https://www.callinsider.com.ua/ua/0443551591",
            "code": "CI",
            "comments": [
                "Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.",
                "ушасили",
                "Робот-шахрай спокушає призом",
                "мне тільки що дзвонили ЗАРАРИ сдохніть"
            ],
            "error": null
        },
        {
            "name": "slick.ly",
            "url": "https://slick.ly/ua/0443551591",
            "code": "SL",
            "comments": [

            ],
            "error": {
                "message": "Client error: `GET https://slick.ly/ua/0443551591` resulted in a `403 Forbidden` response:\nerror code: 1006\n",
                "code": 403
            }
        },
        {
            "name": "kto-zvonil.com.ua",
            "url": "http://kto-zvonil.com.ua/number/044/3551591",
            "code": "KC",
            "comments": [

            ],
            "error": null
        },
        {
            "name": "callfilter.app",
            "url": "https://callfilter.app/380443551591",
            "code": "CF",
            "comments": [
                "виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)",
                "(програвалася запис / робот)",
                "(програвалася запис / робот)",
                "програвався запис (програвалася запис / робот)",
                "так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)",
                "Говорив молодий чоловік, стандартні фрази - комп'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. \r Однозначно шахраї. (програвалася запис / робот)",
                "Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)"
            ],
            "error": null
        }
    ]
}
```

## For developers

### Run linters and tests
```bash
make check
```

### Go inside of the container
```bash
make inside
```

## License

The [who-is-calling-ua-api](https://github.com/PetrenkoAnton/who-is-calling-ua-api) project is open-sourced software licensed under the [MIT license](./LICENSE).

## Related projects

- [PetrenkoAnton/key-normalizer](https://github.com/PetrenkoAnton/key-normalizer)
- [PetrenkoAnton/php-collection](https://github.com/PetrenkoAnton/php-collection)
- [PetrenkoAnton/php-dto](https://github.com/PetrenkoAnton/php-dto)

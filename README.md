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

[Installation](#installation) | [Functionality](#functionality) | [Usage](#usage) | [License](#license) | [Related projects](#related-projects)

## Installation

## Functionality

## Usage

### Providers

[ProviderEnum.php](./app/Core/ProviderEnum.php)

| Url                       | Internal Code |
|:--------------------------|:-------------:|
| callfilter.app            |      CF       |
| callinsider.com.ua        |      CL       |
| kto-zvonil.com.ua         |      KC       |
| ktozvonil.net             |      KZ       |
| slick.ly                  |      SL       |
| telefonnyjdovidnyk.com.ua |      TD       |

### Supported phone number codes

[config/pn.php](./config/pn.php)

| Providers | Codes              |
|:----------|:-------------------|
| Vodafone  | 50, 66, 95, 99     |
| lifecell  | 63, 73, 93         |
| kyivstar  | 67, 68, 96, 97, 98 |
| etc       | 44                 |

## License

The [who-is-calling-ua-api](https://github.com/PetrenkoAnton/who-is-calling-ua-api) project is open-sourced software licensed under the [MIT license](./LICENSE).

## Related projects

- [PetrenkoAnton/key-normalizer](https://github.com/PetrenkoAnton/key-normalizer)
- [PetrenkoAnton/php-collection](https://github.com/PetrenkoAnton/php-collection)
- [PetrenkoAnton/php-dto](https://github.com/PetrenkoAnton/php-dto)

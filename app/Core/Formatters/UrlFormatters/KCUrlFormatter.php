<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

use function sprintf;
use function substr;

class KCUrlFormatter implements UrlFormatterInterface
{
    public function format(string $pn): string
    {
        $code = substr($pn, 0, 2);
        $num = substr($pn, 2, 7);

        return sprintf('http://kto-zvonil.com.ua/number/0%s/%s', $code, $num);
    }
}

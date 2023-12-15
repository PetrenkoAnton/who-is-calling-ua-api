<?php

declare(strict_types=1);

namespace App\Core\Formatters;

class OutputPhoneNumberFormatter
{
    public function format(string $phone): string
    {
        return sprintf('0%s %s-%s-%s',
            substr($phone, 0, 2),
            substr($phone, 2, 3),
            substr($phone, 5, 2),
            substr($phone, 7)
        );
    }
}

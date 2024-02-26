<?php

declare(strict_types=1);

namespace App\Core;

enum ProviderEnum: string
{
    case CF = 'callfilter.app';
    case CI = 'callinsider.com.ua';
    case KC = 'kto-zvonil.com.ua';
    case KZ = 'ktozvonil.net';
    case SL = 'slick.ly';
    case TD = 'telefonnyjdovidnyk.com.ua';

    /**
     * @return array<int,ProviderEnum>
     */
    public static function getAllExceptOne(ProviderEnum $except): array
    {
        $arr = self::cases();

        foreach ($arr as $k => $enum) {
            if ($enum === $except) {
                unset($arr[$k]);

                break;
            }
        }

        return $arr;
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Providers\ProviderCollection;

class InfoService
{
    public function __construct(private readonly ProviderCollection $providers)
    {
    }

    public function getInfo(): array
    {
        return [
            'version' => $this->getVersion(),
            'providers' => $this->getProviders(),
            'supported_codes' => $this->getSupportedCodes(),
        ];
    }

    private function getVersion(): string
    {
        return \trim(\file_get_contents(\realpath(__DIR__.'/../../../VERSION')));
    }

    private function getProviders(): array
    {
        $res = [];

        foreach ($this->providers->getEnabled()->getItems() as $provider)
            $res[] = $provider::getEnum()->value;

        \sort($res);

        return $res;
    }

    private function getSupportedCodes(): array
    {
        $codes = \config('pn.supported_codes');
        \sort($codes);

        return $codes;
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Providers\ProviderCollection;
use App\Core\Providers\ProviderInterface;
use App\Exceptions\Internal\InternalException;

use function config;
use function file_get_contents;
use function realpath;
use function sort;
use function trim;

class InfoService
{
    public function __construct(private readonly ProviderCollection $providers)
    {
    }

    /**
     * @return array{version:string,providers:array<string>,supported_codes:array<int>}
     */
    public function getInfo(): array
    {
        return [
            'version' => $this->getVersion(),
            'providers' => $this->getProviders(),
            'supported_codes' => $this->getSupportedCodes(),
        ];
    }

    /**
     * @throws InternalException
     */
    private function getVersion(): string
    {
        $file = realpath(__DIR__ . '/../../../VERSION')
            ?: throw new InternalException('VERSION file not found');
        $versionFileContent = file_get_contents($file)
            ?: throw new InternalException('Invalid VERSION file content');

        return trim($versionFileContent);
    }

    /**
     * @return array<string>
     */
    private function getProviders(): array
    {
        $res = [];

        foreach ($this->providers->getEnabled()->getItems() as $provider) {
            /** @var ProviderInterface $provider */
            $res[] = $provider->getEnum()->value;
        }

        sort($res);

        return $res;
    }

    /**
     * @return array<int>
     */
    private function getSupportedCodes(): array
    {
        $codes = config('pn.supported_codes');
        sort($codes);

        return $codes;
    }
}

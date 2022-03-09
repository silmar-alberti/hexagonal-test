<?php

declare(strict_types=1);

namespace App\Factories\Modules\DataLoader;

use App\Adapters\Modules\DataLoader\Repository\FindNfeAdapter;
use App\Exceptions\Modules\DataLoader\WrongEnvException;
use App\Factories\Http\SendRequestFactory;

final class FindNfeAdapterFactory
{
    private const ENV_VARS = [
        'ARQUIVEI_API_BASE_URI',
        'ARQUIVEI_API_ID',
        'ARQUIVEI_API_KEY',
    ];

    public static function create(): FindNfeAdapter
    {
        self::checkEnvVars();

        return new FindNfeAdapter(
            SendRequestFactory::create(),
            env('ARQUIVEI_API_BASE_URI', 'https://sandbox-api.arquivei.com.br'),
            env('ARQUIVEI_API_ID'),
            env('ARQUIVEI_API_KEY'),
        );
    }

    /**
     * @throws WrongEnvException
     */
    private static function checkEnvVars(): void
    {
        $notFoundVarKeys = [];
        foreach (self::ENV_VARS as $envKey) {
            if (null === env($envKey)) {
                $notFoundVarKeys[] = $envKey;
            }
        }
        if ([] !== $notFoundVarKeys) {
            throw new WrongEnvException("Some Environment vars must be defined: '" . implode(',', $notFoundVarKeys) . "'");
        }
    }
}

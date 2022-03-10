<?php

declare(strict_types=1);

namespace App\Factories\Modules\DataLoader;

use App\Adapters\Modules\DataLoader\FindExternalNfeAdapter;
use App\Exceptions\Modules\DataLoader\WrongEnvException;
use App\Factories\Http\SendRequestFactory;

final class FindExternalNfeAdapterFactory
{
    private const ENV_VARS = [
        'ARQUIVEI_API_BASE_URI',
        'ARQUIVEI_API_ID',
        'ARQUIVEI_API_KEY',
    ];

    public static function create(): FindExternalNfeAdapter
    {
        self::checkEnvVars();

        return new FindExternalNfeAdapter(
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
            throw new WrongEnvException(
                "Some Environment vars must be defined: '" . implode(',', $notFoundVarKeys) . "'"
            );
        }
    }
}

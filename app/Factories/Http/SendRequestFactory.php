<?php

declare(strict_types=1);

namespace App\Factories\Http;

use App\Dependencies\Http\Adapter\SendRequestAdapter;
use GuzzleHttp\Client;

class SendRequestFactory
{
    public static function create(): SendRequestAdapter
    {
        return new SendRequestAdapter(
            new Client([
                'timeout' => 60,
            ])
        );
    }
}

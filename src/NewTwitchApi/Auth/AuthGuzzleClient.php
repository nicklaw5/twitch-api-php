<?php

declare(strict_types=1);

namespace NewTwitchApi\Auth;

use GuzzleHttp\Client;

class AuthGuzzleClient
{
    private const BASE_URI = 'https://id.twitch.tv/oauth2/';

    public static function getClient(array $config = []): Client
    {
        return new Client($config + [
            'base_uri' => self::BASE_URI,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;

class HelixGuzzleClient
{
    private const BASE_URI = 'https://api.twitch.tv/helix/';

    public static function getClient(string $clientId, array $config = []): Client
    {
        return new Client($config + [
            'base_uri' => self::BASE_URI,
            'timeout' => 30,
            'headers' => ['Client-ID' => $clientId, 'Content-Type' => 'application/json'],
        ]);
    }
}

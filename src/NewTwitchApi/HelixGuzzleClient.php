<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;

class HelixGuzzleClient extends Client
{
    const BASE_URI = 'https://api.twitch.tv/helix/';

    public function __construct(string $clientId, array $config = [])
    {
        parent::__construct($config + [
            'base_uri' => self::BASE_URI,
            'timeout' => 30,
            'headers' => [
                'Client-ID' => $clientId,
                'Content-Type' => 'application/json'
            ]
        ]);
    }
}

<?php

declare(strict_types=1);

namespace NewTwitchApi\Auth;

use GuzzleHttp\Client;

class AuthGuzzleClient extends Client
{
    private const BASE_URI = 'https://id.twitch.tv/oauth2/';

    /**
     * AuthGuzzleClient constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config + [
            'base_uri' => self::BASE_URI,
        ]);
    }
}

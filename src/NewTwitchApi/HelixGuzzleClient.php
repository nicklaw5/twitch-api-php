<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;

class HelixGuzzleClient
{
    private $client;
    private const BASE_URI = 'https://api.twitch.tv/helix/';

    public function __construct(string $clientId, array $config = [], string $baseUri = null)
    {
        if ($baseUri === null) {
            $baseUri = self::BASE_URI;
        }

        $headers = [
          'Client-ID' => $clientId,
        ];

        $this->client = new Client([
            'base_uri' => $baseUri,
            'headers' => $headers,
            'Accept' => 'application/json',
        ]);
    }

    public static function getClient(string $clientId, array $config = []): Client
    {
        return $this->client;
    }

    public function send($request)
    {
        return $this->client->send($request);
    }
}

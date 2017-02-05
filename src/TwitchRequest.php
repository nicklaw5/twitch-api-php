<?php

namespace TwitchApi;

use GuzzleHttp\Client;

class TwitchRequest
{
    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';

    /**
     * @var string
     */
    protected $baseUri = 'https://api.twitch.tv/kraken/';

    /**
     * @var float
     */
    protected $timeout = 5.0;

    /**
     * Send the request
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     * @param bool   $attachAccessToken
     * @return array
     */
    protected function sendRequest($method, $endpoint, $params = [], $accessToken = null)
    {
        $client = $this->getNewHttpClient($params, $accessToken);
        $response = $client->request($method, $endpoint);

        return json_decode($response->getBody(), true);
    }

    /**
     * Get a new HTTP Client
     *
     * @param array $params
     * @param string $accessToken
     * @return Client
     */
    protected function getNewHttpClient($params, $accessToken = null)
    {
        $config = [
            'base_uri' => $this->baseUri,
            'timeout' => $this->getTimeout(),
            'headers' => [
                'Client-ID' => $this->getClientId(),
                'Accept' => sprintf('application/vnd.twitchtv.v%d+json', $this->getApiVersion()),
            ],
        ];

        if ($accessToken) {
            $config['headers']['Authorization'] = sprintf('OAuth %s', $accessToken);
        }

        if (!empty($params)) {
            $config['json'] = $params;
        }

        return new Client($config);
    }

    /**
     * Send a GET request
     *
     * @param string $endpoint
     * @param array  $params
     * @param bool   $$attachAccessToken
     * @return array
     */
    protected function get($endpoint, $params = [], $accessToken = null)
    {
        return $this->sendRequest(self::GET_METHOD, $endpoint, $params, $accessToken);
    }

    /**
     * Send a POST request
     *
     * @param string $endpoint
     * @param array  $params
     * @param bool   $attachAccessToken
     * @return array
     */
    protected function post($endpoint, $params = [], $accessToken = null)
    {
        return $this->sendRequest(self::POST_METHOD, $endpoint, $params, $accessToken);
    }

    /**
     * Set timeout
     *
     * @param float $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (float) $timeout;
    }

    /**
     * Get timeout
     *
     * @return float
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
}

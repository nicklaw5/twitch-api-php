<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;
use NewTwitchApi\Auth\AuthGuzzleClient;
use NewTwitchApi\Auth\OauthApi;
use NewTwitchApi\Resources\GamesApi;
use NewTwitchApi\Resources\StreamsApi;
use NewTwitchApi\Resources\UsersApi;
use NewTwitchApi\Resources\WebhooksApi;
use NewTwitchApi\Webhooks\WebhooksSubscriptionApi;

class NewTwitchApi
{
    /**
     * @var OauthApi
     */
    protected $oauthApi;

    /**
     * @var GamesApi
     */
    protected $gamesApi;

    /**
     * @var StreamsApi
     */
    protected $streamsApi;

    /**
     * @var UsersApi
     */
    protected $usersApi;

    /**
     * @var WebhooksApi
     */
    protected $webhooksApi;

    /**
     * @var WebhooksSubscriptionApi
     */
    protected $webhooksSubscriptionApi;

    public function __construct(string $clientId, string $clientSecret, Client $guzzle = null, Client $authGuzzleClient = null)
    {
        $guzzle = $guzzle ?? new HelixGuzzleClient($clientId);
        $authGuzzleClient = $authGuzzleClient ?? new AuthGuzzleClient();

        $this->oauthApi = new OauthApi($clientId, $clientSecret, $authGuzzleClient);
        $this->gamesApi = new GamesApi($guzzle);
        $this->streamsApi = new StreamsApi($guzzle);
        $this->usersApi = new UsersApi($guzzle);
        $this->webhooksApi = new WebhooksApi($guzzle);
        $this->webhooksSubscriptionApi = new WebhooksSubscriptionApi($clientId, $clientSecret, $guzzle);
    }

    public function getOauthApi(): OauthApi
    {
        return $this->oauthApi;
    }

    public function getGamesApi(): GamesApi
    {
        return $this->gamesApi;
    }

    public function getStreamsApi(): StreamsApi
    {
        return $this->streamsApi;
    }

    public function getUsersApi(): UsersApi
    {
        return $this->usersApi;
    }

    public function getWebhooksApi(): WebhooksApi
    {
        return $this->webhooksApi;
    }

    public function getWebhooksSubscriptionApi(): WebhooksSubscriptionApi
    {
        return $this->webhooksSubscriptionApi;
    }
}

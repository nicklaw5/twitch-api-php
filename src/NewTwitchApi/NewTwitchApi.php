<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;
use NewTwitchApi\Auth\OauthApi;
use NewTwitchApi\Resources\GamesApi;
use NewTwitchApi\Resources\StreamsApi;
use NewTwitchApi\Resources\UsersApi;
use NewTwitchApi\Resources\SubscriptionsApi;
use NewTwitchApi\Resources\WebhooksApi;
use NewTwitchApi\Webhooks\WebhooksSubscriptionApi;

class NewTwitchApi
{
    private $oauthApi;
    private $gamesApi;
    private $streamsApi;
    private $usersApi;
    private $subscriptionsApi;
    private $webhooksApi;
    private $webhooksSubscriptionApi;

    public function __construct(Client $helixGuzzleClient, string $clientId, string $clientSecret, Client $authGuzzleClient = null)
    {
        $this->oauthApi = new OauthApi($clientId, $clientSecret, $authGuzzleClient);
        $this->gamesApi = new GamesApi($helixGuzzleClient);
        $this->streamsApi = new StreamsApi($helixGuzzleClient);
        $this->usersApi = new UsersApi($helixGuzzleClient);
        $this->subscriptionsApi = new SubscriptionsApi($helixGuzzleClient);
        $this->webhooksApi = new WebhooksApi($helixGuzzleClient);
        $this->webhooksSubscriptionApi = new WebhooksSubscriptionApi($clientId, $clientSecret, $helixGuzzleClient);
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

    public function getSubscriptionsApi(): UsersApi
    {
        return $this->subscriptionsApi;
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

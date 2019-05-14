<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;
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

    /**
     * NewTwitchApi constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param Client|null $authGuzzleClient
     */
    public function __construct(string $clientId, string $clientSecret, Client $authGuzzleClient = null)
    {
        $helixGuzzleClient = new HelixGuzzleClient($clientId);

        $this->oauthApi = new OauthApi($clientId, $clientSecret, $authGuzzleClient);
        $this->gamesApi = new GamesApi($helixGuzzleClient);
        $this->streamsApi = new StreamsApi($helixGuzzleClient);
        $this->usersApi = new UsersApi($helixGuzzleClient);
        $this->webhooksApi = new WebhooksApi($helixGuzzleClient);
        $this->webhooksSubscriptionApi = new WebhooksSubscriptionApi($clientId, $clientSecret, $helixGuzzleClient);
    }

    /**
     * Oauth Endpoints
     *
     * @return OauthApi
     */
    public function getOauthApi(): OauthApi
    {
        return $this->oauthApi;
    }

    /**
     * Games Endpoints
     *
     * @return GamesApi
     */
    public function getGamesApi(): GamesApi
    {
        return $this->gamesApi;
    }

    /**
     * Streams Endpoints
     *
     * @return StreamsApi
     */
    public function getStreamsApi(): StreamsApi
    {
        return $this->streamsApi;
    }

    /**
     * Users Endpoints
     *
     * @return UsersApi
     */
    public function getUsersApi(): UsersApi
    {
        return $this->usersApi;
    }

    /**
     * Webhooks Endpoints
     *
     * @return WebhooksApi
     */
    public function getWebhooksApi(): WebhooksApi
    {
        return $this->webhooksApi;
    }

    /**
     * Webhooks Subscription Endpoints
     *
     * @return WebhooksSubscriptionApi
     */
    public function getWebhooksSubscriptionApi(): WebhooksSubscriptionApi
    {
        return $this->webhooksSubscriptionApi;
    }
}

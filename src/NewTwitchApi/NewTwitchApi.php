<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;
use NewTwitchApi\Auth\OauthApi;
use NewTwitchApi\Resources\AdsApi;
use NewTwitchApi\Resources\BitsApi;
use NewTwitchApi\Resources\ClipsApi;
use NewTwitchApi\Resources\EntitlementsApi;
use NewTwitchApi\Resources\GamesApi;
use NewTwitchApi\Resources\HypeTrainApi;
use NewTwitchApi\Resources\ModerationApi;
use NewTwitchApi\Resources\SearchApi;
use NewTwitchApi\Resources\StreamsApi;
use NewTwitchApi\Resources\SubscriptionsApi;
use NewTwitchApi\Resources\UsersApi;
use NewTwitchApi\Resources\VideosApi;
use NewTwitchApi\Resources\WebhooksApi;
use NewTwitchApi\Webhooks\WebhooksSubscriptionApi;

class NewTwitchApi
{
    private $oauthApi;
    private $adsApi;
    private $bitsApi;
    private $clipsApi;
    private $entitlementsApi;
    private $gamesApi;
    private $hypeTrainApi;
    private $moderationApi;
    private $searchApi;
    private $streamsApi;
    private $subscriptionsApi;
    private $usersApi;
    private $videosApi;
    private $webhooksApi;
    private $webhooksSubscriptionApi;

    public function __construct(Client $helixGuzzleClient, string $clientId, string $clientSecret, Client $authGuzzleClient = null)
    {
        $this->oauthApi = new OauthApi($clientId, $clientSecret, $authGuzzleClient);
        $this->adsApi = new AdsApi($helixGuzzleClient);
        $this->bitsApi = new BitsApi($helixGuzzleClient);
        $this->clipsApi = new ClipsApi($helixGuzzleClient);
        $this->entitlementsApi = new EntitlementsApi($helixGuzzleClient);
        $this->gamesApi = new GamesApi($helixGuzzleClient);
        $this->hypeTrainApi = new HypeTrainApi($helixGuzzleClient);
        $this->moderationApi = new ModerationApi($helixGuzzleClient);
        $this->searchApi = new SearchApi($helixGuzzleClient);
        $this->streamsApi = new StreamsApi($helixGuzzleClient);
        $this->subscriptionsApi = new SubscriptionsApi($helixGuzzleClient);
        $this->usersApi = new UsersApi($helixGuzzleClient);
        $this->videosApi = new VideosApi($helixGuzzleClient);
        $this->webhooksApi = new WebhooksApi($helixGuzzleClient);
        $this->webhooksSubscriptionApi = new WebhooksSubscriptionApi($clientId, $clientSecret, $helixGuzzleClient);
    }

    public function getOauthApi(): OauthApi
    {
        return $this->oauthApi;
    }

    public function getAdsApi(): AdsApi
    {
        return $this->adsApi;
    }

    public function getBitsApi(): BitsApi
    {
        return $this->bitsApi;
    }

    public function getClipsApi(): ClipsApi
    {
        return $this->clipsApi;
    }

    public function getEntitlementsApi(): EntitlementsApi
    {
        return $this->entitlementsApi;
    }

    public function getGamesApi(): GamesApi
    {
        return $this->gamesApi;
    }

    public function getHypeTrainApi(): HypeTrainApi
    {
        return $this->hypeTrainApi;
    }

    public function getModerationApi(): ModerationApi
    {
        return $this->moderationApi;
    }

    public function getSearchApi(): SearchApi
    {
        return $this->searchApi;
    }

    public function getStreamsApi(): StreamsApi
    {
        return $this->streamsApi;
    }

    public function getSubscriptionsApi(): SubscriptionsApi
    {
        return $this->subscriptionsApi;
    }

    public function getUsersApi(): UsersApi
    {
        return $this->usersApi;
    }

    public function getVideosApi(): VideosApi
    {
        return $this->videosApi;
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

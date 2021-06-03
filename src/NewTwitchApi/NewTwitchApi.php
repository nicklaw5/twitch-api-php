<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;
use NewTwitchApi\Auth\OauthApi;
use NewTwitchApi\Resources\AdsApi;
use NewTwitchApi\Resources\AnalyticsApi;
use NewTwitchApi\Resources\BitsApi;
use NewTwitchApi\Resources\ChannelPointsApi;
use NewTwitchApi\Resources\ChannelsApi;
use NewTwitchApi\Resources\ChatApi;
use NewTwitchApi\Resources\ClipsApi;
use NewTwitchApi\Resources\EntitlementsApi;
use NewTwitchApi\Resources\EventSubApi;
use NewTwitchApi\Resources\GamesApi;
use NewTwitchApi\Resources\HypeTrainApi;
use NewTwitchApi\Resources\ModerationApi;
use NewTwitchApi\Resources\PollsApi;
use NewTwitchApi\Resources\PredictionsApi;
use NewTwitchApi\Resources\SearchApi;
use NewTwitchApi\Resources\StreamsApi;
use NewTwitchApi\Resources\SubscriptionsApi;
use NewTwitchApi\Resources\TagsApi;
use NewTwitchApi\Resources\TeamsApi;
use NewTwitchApi\Resources\UsersApi;
use NewTwitchApi\Resources\VideosApi;
use NewTwitchApi\Resources\WebhooksApi;
use NewTwitchApi\Webhooks\WebhooksSubscriptionApi;

class NewTwitchApi
{
    private $oauthApi;
    private $adsApi;
    private $analyticsApi;
    private $bitsApi;
    private $channelPointsApi;
    private $channelsApi;
    private $chatApi;
    private $clipsApi;
    private $entitlementsApi;
    private $eventSubApi;
    private $gamesApi;
    private $hypeTrainApi;
    private $moderationApi;
    private $pollsApi;
    private $predictionsApi;
    private $searchApi;
    private $streamsApi;
    private $subscriptionsApi;
    private $tagsApi;
    private $teamsApi;
    private $usersApi;
    private $videosApi;
    private $webhooksApi;
    private $webhooksSubscriptionApi;

    public function __construct(HelixGuzzleClient $helixGuzzleClient, string $clientId, string $clientSecret, Client $authGuzzleClient = null)
    {
        $requestGenerator = new RequestGenerator();
        $this->oauthApi = new OauthApi($clientId, $clientSecret, $authGuzzleClient);
        $this->adsApi = new AdsApi($helixGuzzleClient, $requestGenerator);
        $this->analyticsApi = new AnalyticsApi($helixGuzzleClient, $requestGenerator);
        $this->bitsApi = new BitsApi($helixGuzzleClient, $requestGenerator);
        $this->channelPointsApi = new ChannelPointsApi($helixGuzzleClient, $requestGenerator);
        $this->channelsApi = new ChannelsApi($helixGuzzleClient, $requestGenerator);
        $this->chatApi = new ChatApi($helixGuzzleClient, $requestGenerator);
        $this->clipsApi = new ClipsApi($helixGuzzleClient, $requestGenerator);
        $this->entitlementsApi = new EntitlementsApi($helixGuzzleClient, $requestGenerator);
        $this->eventSubApi = new EventSubApi($helixGuzzleClient, $requestGenerator);
        $this->gamesApi = new GamesApi($helixGuzzleClient, $requestGenerator);
        $this->hypeTrainApi = new HypeTrainApi($helixGuzzleClient, $requestGenerator);
        $this->moderationApi = new ModerationApi($helixGuzzleClient, $requestGenerator);
        $this->pollsApi = new PollsApi($helixGuzzleClient, $requestGenerator);
        $this->predictionsApi = new PredictionsApi($helixGuzzleClient, $requestGenerator);
        $this->searchApi = new SearchApi($helixGuzzleClient, $requestGenerator);
        $this->streamsApi = new StreamsApi($helixGuzzleClient, $requestGenerator);
        $this->subscriptionsApi = new SubscriptionsApi($helixGuzzleClient, $requestGenerator);
        $this->tagsApi = new TagsApi($helixGuzzleClient, $requestGenerator);
        $this->teamsApi = new TeamsApi($helixGuzzleClient, $requestGenerator);
        $this->usersApi = new UsersApi($helixGuzzleClient, $requestGenerator);
        $this->videosApi = new VideosApi($helixGuzzleClient, $requestGenerator);
        $this->webhooksApi = new WebhooksApi($helixGuzzleClient, $requestGenerator);
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

    public function getAnalyticsApi(): AnalyticsApi
    {
        return $this->analyticsApi;
    }

    public function getBitsApi(): BitsApi
    {
        return $this->bitsApi;
    }

    public function getChannelPointsApi(): ChannelPointsApi
    {
        return $this->channelPointsApi;
    }

    public function getChannelsApi(): ChannelsApi
    {
        return $this->channelsApi;
    }

    public function getChatApi(): ChatApi
    {
        return $this->chatApi;
    }

    public function getClipsApi(): ClipsApi
    {
        return $this->clipsApi;
    }

    public function getEntitlementsApi(): EntitlementsApi
    {
        return $this->entitlementsApi;
    }

    public function getEventSubApi(): EventSubApi
    {
        return $this->eventSubApi;
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

    public function getPollsApi(): PollsApi
    {
        return $this->pollsApi;
    }

    public function getPredictionsApi(): PredictionsApi
    {
        return $this->predictionsApi;
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

    public function getTagsApi(): TagsApi
    {
        return $this->tagsApi;
    }

    public function getTeamsApi(): TeamsApi
    {
        return $this->teamsApi;
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

<?php

declare(strict_types=1);

namespace TwitchApi;

use GuzzleHttp\Client;
use TwitchApi\Auth\OauthApi;
use TwitchApi\Resources\AdsApi;
use TwitchApi\Resources\AnalyticsApi;
use TwitchApi\Resources\BitsApi;
use TwitchApi\Resources\ChannelPointsApi;
use TwitchApi\Resources\ChannelsApi;
use TwitchApi\Resources\ChatApi;
use TwitchApi\Resources\ClipsApi;
use TwitchApi\Resources\EntitlementsApi;
use TwitchApi\Resources\EventSubApi;
use TwitchApi\Resources\GamesApi;
use TwitchApi\Resources\HypeTrainApi;
use TwitchApi\Resources\ModerationApi;
use TwitchApi\Resources\PollsApi;
use TwitchApi\Resources\PredictionsApi;
use TwitchApi\Resources\ScheduleApi;
use TwitchApi\Resources\SearchApi;
use TwitchApi\Resources\StreamsApi;
use TwitchApi\Resources\SubscriptionsApi;
use TwitchApi\Resources\TagsApi;
use TwitchApi\Resources\TeamsApi;
use TwitchApi\Resources\UsersApi;
use TwitchApi\Resources\VideosApi;
use TwitchApi\Resources\WebhooksApi;
use TwitchApi\Webhooks\WebhooksSubscriptionApi;

class TwitchApi
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
    private $scheduleApi;
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
        $this->scheduleApi = new ScheduleApi($helixGuzzleClient, $requestGenerator);
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

    public function getScheduleApi(): ScheduleApi
    {
        return $this->scheduleApi;
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

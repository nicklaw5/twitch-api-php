<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;
use NewTwitchApi\Auth\OauthApi;
use NewTwitchApi\Resources\AnalyticsApi;
use NewTwitchApi\Resources\BitsApi;
use NewTwitchApi\Resources\ChannelPointsApi;
use NewTwitchApi\Resources\ChannelsApi;
use NewTwitchApi\Resources\ClipsApi;
use NewTwitchApi\Resources\EntitlementsApi;
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
    private $analyticsApi;
    private $bitsApi;
    private $channelPointsApi;
    private $channelsApi;
    private $clipsApi;
    private $entitlementsApi;
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
    private $requestGenerator;

    public function __construct(Client $helixGuzzleClient, string $clientId, string $clientSecret, Client $authGuzzleClient = null)
    {
        $this->requestGenerator = new RequestGenerator;
        $this->oauthApi = new OauthApi($clientId, $clientSecret, $authGuzzleClient);
        $this->analyticsApi = new AnalyticsApi($helixGuzzleClient, $this->requestGenerator);
        $this->bitsApi = new BitsApi($helixGuzzleClient, $this->requestGenerator);
        $this->channelPointsApi = new ChannelPointsApi($helixGuzzleClient, $this->requestGenerator);
        $this->channelsApi = new ChannelsApi($helixGuzzleClient, $this->requestGenerator);
        $this->clipsApi = new ClipsApi($helixGuzzleClient, $this->requestGenerator);
        $this->entitlementsApi = new EntitlementsApi($helixGuzzleClient, $this->requestGenerator);
        $this->gamesApi = new GamesApi($helixGuzzleClient, $this->requestGenerator);
        $this->hypeTrainApi = new HypeTrainApi($helixGuzzleClient, $this->requestGenerator);
        $this->moderationApi = new ModerationApi($helixGuzzleClient, $this->requestGenerator);
        $this->pollsApi = new PollsApi($helixGuzzleClient, $this->requestGenerator);
        $this->predictionsApi = new PredictionsApi($helixGuzzleClient, $this->requestGenerator);
        $this->searchApi = new SearchApi($helixGuzzleClient, $this->requestGenerator);
        $this->streamsApi = new StreamsApi($helixGuzzleClient, $this->requestGenerator);
        $this->subscriptionsApi = new SubscriptionsApi($helixGuzzleClient, $this->requestGenerator);
        $this->tagsApi = new TagsApi($helixGuzzleClient, $this->requestGenerator);
        $this->teamsApi = new TeamsApi($helixGuzzleClient, $this->requestGenerator);
        $this->usersApi = new UsersApi($helixGuzzleClient, $this->requestGenerator);
        $this->videosApi = new VideosApi($helixGuzzleClient, $this->requestGenerator);
        $this->webhooksApi = new WebhooksApi($helixGuzzleClient, $this->requestGenerator);
        $this->webhooksSubscriptionApi = new WebhooksSubscriptionApi($clientId, $clientSecret, $helixGuzzleClient);
    }

    public function getOauthApi(): OauthApi
    {
        return $this->oauthApi;
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

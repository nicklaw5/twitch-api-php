<?php

namespace spec\NewTwitchApi;

use GuzzleHttp\Client;
use NewTwitchApi\Auth\OauthApi;
use NewTwitchApi\Resources\AnalyticsApi;
use NewTwitchApi\Resources\BitsApi;
use NewTwitchApi\Resources\EntitlementsApi;
use NewTwitchApi\Resources\GamesApi;
use NewTwitchApi\Resources\StreamsApi;
use NewTwitchApi\Resources\TagsApi;
use NewTwitchApi\Resources\UsersApi;
use NewTwitchApi\Resources\WebhooksApi;
use NewTwitchApi\Webhooks\WebhooksSubscriptionApi;
use PhpSpec\ObjectBehavior;

class NewTwitchApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient, 'client-id', 'client-secret');
    }

    function it_should_provide_oauth_api()
    {
        $this->getOauthApi()->shouldBeAnInstanceOf(OauthApi::class);
    }

    function it_should_provide_analytics_api()
    {
        $this->getAnalyticsApi()->shouldBeAnInstanceOf(AnalyticsApi::class);
    }

    function it_should_provide_bits_api()
    {
        $this->getBitsApi()->shouldBeAnInstanceOf(BitsApi::class);
    }

    function it_should_provide_entitlements_api()
    {
        $this->getEntitlementsApi()->shouldBeAnInstanceOf(EntitlementsApi::class);
    }

    function it_should_provide_games_api()
    {
        $this->getGamesApi()->shouldBeAnInstanceOf(GamesApi::class);
    }

    function it_should_provide_streams_api()
    {
        $this->getStreamsApi()->shouldBeAnInstanceOf(StreamsApi::class);
    }

    function it_should_provide_tags_api()
    {
        $this->getTagsApi()->shouldBeAnInstanceOf(TagsApi::class);
    }

    function it_should_provide_users_api()
    {
        $this->getUsersApi()->shouldBeAnInstanceOf(UsersApi::class);
    }

    function it_should_provide_webhooks_api()
    {
        $this->getWebhooksApi()->shouldBeAnInstanceOf(WebhooksApi::class);
    }

    function it_should_provide_webhooks_subscription_api()
    {
        $this->getWebhooksSubscriptionApi()->shouldBeAnInstanceOf(WebhooksSubscriptionApi::class);
    }
}

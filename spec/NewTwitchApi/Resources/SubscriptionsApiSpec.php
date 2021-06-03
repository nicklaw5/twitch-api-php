<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use NewTwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class SubscriptionsApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_broadcaster_subscriptions(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'subscriptions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getBroadcasterSubscriptions('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_broadcaster_subscriptions_with_all(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'subscriptions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'first', 'value' => 100], ['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getBroadcasterSubscriptions('TEST_TOKEN', '123', 100, 'abc')->shouldBe($response);
    }

    function it_should_get_broadcaster_subscribers(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'subscriptions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getBroadcasterSubscribers('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_broadcaster_subscribers_with_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'subscriptions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'user_id', 'value' => '321']], [])->willReturn($request);
        $this->getBroadcasterSubscribers('TEST_TOKEN', '123', ['321'])->shouldBe($response);
    }

    function it_should_get_broadcaster_subscribers_with_ids(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'subscriptions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'user_id', 'value' => '321'], ['key' => 'user_id', 'value' => '456']], [])->willReturn($request);
        $this->getBroadcasterSubscribers('TEST_TOKEN', '123', ['321', '456'])->shouldBe($response);
    }

    function it_should_check_user_subscriptions(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'subscriptions/user', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'user_id', 'value' => '456']], [])->willReturn($request);
        $this->checkUserSubscription('TEST_TOKEN', '123', '456')->shouldBe($response);
    }
}

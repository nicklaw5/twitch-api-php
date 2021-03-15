<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class SubscriptionsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_check_user_subscriptions(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'subscriptions/user?broadcaster_id=123&user_id=456', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->checkUserSubscription('TEST_TOKEN', 123, 456)->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

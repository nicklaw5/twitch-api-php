<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class EventSubApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_subscribe_to_channel_update(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('POST', 'eventsub/subscriptions', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->subscribeToChannelUpdate('TEST_TOKEN', 'SECRET', 'https://example.com', '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

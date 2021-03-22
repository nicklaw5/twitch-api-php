<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class ChannelsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_get_channel_info(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'channels?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getChannelInfo('TEST_TOKEN', '123')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_channel_editors(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'channels/editors?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getChannelEditors('TEST_TOKEN', '123')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

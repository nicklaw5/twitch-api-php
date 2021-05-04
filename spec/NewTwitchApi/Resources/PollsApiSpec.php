<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class PollsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_get_polls(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'polls?broadcaster_id=12345', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getPolls('TEST_TOKEN', '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_polls_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'polls?broadcaster_id=12345&id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getPolls('TEST_TOKEN', '12345', ['123'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_polls_by_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'polls?broadcaster_id=12345&id=123&id=321', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getPolls('TEST_TOKEN', '12345', ['123', '321'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_polls_with_everything(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'polls?broadcaster_id=12345&id=123&id=321&after=abc&first=20', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getPolls('TEST_TOKEN', '12345', ['123', '321'], 'abc', 20)->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

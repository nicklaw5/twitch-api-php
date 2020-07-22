<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class TagsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_get_all_tags(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'tags/streams', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getAllStreamTags('TEST_TOKEN')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_all_tags_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'tags/streams?tag_id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getAllStreamTags('TEST_TOKEN', [123])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_all_tags_with_first(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'tags/streams?first=100', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getAllStreamTags('TEST_TOKEN', [], 100)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_all_tags_with_after(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'tags/streams?after=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getAllStreamTags('TEST_TOKEN', [], null, 'abc')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_stream_tags(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams/tags?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreamTags('TEST_TOKEN', '123')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

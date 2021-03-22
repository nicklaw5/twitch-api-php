<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class VideosApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_delete_videos(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('DELETE', 'videos?id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->deleteVideos('TEST_TOKEN', ['123'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_delete_multiple_videos(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('DELETE', 'videos?id=123&id=321', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->deleteVideos('TEST_TOKEN', ['123', '321'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

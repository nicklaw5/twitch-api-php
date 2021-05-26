<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class VideosApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_delete_videos(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'videos', 'TEST_TOKEN', [['key' => 'id', 'value' => '123']], [])->willReturn($request);
        $this->deleteVideos('TEST_TOKEN', ['123'])->shouldBe($response);
    }

    function it_should_delete_multiple_videos(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'videos', 'TEST_TOKEN', [['key' => 'id', 'value' => '123'], ['key' => 'id', 'value' => '321']], [])->willReturn($request);
        $this->deleteVideos('TEST_TOKEN', ['123', '321'])->shouldBe($response);
    }
}

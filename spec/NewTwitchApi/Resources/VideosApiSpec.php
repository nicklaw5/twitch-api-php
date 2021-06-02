<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use NewTwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class VideosApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_video_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'id', 'value' => '123']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', ['123'])->shouldBe($response);
    }

    function it_should_get_videos_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'id', 'value' => '123'], ['key' => 'id', 'value' => '321']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', ['123', '321'])->shouldBe($response);
    }

    function it_should_get_videos_by_user_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', [], '123')->shouldBe($response);
    }

    function it_should_get_videos_by_game_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'game_id', 'value' => '123']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', [], null, '123')->shouldBe($response);
    }

    function it_should_get_videos_with_first(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'first', 'value' => 100]], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', [], null, null, 100)->shouldBe($response);
    }

    function it_should_get_videos_with_before(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'before', 'value' => 'abc']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', [], null, null, null, 'abc')->shouldBe($response);
    }

    function it_should_get_videos_with_after(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'after', 'value' => 'cba']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', [], null, null, null, null, 'cba')->shouldBe($response);
    }

    function it_should_get_videos_with_language(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'language', 'value' => 'en']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', [], null, null, null, null, null, 'en')->shouldBe($response);
    }

    function it_should_get_videos_with_period(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'period', 'value' => 'all']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', [], null, null, null, null, null, null, 'all')->shouldBe($response);
    }

    function it_should_get_videos_with_sort(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'sort', 'value' => 'trending']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', [], null, null, null, null, null, null, null, 'trending')->shouldBe($response);
    }

    function it_should_get_videos_with_type(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'type', 'value' => 'all']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', [], null, null, null, null, null, null, null, null, 'all')->shouldBe($response);
    }

    function it_should_get_videos_with_everything(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'videos', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'game_id', 'value' => '321'], ['key' => 'first', 'value' => 100], ['key' => 'before', 'value' => 'abc'], ['key' => 'after', 'value' => 'def'], ['key' => 'language', 'value' => 'en'], ['key' => 'period', 'value' => 'all'], ['key' => 'sort', 'value' => 'trending'], ['key' => 'type', 'value' => 'all']], [])->willReturn($request);
        $this->getVideos('TEST_TOKEN', [], '123', '321', 100, 'abc', 'def', 'en', 'all', 'trending', 'all')->shouldBe($response);
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

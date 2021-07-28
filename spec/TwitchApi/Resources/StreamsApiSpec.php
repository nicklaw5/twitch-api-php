<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class StreamsApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_streams_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123']], [])->willReturn($request);
        $this->getStreams('TEST_TOKEN', ['123'])->shouldBe($response);
    }

    function it_should_get_streams_by_id_with_helper(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123']], [])->willReturn($request);
        $this->getStreamForUserId('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_streams_by_ids(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'user_id', 'value' => '321']], [])->willReturn($request);
        $this->getStreams('TEST_TOKEN', ['123', '321'])->shouldBe($response);
    }

    function it_should_get_streams_by_username(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'user_login', 'value' => 'test']], [])->willReturn($request);
        $this->getStreams('TEST_TOKEN', [], ['test'])->shouldBe($response);
    }

    function it_should_get_streams_by_username_with_helper(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'user_login', 'value' => 'test']], [])->willReturn($request);
        $this->getStreamForUsername('TEST_TOKEN', 'test')->shouldBe($response);
    }

    function it_should_get_streams_by_usernames(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'user_login', 'value' => 'test'], ['key' => 'user_login', 'value' => 'user']], [])->willReturn($request);
        $this->getStreams('TEST_TOKEN', [], ['test', 'user'])->shouldBe($response);
    }

    function it_should_get_streams_by_id_and_username(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'user_login', 'value' => 'test']], [])->willReturn($request);
        $this->getStreams('TEST_TOKEN', ['123'], ['test'])->shouldBe($response);
    }

    function it_should_get_streams_by_game_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'game_id', 'value' => '123']], [])->willReturn($request);
        $this->getStreams('TEST_TOKEN', [], [], ['123'])->shouldBe($response);
    }

    function it_should_get_streams_by_game_id_with_helper(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'game_id', 'value' => '123']], [])->willReturn($request);
        $this->getStreamsByGameId('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_streams_by_game_ids(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'game_id', 'value' => '123'], ['key' => 'game_id', 'value' => '456']], [])->willReturn($request);
        $this->getStreams('TEST_TOKEN', [], [], ['123', '456'])->shouldBe($response);
    }

    function it_should_get_streams_by_language(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'language', 'value' => 'en']], [])->willReturn($request);
        $this->getStreams('TEST_TOKEN', [], [], [], ['en'])->shouldBe($response);
    }

    function it_should_get_streams_by_language_with_helper(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'language', 'value' => 'en']], [])->willReturn($request);
        $this->getStreamsByLanguage('TEST_TOKEN', 'en')->shouldBe($response);
    }

    function it_should_get_streams_by_languages(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'language', 'value' => 'en'], ['key' => 'language', 'value' => 'fr']], [])->willReturn($request);
        $this->getStreams('TEST_TOKEN', [], [], [], ['en', 'fr'])->shouldBe($response);
    }

    function it_should_get_streams_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams', 'TEST_TOKEN', [['key' => 'first', 'value' => 100], ['key' => 'before', 'value' => 'abc'], ['key' => 'after', 'value' => 'def']], [])->willReturn($request);
        $this->getStreams('TEST_TOKEN', [], [], [], [], 100, 'abc', 'def')->shouldBe($response);
    }

    function it_should_get_stream_key(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams/key', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getStreamKey('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_stream_markers_by_user_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams/markers', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123']], [])->willReturn($request);
        $this->getStreamMarkers('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_stream_markers_by_user_id_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams/markers', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'first', 'value' => 100], ['key' => 'before', 'value' => 'abc'], ['key' => 'after', 'value' => 'def']], [])->willReturn($request);
        $this->getStreamMarkers('TEST_TOKEN', '123', null, 100, 'abc', 'def')->shouldBe($response);
    }

    function it_should_get_stream_markers_by_video_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams/markers', 'TEST_TOKEN', [['key' => 'video_id', 'value' => '123']], [])->willReturn($request);
        $this->getStreamMarkers('TEST_TOKEN', null, '123')->shouldBe($response);
    }

    function it_should_get_stream_markers_by_video_id_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams/markers', 'TEST_TOKEN', [['key' => 'video_id', 'value' => '123'], ['key' => 'first', 'value' => 100], ['key' => 'before', 'value' => 'abc'], ['key' => 'after', 'value' => 'def']], [])->willReturn($request);
        $this->getStreamMarkers('TEST_TOKEN', null, '123', 100, 'abc', 'def')->shouldBe($response);
    }

    function it_should_get_followed_streams(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams/followed', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123']], [])->willReturn($request);
        $this->getFollowedStreams('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_followed_streams_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams/followed', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'first', 'value' => 100], ['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getFollowedStreams('TEST_TOKEN', '123', 100, 'abc')->shouldBe($response);
    }

    function it_should_create_stream_marker(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'streams/markers', 'TEST_TOKEN', [], [['key' => 'user_id', 'value' => '123']])->willReturn($request);
        $this->createStreamMarker('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_create_stream_marker_with_description(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'streams/markers', 'TEST_TOKEN', [], [['key' => 'user_id', 'value' => '123'], ['key' => 'description', 'value' => 'This is a marker']])->willReturn($request);
        $this->createStreamMarker('TEST_TOKEN', '123', 'This is a marker')->shouldBe($response);
    }
}

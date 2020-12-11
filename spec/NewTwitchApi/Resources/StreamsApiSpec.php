<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class StreamsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_get_streams_by_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_id=12345&user_id=98765', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', ['12345', '98765'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_usernames(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_login=twitchuser&user_login=anotheruser', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], ['twitchuser', 'anotheruser'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_id_and_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_id=12345&user_id=98765&user_login=twitchuser&user_login=anotheruser', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', ['12345', '98765'], ['twitchuser', 'anotheruser'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_a_single_user_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_id=12345', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreamForUserId('TEST_TOKEN', '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_a_single_game_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?game_id=12345', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreamsByGameId('TEST_TOKEN', '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_a_single_language(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?language=en', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreamsByLanguage('TEST_TOKEN', 'en')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_a_single_user_by_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_login=twitchuser', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreamForUsername('TEST_TOKEN', 'twitchuser')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_game_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?game_id=12345&game_id=98765', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], [], ['12345', '98765'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_languages(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?language=en&language=de', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], [], [], ['en', 'de'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_page_by_first(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?first=42', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], [], [], [], 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_page_by_before(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?before=42', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], [], [], [], null, 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_page_by_after(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?after=42', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], [], [], [], null, null, 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_everything(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_id=12&user_id=34&user_login=twitchuser&user_login=anotheruser&game_id=56&game_id=78&language=en&language=de&first=100&before=200&after=300', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', ['12', '34'], ['twitchuser', 'anotheruser'], ['56', '78'], ['en', 'de'], 100, 200, 300)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_create_stream_marker(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('POST', 'streams/markers', ['Authorization' => 'Bearer TEST_TOKEN', 'Accept' => 'application/json'], json_encode(['user_id' => '123'])))->willReturn($response);
        $this->createStreamMarker('TEST_TOKEN', '123')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_create_stream_marker_with_desc(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('POST', 'streams/markers', ['Authorization' => 'Bearer TEST_TOKEN', 'Accept' => 'application/json'], json_encode(['user_id' => '123', 'description' => 'test'])))->willReturn($response);
        $this->createStreamMarker('TEST_TOKEN', '123', 'test')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_modify_channel_info_with_nothing(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('PATCH', 'channels?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->modifyChannelInfo('TEST_TOKEN', '123')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_modify_channel_info_with_game_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('PATCH', 'channels?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN', 'Accept' => 'application/json'], json_encode(['game_id' => '321'])))->willReturn($response);
        $this->modifyChannelInfo('TEST_TOKEN', '123', '321')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_modify_channel_info_with_language(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('PATCH', 'channels?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN', 'Accept' => 'application/json'], json_encode(['broadcaster_language' => 'en'])))->willReturn($response);
        $this->modifyChannelInfo('TEST_TOKEN', '123', NULL, 'en')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_modify_channel_info_with_title(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('PATCH', 'channels?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN', 'Accept' => 'application/json'], json_encode(['title' => 'test'])))->willReturn($response);
        $this->modifyChannelInfo('TEST_TOKEN', '123', NULL, NULL, 'test')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_modify_channel_info_with_everything(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('PATCH', 'channels?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN', 'Accept' => 'application/json'], json_encode(['game_id' => '321', 'broadcaster_language' => 'en', 'title' => 'test'])))->willReturn($response);
        $this->modifyChannelInfo('TEST_TOKEN', '123', '321', 'en', 'test')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class StreamsApiSpec extends ObjectBehavior
{
    public function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    public function it_should_get_streams_by_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_id=12345&user_id=98765', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', ['12345', '98765'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_streams_by_usernames(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_login=twitchuser&user_login=anotheruser', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], ['twitchuser', 'anotheruser'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_streams_by_id_and_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_id=12345&user_id=98765&user_login=twitchuser&user_login=anotheruser', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', ['12345', '98765'], ['twitchuser', 'anotheruser'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_a_single_game_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?game_id=12345', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreamsByGameId('TEST_TOKEN', '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_a_single_language(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?language=en', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreamsByLanguage('TEST_TOKEN', 'en')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_a_single_user_by_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_login=twitchuser', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreamForUsername('TEST_TOKEN', 'twitchuser')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_streams_by_game_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?game_id=12345&game_id=98765', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], [], ['12345', '98765'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_streams_by_languages(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?language=en&language=de', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], [], [], [], ['en', 'de'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_streams_page_by_first(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?first=42', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], [], [], [], [], 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_streams_page_by_before(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?before=42', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], [], [], [], [], null, 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_streams_page_by_after(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?after=42', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', [], [], [], [], [], null, null, 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_streams_by_everything(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_id=12&user_id=34&user_login=twitchuser&user_login=anotheruser&game_id=56&game_id=78&language=en&language=de&first=100&before=200&after=300', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getStreams('TEST_TOKEN', ['12', '34'], ['twitchuser', 'anotheruser'], ['56', '78'], [], ['en', 'de'], 100, 200, 300)->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

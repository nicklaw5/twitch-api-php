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
        $guzzleClient->send(new Request('GET', 'streams?user_id=12345&user_id=98765'))->willReturn($response);
        $this->getStreams([12345,98765])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_usernames(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_login=twitchuser&user_login=anotheruser'))->willReturn($response);
        $this->getStreams([], ['twitchuser','anotheruser'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_id_and_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_id=12345&user_id=98765&user_login=twitchuser&user_login=anotheruser'))->willReturn($response);
        $this->getStreams([12345,98765], ['twitchuser','anotheruser'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_a_single_user_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_id=12345'))->willReturn($response);
        $this->getStreamForUserId(12345)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_a_single_user_by_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_login=twitchuser'))->willReturn($response);
        $this->getStreamForUsername('twitchuser')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_game_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?game_id=12345&game_id=98765'))->willReturn($response);
        $this->getStreams([], [], [12345,98765])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_community_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?community_id=12345&community_id=98765'))->willReturn($response);
        $this->getStreams([], [], [], [12345,98765])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_languages(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?language=en&language=de'))->willReturn($response);
        $this->getStreams([], [], [], [], ['en','de'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_page_by_first(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?first=42'))->willReturn($response);
        $this->getStreams([], [], [], [], [], 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_page_by_before(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?before=42'))->willReturn($response);
        $this->getStreams([], [], [], [], [], null, 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_page_by_after(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?after=42'))->willReturn($response);
        $this->getStreams([], [], [], [], [], null, null, 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_streams_by_everything(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_id=12&user_id=34&user_login=twitchuser&user_login=anotheruser&game_id=56&game_id=78&community_id=90&community_id=99&language=en&language=de&first=100&before=200&after=300'))->willReturn($response);
        $this->getStreams([12,34], ['twitchuser','anotheruser'], [56,78], [90,99], ['en','de'], 100, 200, 300)->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

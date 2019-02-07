<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class GamesApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_get_games_by_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'games?id=12345&id=98765'))->willReturn($response);
        $this->getGames(['12345','98765'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_games_by_names(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'games?name=mario&name=sonic'))->willReturn($response);
        $this->getGames([], ['mario','sonic'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_games_by_ids_and_names(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'games?id=12345&id=98765&name=mario&name=sonic'))->willReturn($response);
        $this->getGames(['12345','98765'], ['mario','sonic'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

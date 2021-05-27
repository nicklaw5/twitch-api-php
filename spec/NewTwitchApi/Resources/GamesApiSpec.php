<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;

class GamesApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_games_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'games', 'TEST_TOKEN', [['key' => 'id', 'value' => '123']], [])->willReturn($request);
        $this->getGames('TEST_TOKEN', ['123'])->shouldBe($response);
    }

    function it_should_get_games_by_ids(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'games', 'TEST_TOKEN', [['key' => 'id', 'value' => '123'], ['key' => 'id', 'value' => '456']], [])->willReturn($request);
        $this->getGames('TEST_TOKEN', ['123', '456'])->shouldBe($response);
    }

    function it_should_get_games_by_name(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'games', 'TEST_TOKEN', [['key' => 'name', 'value' => 'abc']], [])->willReturn($request);
        $this->getGames('TEST_TOKEN', [], ['abc'])->shouldBe($response);
    }

    function it_should_get_games_by_names(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'games', 'TEST_TOKEN', [['key' => 'name', 'value' => 'abc'], ['key' => 'name', 'value' => 'def']], [])->willReturn($request);
        $this->getGames('TEST_TOKEN', [], ['abc', 'def'])->shouldBe($response);
    }

    function it_should_get_games_by_ids_and_names(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'games', 'TEST_TOKEN', [['key' => 'id', 'value' => '123'], ['key' => 'id', 'value' => '456'], ['key' => 'name', 'value' => 'abc'], ['key' => 'name', 'value' => 'def']], [])->willReturn($request);
        $this->getGames('TEST_TOKEN', ['123', '456'], ['abc', 'def'])->shouldBe($response);
    }

    function it_should_get_top_games(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'games/top', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getTopGames('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_get_top_games_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'games/top', 'TEST_TOKEN', [['key' => 'first', 'value' => 100], ['key' => 'before', 'value' => 'abc'], ['key' => 'after', 'value' => 'def']], [])->willReturn($request);
        $this->getTopGames('TEST_TOKEN', 100, 'abc', 'def')->shouldBe($response);
    }
}

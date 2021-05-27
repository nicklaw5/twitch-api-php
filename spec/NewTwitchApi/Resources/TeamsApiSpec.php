<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class TeamsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_channel_teams(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'teams/channel', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChannelTeams('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_teams(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'teams', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getTeams('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_get_teams_by_name(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'teams', 'TEST_TOKEN', [['key' => 'name', 'value' => 'abc']], [])->willReturn($request);
        $this->getTeams('TEST_TOKEN', 'abc')->shouldBe($response);
    }

    function it_should_get_teams_by_name_with_helper_function(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'teams', 'TEST_TOKEN', [['key' => 'name', 'value' => 'abc']], [])->willReturn($request);
        $this->getTeamsByName('TEST_TOKEN', 'abc')->shouldBe($response);
    }

    function it_should_get_teams_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'teams', 'TEST_TOKEN', [['key' => 'id', 'value' => '123']], [])->willReturn($request);
        $this->getTeams('TEST_TOKEN', null, '123')->shouldBe($response);
    }

    function it_should_get_teams_by_id_with_helper_function(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'teams', 'TEST_TOKEN', [['key' => 'id', 'value' => '123']], [])->willReturn($request);
        $this->getTeamsById('TEST_TOKEN', '123')->shouldBe($response);
    }
}

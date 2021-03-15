<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class TeamsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_get_channel_teams(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'teams/channel?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getChannelTeams('TEST_TOKEN', 123)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_teams_by_name(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'teams?name=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getTeamsByName('TEST_TOKEN', 'abc')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_teams_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'teams?id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getTeamsById('TEST_TOKEN', 123)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_teams(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'teams', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getTeams('TEST_TOKEN')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

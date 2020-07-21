<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class AnalyticsApiSpec extends ObjectBehavior
{
    public function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    public function it_should_get_extension_analytics(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/extensions', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionAnalytics('TEST_TOKEN')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_extension_analytics_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/extensions?extension_id=1', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionAnalytics('TEST_TOKEN', '1')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_extension_analytics_with_type(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/extensions?type=overview_v1', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionAnalytics('TEST_TOKEN', null, 'overview_v1')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_extension_analytics_with_first(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/extensions?first=100', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionAnalytics('TEST_TOKEN', null, null, 100)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_extension_analytics_with_after(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/extensions?after=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionAnalytics('TEST_TOKEN', null, null, null, 'abc')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_extension_analytics_with_started_at(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/extensions?started_at=2020-01-01T00:00:00Z', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionAnalytics('TEST_TOKEN', null, null, null, null, '2020-01-01T00:00:00Z')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_extension_analytics_with_ended_at(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/extensions?ended_at=2020-01-01T00:00:00Z', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionAnalytics('TEST_TOKEN', null, null, null, null, null, '2020-01-01T00:00:00Z')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_game_analytics(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/games', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getGameAnalytics('TEST_TOKEN')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_game_analytics_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/games?game_id=1', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getGameAnalytics('TEST_TOKEN', '1')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_game_analytics_with_type(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/games?type=overview_v1', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getGameAnalytics('TEST_TOKEN', null, 'overview_v1')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_game_analytics_with_first(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/games?first=100', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getGameAnalytics('TEST_TOKEN', null, null, 100)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_game_analytics_with_after(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/games?after=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getGameAnalytics('TEST_TOKEN', null, null, null, 'abc')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_game_analytics_with_started_at(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/games?started_at=2020-01-01T00:00:00Z', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getGameAnalytics('TEST_TOKEN', null, null, null, null, '2020-01-01T00:00:00Z')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_game_analytics_with_ended_at(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'analytics/games?ended_at=2020-01-01T00:00:00Z', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getGameAnalytics('TEST_TOKEN', null, null, null, null, null, '2020-01-01T00:00:00Z')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

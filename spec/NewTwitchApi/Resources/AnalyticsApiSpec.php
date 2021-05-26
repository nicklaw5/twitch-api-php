<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class AnalyticsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_extension_analytics(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/extensions', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getExtensionAnalytics('TEST_TOKEN')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_extension_analytics_by_id(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/extensions', 'TEST_TOKEN', [['key' => 'extension_id', 'value' => '1']], [])->willReturn($request);
        $this->getExtensionAnalytics('TEST_TOKEN', '1')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_extension_analytics_with_type(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/extensions', 'TEST_TOKEN', [['key' => 'type', 'value' => 'overview_v1']], [])->willReturn($request);
        $this->getExtensionAnalytics('TEST_TOKEN', null, 'overview_v1')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_extension_analytics_with_first(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/extensions', 'TEST_TOKEN', [['key' => 'first', 'value' => '100']], [])->willReturn($request);
        $this->getExtensionAnalytics('TEST_TOKEN', null, null, 100)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_extension_analytics_with_after(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/extensions', 'TEST_TOKEN', [['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getExtensionAnalytics('TEST_TOKEN', null, null, null, 'abc')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_extension_analytics_with_started_at(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/extensions', 'TEST_TOKEN', [['key' => 'started_at', 'value' => '2020-01-01T00:00:00Z']], [])->willReturn($request);
        $this->getExtensionAnalytics('TEST_TOKEN', null, null, null, null, '2020-01-01T00:00:00Z')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_extension_analytics_with_ended_at(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/extensions', 'TEST_TOKEN', [['key' => 'ended_at', 'value' => '2020-01-01T00:00:00Z']], [])->willReturn($request);
        $this->getExtensionAnalytics('TEST_TOKEN', null, null, null, null, null, '2020-01-01T00:00:00Z')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_game_analytics(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/games', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getGameAnalytics('TEST_TOKEN')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_game_analytics_by_id(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/games', 'TEST_TOKEN', [['key' => 'game_id', 'value' => '1']], [])->willReturn($request);
        $this->getGameAnalytics('TEST_TOKEN', '1')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_game_analytics_with_type(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/games', 'TEST_TOKEN', [['key' => 'type', 'value' => 'overview_v1']], [])->willReturn($request);
        $this->getGameAnalytics('TEST_TOKEN', null, 'overview_v1')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_game_analytics_with_first(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/games', 'TEST_TOKEN', [['key' => 'first', 'value' => '100']], [])->willReturn($request);
        $this->getGameAnalytics('TEST_TOKEN', null, null, 100)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_game_analytics_with_after(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/games', 'TEST_TOKEN', [['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getGameAnalytics('TEST_TOKEN', null, null, null, 'abc')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_game_analytics_with_started_at(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/games', 'TEST_TOKEN', [['key' => 'started_at', 'value' => '2020-01-01T00:00:00Z']], [])->willReturn($request);
        $this->getGameAnalytics('TEST_TOKEN', null, null, null, null, '2020-01-01T00:00:00Z')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_game_analytics_with_ended_at(RequestGenerator $requestGenerator, Request $request)
    {
        $requestGenerator->generate('GET', 'analytics/games', 'TEST_TOKEN', [['key' => 'ended_at', 'value' => '2020-01-01T00:00:00Z']], [])->willReturn($request);
        $this->getGameAnalytics('TEST_TOKEN', null, null, null, null, null, '2020-01-01T00:00:00Z')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

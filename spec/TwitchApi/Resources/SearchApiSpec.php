<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class SearchApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_search_categories(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'search/categories', 'TEST_TOKEN', [['key' => 'query', 'value' => 'test']], [])->willReturn($request);
        $this->searchCategories('TEST_TOKEN', 'test')->shouldBe($response);
    }

    function it_should_search_categories_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'search/categories', 'TEST_TOKEN', [['key' => 'query', 'value' => 'test'], ['key' => 'first', 'value' => 100], ['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->searchCategories('TEST_TOKEN', 'test', 100, 'abc')->shouldBe($response);
    }

    function it_should_search_channels(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'search/channels', 'TEST_TOKEN', [['key' => 'query', 'value' => 'test']], [])->willReturn($request);
        $this->searchChannels('TEST_TOKEN', 'test')->shouldBe($response);
    }

    function it_should_search_channels_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'search/channels', 'TEST_TOKEN', [['key' => 'query', 'value' => 'test'], ['key' => 'live_only', 'value' => true], ['key' => 'first', 'value' => 100], ['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->searchChannels('TEST_TOKEN', 'test', true, 100, 'abc')->shouldBe($response);
    }
}

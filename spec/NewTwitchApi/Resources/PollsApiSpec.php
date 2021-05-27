<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;

class PollsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_polls(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'polls', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getPolls('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_polls_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'polls', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321']], [])->willReturn($request);
        $this->getPolls('TEST_TOKEN', '123', ['321'])->shouldBe($response);
    }

    function it_should_get_polls_by_ids(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'polls', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321'], ['key' => 'id', 'value' => '456']], [])->willReturn($request);
        $this->getPolls('TEST_TOKEN', '123', ['321', '456'])->shouldBe($response);
    }

    function it_should_get_polls_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'polls', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'after', 'value' => 'abc'], ['key' => 'first', 'value' => 100]], [])->willReturn($request);
        $this->getPolls('TEST_TOKEN', '123', [], 'abc', 100)->shouldBe($response);
    }
}

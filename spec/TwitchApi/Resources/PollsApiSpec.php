<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class PollsApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
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

    function it_should_create_a_poll(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'polls', 'TEST_TOKEN', [], [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'title', 'value' => 'What is my name?'], ['key' => 'choices', 'value' => [['title' => 'John'], ['title' => 'Doe']]], ['key' => 'duration', 'value' => 15]])->willReturn($request);
        $this->createPoll('TEST_TOKEN', '123', 'What is my name?', [['title' => 'John'], ['title' => 'Doe']], 15)->shouldBe($response);
    }

    function it_should_create_a_poll_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'polls', 'TEST_TOKEN', [], [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'title', 'value' => 'What is my name?'], ['key' => 'choices', 'value' => [['title' => 'John'], ['title' => 'Doe']]], ['key' => 'duration', 'value' => 15], ['key' => 'bits_voting_enabled', 'value' => 1]])->willReturn($request);
        $this->createPoll('TEST_TOKEN', '123', 'What is my name?', [['title' => 'John'], ['title' => 'Doe']], 15, ['bits_voting_enabled' => 1])->shouldBe($response);
    }

    function it_should_end_a_poll(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'polls', 'TEST_TOKEN', [], [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '456'], ['key' => 'status', 'value' => 'TERMINATED']])->willReturn($request);
        $this->endPoll('TEST_TOKEN', '123', '456', 'TERMINATED')->shouldBe($response);
    }
}

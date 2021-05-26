<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class TagsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_all_tags(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'tags/streams', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getAllStreamTags('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_get_all_tags_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'tags/streams', 'TEST_TOKEN', [['key' => 'tag_id', 'value' => '123']], [])->willReturn($request);
        $this->getAllStreamTags('TEST_TOKEN', ['123'])->shouldBe($response);
    }

    function it_should_get_all_tags_with_first(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'tags/streams', 'TEST_TOKEN', [['key' => 'first', 'value' => 100]], [])->willReturn($request);
        $this->getAllStreamTags('TEST_TOKEN', [], 100)->shouldBe($response);
    }

    function it_should_get_all_tags_with_after(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'tags/streams', 'TEST_TOKEN', [['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getAllStreamTags('TEST_TOKEN', [], null, 'abc')->shouldBe($response);
    }

    function it_should_get_stream_tags(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'streams/tags', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getStreamTags('TEST_TOKEN', '123')->shouldBe($response);
    }
}

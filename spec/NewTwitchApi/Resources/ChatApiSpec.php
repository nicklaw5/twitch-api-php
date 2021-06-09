<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use NewTwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class ChatApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_channel_emotes(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/emotes', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChannelEmotes('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_global_emotes(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/emotes/global', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getGlobalEmotes('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_get_one_emote_set(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/emotes/set', 'TEST_TOKEN', [['key' => 'emote_set_id', 'value' => '123']], [])->willReturn($request);
        $this->getEmoteSets('TEST_TOKEN', ['123'])->shouldBe($response);
    }

    function it_should_get_one_emote_set_with_helper_function(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/emotes/set', 'TEST_TOKEN', [['key' => 'emote_set_id', 'value' => '123']], [])->willReturn($request);
        $this->getEmoteSet('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_multiple_emote_sets(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/emotes/set', 'TEST_TOKEN', [['key' => 'emote_set_id', 'value' => '123'], ['key' => 'emote_set_id', 'value' => '456']], [])->willReturn($request);
        $this->getEmoteSets('TEST_TOKEN', ['123', '456'])->shouldBe($response);
    }

    function it_should_get_channel_chat_badges(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/badges', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChannelChatBadges('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_global_chat_badges(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/badges/global', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getGlobalChatBadges('TEST_TOKEN')->shouldBe($response);
    }
}

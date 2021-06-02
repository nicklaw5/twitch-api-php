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

<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use NewTwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class ModerationApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_check_automod_status(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/enforcements/status', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'msg_id', 'value' => '456'], ['key' => 'msg_text', 'value' => 'test 123'], ['key' => 'user_id', 'value' => '789']])->willReturn($request);
        $this->checkAutoModStatus('TEST_TOKEN', '123', '456', 'test 123', '789')->shouldBe($response);
    }

    function it_should_release_held_message(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/automod/message', 'TEST_TOKEN', [], [['key' => 'user_id', 'value' => '123'], ['key' => 'msg_id', 'value' => '456'], ['key' => 'action', 'value' => 'ALLOW']])->willReturn($request);
        $this->manageHeldAutoModMessage('TEST_TOKEN', '123', '456', 'ALLOW')->shouldBe($response);
    }
}

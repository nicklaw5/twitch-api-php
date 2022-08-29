<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
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
        $requestGenerator->generate('POST', 'moderation/enforcements/status', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'msg_id', 'value' => '456'], ['key' => 'msg_text', 'value' => 'test 123']])->willReturn($request);
        $this->checkAutoModStatus('TEST_TOKEN', '123', '456', 'test 123')->shouldBe($response);
    }

    function it_should_release_held_message(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/automod/message', 'TEST_TOKEN', [], [['key' => 'user_id', 'value' => '123'], ['key' => 'msg_id', 'value' => '456'], ['key' => 'action', 'value' => 'ALLOW']])->willReturn($request);
        $this->manageHeldAutoModMessage('TEST_TOKEN', '123', '456', 'ALLOW')->shouldBe($response);
    }

    function it_should_ban_a_user(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/bans', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'user_id', 'value' => '789'], ['key' => 'reason', 'value' => 'abc']])->willReturn($request);
        $this->banUser('TEST_TOKEN', '123', '456', '789', 'abc')->shouldBe($response);
    }

    function it_should_ban_a_user_with_a_duration(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/bans', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'user_id', 'value' => '789'], ['key' => 'reason', 'value' => 'abc'], ['key' => 'duration', 'value' => 300]])->willReturn($request);
        $this->banUser('TEST_TOKEN', '123', '456', '789', 'abc', 300)->shouldBe($response);
    }
}

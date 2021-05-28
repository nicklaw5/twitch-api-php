<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;

class ModerationApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_check_automod_status(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/enforcements/status', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'msg_id', 'value' => '456'], ['key' => 'msg_text', 'value' => 'test 123'], ['key' => 'user_id', 'value' => '789']])->willReturn($request);
        $this->checkAutoModStatus('TEST_TOKEN', '123', '456', 'test 123', '789')->shouldBe($response);
    }
}

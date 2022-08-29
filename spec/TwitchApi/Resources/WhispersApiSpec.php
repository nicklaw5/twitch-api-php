<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class WhispersApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_send_a_whisper(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'whispers', 'TEST_TOKEN', [['key' => 'from_user_id', 'value' => '123'], ['key' => 'to_user_id', 'value' => '456']], [['key' => 'message', 'value' => 'abc']])->willReturn($request);
        $this->sendWhisper('TEST_TOKEN', '123', '456', 'abc')->shouldBe($response);
    }
}

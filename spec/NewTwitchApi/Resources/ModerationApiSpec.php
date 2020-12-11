<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class ModerationApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_check_automod_status(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('POST', 'moderation/enforcements/status?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN', 'Accept' => 'application/json'], json_encode(['msg_id' => '321', 'msg_text' => 'test', 'user_id' => '111'])))->willReturn($response);
        $this->createCustomReward('TEST_TOKEN', '123', '321', 'test', '111')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

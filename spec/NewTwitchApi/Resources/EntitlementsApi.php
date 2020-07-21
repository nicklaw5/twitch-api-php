<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class EntitlementsApiSpec extends ObjectBehavior
{
    public function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    public function it_should_get_code_status(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'entitlements/codes?user_id=123&code=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getCodeStatus('TEST_TOKEN', '123', ['abc'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_redeem_code(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('POST', 'entitlements/code?user_id=123&code=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->redeemCode('TEST_TOKEN', '123', ['abc'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

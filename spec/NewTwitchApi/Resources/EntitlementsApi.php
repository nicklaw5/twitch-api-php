<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class EntitlementsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_get_code_status(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'entitlements/codes?user_id=123&code=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getCodeStatus('TEST_TOKEN', '123', ['abc'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_redeem_code(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('POST', 'entitlements/code?user_id=123&code=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->redeemCode('TEST_TOKEN', '123', ['abc'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_drop_entitlements_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'entitlements/drops?id=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getDropsEntitlements('TEST_TOKEN', 'abc')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_drop_entitlements_by_user_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'entitlements/drops?user_id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getDropsEntitlements('TEST_TOKEN', NULL, '123')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_drop_entitlements_by_user_id_game_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'entitlements/drops?user_id=123&game_id=321', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getDropsEntitlements('TEST_TOKEN', NULL, '123', '321')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_drop_entitlements_by_game_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'entitlements/drops?game_id=321', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getDropsEntitlements('TEST_TOKEN', NULL, NULL, '321')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_drop_entitlements_by_with_all(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'entitlements/drops?user_id=123&game_id=321&after=fff&first=100', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getDropsEntitlements('TEST_TOKEN', NULL, '123', '321', 'fff', 100)->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

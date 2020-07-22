<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class BitsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_getcheermotes(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'bits/cheermotes', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getCheermotes('TEST_TOKEN')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_getcheermotes_by_broadcaster_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'bits/cheermotes?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getCheermotes('TEST_TOKEN', '123')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_extension_transactions(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'extensions/transactions?extension_id=1', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionTransactions('TEST_TOKEN', '1')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_extension_transactions_with_transaction_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'extensions/transactions?extension_id=1&id=321', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionTransactions('TEST_TOKEN', '1', ['321'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_extension_transactions_with_first(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'extensions/transactions?extension_id=1&first=100', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionTransactions('TEST_TOKEN', '1', [], 100)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_extension_transactions_with_after(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'extensions/transactions?extension_id=1&after=100', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getExtensionTransactions('TEST_TOKEN', '1', [], null, 100)->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;

class BitsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_getcheermotes(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'bits/cheermotes', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getCheermotes('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_getcheermotes_by_broadcaster_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'bits/cheermotes', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getCheermotes('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_extension_transactions(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'extensions/transactions', 'TEST_TOKEN', [['key' => 'extension_id', 'value' => '1']], [])->willReturn($request);
        $this->getExtensionTransactions('TEST_TOKEN', '1')->shouldBe($response);
    }

    function it_should_extension_transactions_with_transaction_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'extensions/transactions', 'TEST_TOKEN', [['key' => 'extension_id', 'value' => '1'], ['key' => 'id', 'value' => '321']], [])->willReturn($request);
        $this->getExtensionTransactions('TEST_TOKEN', '1', ['321'])->shouldBe($response);
    }

    function it_should_extension_transactions_with_first(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'extensions/transactions', 'TEST_TOKEN', [['key' => 'extension_id', 'value' => '1'], ['key' => 'first', 'value' => '100']], [])->willReturn($request);
        $this->getExtensionTransactions('TEST_TOKEN', '1', [], 100)->shouldBe($response);
    }

    function it_should_extension_transactions_with_after(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'extensions/transactions', 'TEST_TOKEN', [['key' => 'extension_id', 'value' => '1'], ['key' => 'after', 'value' => '100']], [])->willReturn($request);
        $this->getExtensionTransactions('TEST_TOKEN', '1', [], null, 100)->shouldBe($response);
    }
}

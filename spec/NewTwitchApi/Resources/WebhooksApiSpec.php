<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use NewTwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class WebhooksApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_webhooks_subscriptions(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'webhooks/subscriptions', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getWebhookSubscriptions('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_get_webhooks_subscriptions_with_first(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'webhooks/subscriptions', 'TEST_TOKEN', [['key' => 'first', 'value' => 100]], [])->willReturn($request);
        $this->getWebhookSubscriptions('TEST_TOKEN', 100)->shouldBe($response);
    }

    function it_should_get_webhooks_subscriptions_with_after(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'webhooks/subscriptions', 'TEST_TOKEN', [['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getWebhookSubscriptions('TEST_TOKEN', null, 'abc')->shouldBe($response);
    }

    function it_should_get_webhooks_subscriptions_with_everything(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'webhooks/subscriptions', 'TEST_TOKEN', [['key' => 'first', 'value' => 100], ['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getWebhookSubscriptions('TEST_TOKEN', 100, 'abc')->shouldBe($response);
    }
}

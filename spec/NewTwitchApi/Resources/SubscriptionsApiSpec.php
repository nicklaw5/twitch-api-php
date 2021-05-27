<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class SubscriptionsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_check_user_subscriptions(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'subscriptions/user', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'user_id', 'value' => '456']], [])->willReturn($request);
        $this->checkUserSubscription('TEST_TOKEN', '123', '456')->shouldBe($response);
    }
}

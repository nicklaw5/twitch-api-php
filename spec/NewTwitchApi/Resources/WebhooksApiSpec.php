<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class WebhooksApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_get_user_with_access_token_convenience_method(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'webhooks/subscriptions', ['Authorization' => 'Bearer access-token']))->willReturn($response);
        $this->getWebhookSubscriptions('access-token')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

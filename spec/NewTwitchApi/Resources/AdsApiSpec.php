<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;

class AdsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_start_commercial(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'channels/commercial', 'TEST_TOKEN', [], [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'length', 'value' => 30]])->willReturn($request);
        $this->startCommercial('TEST_TOKEN', '123', 30)->shouldBe($response);
    }
}

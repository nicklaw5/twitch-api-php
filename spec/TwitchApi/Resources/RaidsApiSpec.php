<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class RaidApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_start_a_raid(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'raids', 'TEST_TOKEN', [['key' => 'to_broadcaster_id', 'value' => '123'], ['key' => 'from_broadcaster_id', 'value' => '456']], [])->willReturn($request);
        $this->startRaid('TEST_TOKEN', '123', '456')->shouldBe($response);
    }

    function it_should_cancel_a_raid(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'raids', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->cancelRaid('TEST_TOKEN', '123')->shouldBe($response);
    }
}

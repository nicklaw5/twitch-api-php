<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;

class ChannelsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_channel_info(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channels', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChannelInfo('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_channel_editors(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channels/editors', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChannelEditors('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_modify_channel_with_game_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'channels', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'game_id', 'value' => '0']])->willReturn($request);
        $this->modifyChannelInfo('TEST_TOKEN', '123', ['game_id' => '0'])->shouldBe($response);
    }

    function it_should_modify_channel_with_language(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'channels', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'broadcaster_language', 'value' => 'en']])->willReturn($request);
        $this->modifyChannelInfo('TEST_TOKEN', '123', ['broadcaster_language' => 'en'])->shouldBe($response);
    }

    function it_should_modify_channel_with_title(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'channels', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'title', 'value' => 'test 123']])->willReturn($request);
        $this->modifyChannelInfo('TEST_TOKEN', '123', ['title' => 'test 123'])->shouldBe($response);
    }

    function it_should_modify_channel_with_delay(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'channels', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'delay', 'value' => 5]])->willReturn($request);
        $this->modifyChannelInfo('TEST_TOKEN', '123', ['delay' => 5])->shouldBe($response);
    }

    function it_should_modify_channel_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'channels', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'game_id', 'value' => '0'], ['key' => 'broadcaster_language', 'value' => 'en'], ['key' => 'title', 'value' => 'test 123'], ['key' => 'delay', 'value' => 5]])->willReturn($request);
        $this->modifyChannelInfo('TEST_TOKEN', '123', ['game_id' => '0', 'broadcaster_language' => 'en', 'title' => 'test 123', 'delay' => 5])->shouldBe($response);
    }
}

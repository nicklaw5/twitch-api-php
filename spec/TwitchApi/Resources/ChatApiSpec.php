<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class ChatApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_channel_emotes(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/emotes', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChannelEmotes('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_global_emotes(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/emotes/global', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getGlobalEmotes('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_get_one_emote_set(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/emotes/set', 'TEST_TOKEN', [['key' => 'emote_set_id', 'value' => '123']], [])->willReturn($request);
        $this->getEmoteSets('TEST_TOKEN', ['123'])->shouldBe($response);
    }

    function it_should_get_one_emote_set_with_helper_function(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/emotes/set', 'TEST_TOKEN', [['key' => 'emote_set_id', 'value' => '123']], [])->willReturn($request);
        $this->getEmoteSet('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_multiple_emote_sets(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/emotes/set', 'TEST_TOKEN', [['key' => 'emote_set_id', 'value' => '123'], ['key' => 'emote_set_id', 'value' => '456']], [])->willReturn($request);
        $this->getEmoteSets('TEST_TOKEN', ['123', '456'])->shouldBe($response);
    }

    function it_should_get_channel_chat_badges(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/badges', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChannelChatBadges('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_global_chat_badges(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/badges/global', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getGlobalChatBadges('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_get_chat_settings(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/settings', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChatSettings('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_chat_settings_with_moderator_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/settings', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [])->willReturn($request);
        $this->getChatSettings('TEST_TOKEN', '123', '456')->shouldBe($response);
    }

    function it_should_update_chat_settings_with_one_setting(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'chat/settings', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'emote_mode', 'value' => true]])->willReturn($request);
        $this->updateChatSettings('TEST_TOKEN', '123', '456', ['emote_mode' => true])->shouldBe($response);
    }

    function it_should_update_chat_settings_with_multiple_settings(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'chat/settings', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'emote_mode', 'value' => true], ['key' => 'slow_mode_wait_time', 'value' => 10]])->willReturn($request);
        $this->updateChatSettings('TEST_TOKEN', '123', '456', ['emote_mode' => true, 'slow_mode_wait_time' => 10])->shouldBe($response);
    }

    function it_should_send_a_chat_announcement(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'chat/announcements', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'message', 'value' => 'Hello World']])->willReturn($request);
        $this->sendChatAnnouncement('TEST_TOKEN', '123', '456', 'Hello World')->shouldBe($response);
    }

    function it_should_send_a_chat_announcement_with_a_color(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'chat/announcements', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'message', 'value' => 'Hello World'], ['key' => 'color', 'value' => 'red']])->willReturn($request);
        $this->sendChatAnnouncement('TEST_TOKEN', '123', '456', 'Hello World', 'red')->shouldBe($response);
    }

    function it_should_get_a_users_chat_color(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/color', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123']], [])->willReturn($request);
        $this->getUserChatColor('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_update_a_users_chat_color(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PUT', 'chat/color', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'color', 'value' => 'red']], [])->willReturn($request);
        $this->updateUserChatColor('TEST_TOKEN', '123', 'red')->shouldBe($response);
    }

    function it_should_get_chatters(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/chatters', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [])->willReturn($request);
        $this->getChatters('TEST_TOKEN', '123', '456')->shouldBe($response);
    }

    function it_should_get_chatters_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'chat/chatters', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456'],['key' => 'first', 'value' => 100], ['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getChatters('TEST_TOKEN', '123', '456', 100, 'abc')->shouldBe($response);
    }

    function it_should_send_a_shoutout(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'chat/shoutouts', 'TEST_TOKEN', [['key' => 'from_broadcaster_id', 'value' => '123'], ['key' => 'to_broadcaster_id', 'value' => '456'], ['key' => 'moderator_id', 'value' => '789']], [])->willReturn($request);
        $this->sendShoutout('TEST_TOKEN', '123', '456', '789')->shouldBe($response);
    }
}

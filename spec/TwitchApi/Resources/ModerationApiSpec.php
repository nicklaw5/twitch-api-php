<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class ModerationApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_check_automod_status(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/enforcements/status', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'msg_id', 'value' => '456'], ['key' => 'msg_text', 'value' => 'test 123']])->willReturn($request);
        $this->checkAutoModStatus('TEST_TOKEN', '123', '456', 'test 123')->shouldBe($response);
    }

    function it_should_release_held_message(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/automod/message', 'TEST_TOKEN', [], [['key' => 'user_id', 'value' => '123'], ['key' => 'msg_id', 'value' => '456'], ['key' => 'action', 'value' => 'ALLOW']])->willReturn($request);
        $this->manageHeldAutoModMessage('TEST_TOKEN', '123', '456', 'ALLOW')->shouldBe($response);
    }

    function it_should_ban_a_user(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/bans', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'user_id', 'value' => '789'], ['key' => 'reason', 'value' => 'abc']])->willReturn($request);
        $this->banUser('TEST_TOKEN', '123', '456', '789', 'abc')->shouldBe($response);
    }

    function it_should_ban_a_user_with_a_duration(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/bans', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'user_id', 'value' => '789'], ['key' => 'reason', 'value' => 'abc'], ['key' => 'duration', 'value' => 300]])->willReturn($request);
        $this->banUser('TEST_TOKEN', '123', '456', '789', 'abc', 300)->shouldBe($response);
    }

    function it_should_unban_a_user(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'moderation/bans', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456'], ['key' => 'user_id', 'value' => '789']], [])->willReturn($request);
        $this->unbanUser('TEST_TOKEN', '123', '456', '789')->shouldBe($response);
    }

    function it_should_get_automod_settings(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'moderation/automod/settings', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [])->willReturn($request);
        $this->getAutoModSettings('TEST_TOKEN', '123', '456')->shouldBe($response);
    }

    function it_should_update_automod_settings_with_one_setting(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PUT', 'moderation/automod/settings', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'aggression', 'value' => 1]])->willReturn($request);
        $this->updateAutoModSettings('TEST_TOKEN', '123', '456', ['aggression' => 1])->shouldBe($response);
    }

    function it_should_update_automod_settings_with_multiple_settings(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PUT', 'moderation/automod/settings', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'aggression', 'value' => 1], ['key' => 'bullying', 'value' => 2]])->willReturn($request);
        $this->updateAutoModSettings('TEST_TOKEN', '123', '456', ['aggression' => 1, 'bullying' => 2])->shouldBe($response);
    }

    function it_should_get_blocked_terms(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'moderation/blocked_terms', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [])->willReturn($request);
        $this->getBlockedTerms('TEST_TOKEN', '123', '456')->shouldBe($response);
    }

    function it_should_get_blocked_terms_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'moderation/blocked_terms', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456'], ['key' => 'first', 'value' => 100], ['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getBlockedTerms('TEST_TOKEN', '123', '456', 100, 'abc')->shouldBe($response);
    }

    function it_should_add_a_blocked_term(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'moderation/blocked_terms', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [['key' => 'term', 'value' => 'abc']])->willReturn($request);
        $this->addBlockedTerm('TEST_TOKEN', '123', '456', 'abc')->shouldBe($response);
    }

    function it_should_remove_a_blocked_term(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'moderation/blocked_terms', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456'], ['key' => 'id', 'value' => '789']], [])->willReturn($request);
        $this->removeBlockedTerm('TEST_TOKEN', '123', '456', '789')->shouldBe($response);
    }

    function it_should_delete_chat_messages(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'moderation/chat', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456']], [])->willReturn($request);
        $this->deleteChatMessages('TEST_TOKEN', '123', '456')->shouldBe($response);
    }

    function it_should_delete_chat_messages_with_message_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'moderation/chat', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'moderator_id', 'value' => '456'], ['key' => 'message_id', 'value' => '789']], [])->willReturn($request);
        $this->deleteChatMessages('TEST_TOKEN', '123', '456', '789')->shouldBe($response);
    }
}

<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class UsersApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_user_with_access_token(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getUsers('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_get_user_with_access_token_convenience_method(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getUserByAccessToken('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_get_users_by_ids(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users', 'TEST_TOKEN', [['key' => 'id', 'value' => '12345'], ['key' => 'id', 'value' => '98765']], [])->willReturn($request);
        $this->getUsers('TEST_TOKEN', ['12345', '98765'])->shouldBe($response);
    }

    function it_should_get_users_by_usernames(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users', 'TEST_TOKEN', [['key' => 'login', 'value' => 'twitchuser'], ['key' => 'login', 'value' => 'anotheruser']], [])->willReturn($request);
        $this->getUsers('TEST_TOKEN', [], ['twitchuser', 'anotheruser'])->shouldBe($response);
    }

    function it_should_get_users_by_id_and_username(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users', 'TEST_TOKEN', [['key' => 'id', 'value' => '12345'], ['key' => 'id', 'value' => '98765'], ['key' => 'login', 'value' => 'twitchuser'], ['key' => 'login', 'value' => 'anotheruser']], [])->willReturn($request);
        $this->getUsers('TEST_TOKEN', ['12345', '98765'], ['twitchuser', 'anotheruser'])->shouldBe($response);
    }

    function it_should_get_a_single_user_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users', 'TEST_TOKEN', [['key' => 'id', 'value' => '12345']], [])->willReturn($request);
        $this->getUserById('TEST_TOKEN', '12345')->shouldBe($response);
    }

    function it_should_get_a_single_user_by_username(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users', 'TEST_TOKEN', [['key' => 'login', 'value' => 'twitchuser']], [])->willReturn($request);
        $this->getUserByUsername('TEST_TOKEN', 'twitchuser')->shouldBe($response);
    }

    function it_should_get_users_follows_by_follower_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users/follows', 'TEST_TOKEN', [['key' => 'from_id', 'value' => '12345']], [])->willReturn($request);
        $this->getUsersFollows('TEST_TOKEN', '12345')->shouldBe($response);
    }

    function it_should_get_users_follows_by_followed_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users/follows', 'TEST_TOKEN', [['key' => 'to_id', 'value' => '12345']], [])->willReturn($request);
        $this->getUsersFollows('TEST_TOKEN', null, '12345')->shouldBe($response);
    }

    function it_should_get_users_follows_by_follower_id_and_followed_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users/follows', 'TEST_TOKEN', [['key' => 'from_id', 'value' => '12345'], ['key' => 'to_id', 'value' => '98765']], [])->willReturn($request);
        $this->getUsersFollows('TEST_TOKEN', '12345', '98765')->shouldBe($response);
    }

    function it_should_get_users_follows_page_by_first(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users/follows', 'TEST_TOKEN', [['key' => 'first', 'value' => 42]], [])->willReturn($request);
        $this->getUsersFollows('TEST_TOKEN', null, null, 42)->shouldBe($response);
    }

    function it_should_get_users_follows_page_by_after(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users/follows', 'TEST_TOKEN', [['key' => 'after', 'value' => '42']], [])->willReturn($request);
        $this->getUsersFollows('TEST_TOKEN', null, null, null, '42')->shouldBe($response);
    }

    function it_should_get_users_follows_by_everything(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users/follows', 'TEST_TOKEN', [['key' => 'from_id', 'value' => '12345'], ['key' => 'to_id', 'value' => '98765'], ['key' => 'first', 'value' => 42], ['key' => 'after', 'value' => '99']], [])->willReturn($request);
        $this->getUsersFollows('TEST_TOKEN', '12345', '98765', 42, '99')->shouldBe($response);
    }

    function it_should_create_a_follow(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'users/follows', 'TEST_TOKEN', [['key' => 'from_id', 'value' => '123'], ['key' => 'to_id', 'value' => '321']], [])->willReturn($request);
        $this->createUserFollow('TEST_TOKEN', '123', '321')->shouldBe($response);
    }

    function it_should_create_a_follow_with_notifications(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'users/follows', 'TEST_TOKEN', [['key' => 'from_id', 'value' => '123'], ['key' => 'to_id', 'value' => '321'], ['key' => 'allow_notifications', 'value' => 1]], [])->willReturn($request);
        $this->createUserFollow('TEST_TOKEN', '123', '321', true)->shouldBe($response);
    }

    function it_should_create_a_follow_without_notifications(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'users/follows', 'TEST_TOKEN', [['key' => 'from_id', 'value' => '123'], ['key' => 'to_id', 'value' => '321'], ['key' => 'allow_notifications', 'value' => 0]], [])->willReturn($request);
        $this->createUserFollow('TEST_TOKEN', '123', '321', false)->shouldBe($response);
    }

    function it_should_delete_a_follow(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'users/follows', 'TEST_TOKEN', [['key' => 'from_id', 'value' => '123'], ['key' => 'to_id', 'value' => '321']], [])->willReturn($request);
        $this->deleteUserFollow('TEST_TOKEN', '123', '321')->shouldBe($response);
    }

    function it_should_update_user(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PUT', 'users', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->updateUser('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_update_user_description(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PUT', 'users', 'TEST_TOKEN', [['key' => 'description', 'value' => 'test']], [])->willReturn($request);
        $this->updateUser('TEST_TOKEN', 'test')->shouldBe($response);
    }

    function it_should_get_user_block_list(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users/blocks', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getUserBlockList('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_user_block_list_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'users/blocks', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'first', 'value' => 100], ['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getUserBlockList('TEST_TOKEN', '123', 100, 'abc')->shouldBe($response);
    }

    function it_should_block_user(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PUT', 'users/blocks', 'TEST_TOKEN', [['key' => 'target_user_id', 'value' => '123']], [])->willReturn($request);
        $this->blockUser('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_block_user_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PUT', 'users/blocks', 'TEST_TOKEN', [['key' => 'target_user_id', 'value' => '123'], ['key' => 'source_context', 'value' => 'chat'], ['key' => 'reason', 'value' => 'spam']], [])->willReturn($request);
        $this->blockUser('TEST_TOKEN', '123', 'chat', 'spam')->shouldBe($response);
    }

    function it_should_unblock_user(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'users/blocks', 'TEST_TOKEN', [['key' => 'target_user_id', 'value' => '123']], [])->willReturn($request);
        $this->unblockUser('TEST_TOKEN', '123')->shouldBe($response);
    }
}

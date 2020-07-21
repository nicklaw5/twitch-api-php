<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class UsersApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_get_users_by_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?id=12345&id=98765', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsers('TEST_TOKEN', ['12345', '98765'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_by_usernames(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?login=twitchuser&login=anotheruser', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsers('TEST_TOKEN', [], ['twitchuser', 'anotheruser'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_by_id_and_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?id=12345&id=98765&login=twitchuser&login=anotheruser', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsers('TEST_TOKEN', ['12345', '98765'], ['twitchuser', 'anotheruser'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_a_single_user_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?id=12345', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUserById('TEST_TOKEN', '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_a_single_user_by_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?login=twitchuser', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUserByUsername('TEST_TOKEN', 'twitchuser')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_and_include_email(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?scope=user:read:email', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsers('TEST_TOKEN', [], [], true)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_by_everything_including_email(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?id=12345&id=98765&login=twitchuser&login=anotheruser&scope=user:read:email', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsers('TEST_TOKEN', ['12345', '98765'], ['twitchuser', 'anotheruser'], true)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_by_follower_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?from_id=12345', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsersFollows('TEST_TOKEN', '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_by_followed_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?to_id=12345', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsersFollows('TEST_TOKEN', null, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_by_follower_id_and_followed_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?from_id=12345&to_id=98765', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsersFollows('TEST_TOKEN', '12345', '98765')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_page_by_first(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?first=42', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsersFollows('TEST_TOKEN', null, null, 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_page_by_after(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?after=42', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsersFollows('TEST_TOKEN', null, null, null, 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_by_everything(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?from_id=12345&to_id=98765&first=42&after=99', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsersFollows('TEST_TOKEN', '12345', '98765', 42, 99)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_user_with_access_token(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUsers('TEST_TOKEN')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_user_with_access_token_convenience_method(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getUserByAccessToken('TEST_TOKEN')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_create_a_follow(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('POST', 'users/follows?from_id=123&to_id=321', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->createUserFollow('TEST_TOKEN', '123', '321')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_create_a_follow_with_notifications(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('POST', 'users/follows?from_id=123&to_id=321&allow_notifications=1', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->createUserFollow('TEST_TOKEN', '123', '321', 1)->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

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
        $guzzleClient->send(new Request('GET', 'users?id=12345&id=98765'))->willReturn($response);
        $this->getUsers(['12345','98765'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_by_usernames(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?login=twitchuser&login=anotheruser'))->willReturn($response);
        $this->getUsers([], ['twitchuser','anotheruser'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_by_id_and_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?id=12345&id=98765&login=twitchuser&login=anotheruser'))->willReturn($response);
        $this->getUsers(['12345','98765'], ['twitchuser','anotheruser'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_a_single_user_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?id=12345'))->willReturn($response);
        $this->getUserById('12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_a_single_user_by_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?login=twitchuser'))->willReturn($response);
        $this->getUserByUsername('twitchuser')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_and_include_email(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?scope=user:read:email'))->willReturn($response);
        $this->getUsers([], [], true)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_by_everything_including_email(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users?id=12345&id=98765&login=twitchuser&login=anotheruser&scope=user:read:email'))->willReturn($response);
        $this->getUsers(['12345','98765'], ['twitchuser','anotheruser'], true)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_by_follower_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?from_id=12345'))->willReturn($response);
        $this->getUsersFollows('12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_by_followed_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?to_id=12345'))->willReturn($response);
        $this->getUsersFollows(null, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_by_follower_id_and_followed_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?from_id=12345&to_id=98765'))->willReturn($response);
        $this->getUsersFollows('12345', '98765')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_page_by_first(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?first=42'))->willReturn($response);
        $this->getUsersFollows(null, null, 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_page_by_after(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?after=42'))->willReturn($response);
        $this->getUsersFollows(null, null, null, 42)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_users_follows_by_everything(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users/follows?from_id=12345&to_id=98765&first=42&after=99'))->willReturn($response);
        $this->getUsersFollows('12345', '98765', 42, 99)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_user_with_access_token(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users', ['Authorization' => 'Bearer access-token']))->willReturn($response);
        $this->getUsers([], [], false, 'access-token')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_get_user_with_access_token_convenience_method(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'users', ['Authorization' => 'Bearer access-token']))->willReturn($response);
        $this->getUserByAccessToken('access-token')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

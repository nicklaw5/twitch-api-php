<?php

namespace spec\NewTwitchApi\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;

class OauthApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith('client-id', 'client-secret', $guzzleClient);
    }

    function it_should_get_auth_url(Client $guzzleClient)
    {
        $guzzleClient->getConfig('base_uri')->willReturn('https://id.twitch.tv/oauth2/');
        $this->getAuthUrl('https://redirect.url')->shouldReturn(
            'https://id.twitch.tv/oauth2/authorize?client_id=client-id&redirect_uri=https://redirect.url&response_type=code&scope='
        );
    }

    function it_should_get_access_token(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'POST',
            'token'
        );
        $guzzleClient->send($request, ['json' => [
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'https://redirect.url',
            'code' => 'user-code-from-twitch',
            'state' => null,
        ]])->willReturn($response);

        $this->getUserAccessToken('user-code-from-twitch', 'https://redirect.url')->shouldBe($response);
    }

    function it_should_get_refresh_token(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'POST',
            'token'
        );
        $guzzleClient->send($request, ['json' => [
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'grant_type' => 'refresh_token',
            'refresh_token' => 'user-refresh-token',
        ]])->willReturn($response);

        $this->refreshToken('user-refresh-token')->shouldBe($response);
    }

    function it_should_validate_access_token(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'GET',
            'validate',
            [
                'Authorization' => 'OAuth user-access-token',
            ]
        );
        $guzzleClient->send($request, [])->willReturn($response);

        $this->validateAccessToken('user-access-token')->shouldBe($response);
    }

    function it_should_return_true_if_access_token_is_valid(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'GET',
            'validate',
            [
                'Authorization' => 'OAuth user-access-token',
            ]
        );
        $response->getStatusCode()->willReturn(200);
        $guzzleClient->send($request, [])->willReturn($response);

        $this->isValidAccessToken('user-access-token')->shouldReturn(true);
    }

    function it_should_return_false_if_access_token_is_invalid(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'GET',
            'validate',
            [
                'Authorization' => 'OAuth invalid-user-access-token',
            ]
        );
        $response->getStatusCode()->willReturn(401);
        $guzzleClient->send($request, [])->willReturn($response);

        $this->isValidAccessToken('invalid-user-access-token')->shouldReturn(false);
    }

    function it_should_get_app_access_token(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'POST',
            'token'
        );
        $guzzleClient->send($request, ['json' => [
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'grant_type' => 'client_credentials',
            'scope' => '',
        ]])->willReturn($response);

        $this->getAppAccessToken()->shouldBe($response);
    }
}

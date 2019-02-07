<?php

declare(strict_types=1);

namespace NewTwitchApi\Tests\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\Resources\UsersApi;
use PHPUnit_Framework_TestCase;

class UsersTest extends PHPUnit_Framework_TestCase
{
    public function testGetUserByIdShouldReturnSuccessfulResponseWithUserData(): void
    {
        $users = new UsersApi($this->getGuzzleClientWithMockUserResponse());
        $response = $users->getUserById('44322889');

        $this->assertEquals(200, $response->getStatusCode());
        $contents = json_decode($response->getBody()->getContents());
        $this->assertEquals('dallas', $contents->data[0]->login);
    }

    public function testGetUserByUsernameShouldReturnSuccessfulResponseWithUserData(): void
    {

        $users = new UsersApi($this->getGuzzleClientWithMockUserResponse());
        $response = $users->getUserByUsername('dallas');

        $this->assertEquals(200, $response->getStatusCode());
        $contents = json_decode($response->getBody()->getContents());
        $this->assertEquals(44322889, $contents->data[0]->id);
    }

    private function getGuzzleClientWithMockUserResponse(): Client
    {
        // Example response from https://dev.twitch.tv/docs/api/reference/#get-users
        $getUserReponseJson = <<<JSON
{
  "data": [{
    "id": "44322889",
    "login": "dallas",
    "display_name": "dallas",
    "type": "staff",
    "broadcaster_type": "",
    "description": "Just a gamer playing games and chatting. :)",
    "profile_image_url": "https://static-cdn.jtvnw.net/jtv_user_pictures/dallas-profile_image-1a2c906ee2c35f12-300x300.png",
    "offline_image_url": "https://static-cdn.jtvnw.net/jtv_user_pictures/dallas-channel_offline_image-1a2c906ee2c35f12-1920x1080.png",
    "view_count": 191836881,
    "email": "login@provider.com"
  }]
}
JSON;

        $db_response = new Response(200, [], $getUserReponseJson);
        $mock = new MockHandler([ $db_response, $db_response ]);
        $handler = HandlerStack::create($mock);
        return new Client(['handler' => $handler]);
    }
}

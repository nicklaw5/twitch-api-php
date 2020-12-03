<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class ChannelPointsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_custom_reward(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'channel_points/custom_rewards?broadcaster_id=123', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getCustomReward('TEST_TOKEN', '123')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_custom_reward_with_everything(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'channel_points/custom_rewards?broadcaster_id=123&id=321&only_manageable_rewards=1', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getCustomReward('TEST_TOKEN', '123', ['321'], true)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_custom_reward_redemption(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'channel_points/custom_rewards/redemptions?broadcaster_id=123&reward_id=321', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getCustomRewardRedemption('TEST_TOKEN', '123', '321')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_custom_reward_redemption_with_reward_everything(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'channel_points/custom_rewards/redemptions?broadcaster_id=123&reward_id=321&status=UNFULFILLED&sort=OLDEST&after=abc&first=50', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getCustomRewardRedemption('TEST_TOKEN', '123', '321', [], 'UNFULFILLED', 'OLDEST', 'abc', '50')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_custom_reward_redemption_with_id_everything(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'channel_points/custom_rewards/redemptions?broadcaster_id=123&id=321&id=333&status=UNFULFILLED&sort=OLDEST&after=abc&first=50', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getCustomRewardRedemption('TEST_TOKEN', '123', null, ['321', '333'], 'UNFULFILLED', 'OLDEST', 'abc', '50')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

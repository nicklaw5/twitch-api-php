<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class EventSubApiSpec extends ObjectBehavior
{
    private string $bearer = 'TEST_TOKEN';
    private string $secret = 'SECRET';
    private string $callback = 'https://example.com/';

    private function generateRequest(string $type, string $version, array $condition): Request {
        $bodyParams = [];

        $bodyParams['type'] = $type;
        $bodyParams['version'] = $version;
        $bodyParams['condition'] = $condition;
        $bodyParams['transport'] = [
          'method' => 'webhook',
          'callback' => $this->callback,
          'secret' => $this->secret,
        ];

        return new Request('POST', 'eventsub/subscriptions', ['Authorization' => sprintf('Bearer %s', $this->bearer)], json_encode($bodyParams));
    }

    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_should_subscribe_to_channel_update(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.update', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelUpdate($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_follow(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.follow', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelFollow($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_subscribe(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.subscribe', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelSubscribe($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_cheer(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.cheer', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelCheer($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_raid(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.raid', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelRaid($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_ban(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.ban', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelBan($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_unban(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.unban', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelUnban($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_moderator_add(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.moderator.add', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelModeratorAdd($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_moderator_remove(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.moderator.remove', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelModeratorRemove($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_points_custom_reward_add(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.channel_points_custom_reward.add', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelPointsCustomRewardAdd($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_points_custom_reward_update(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.channel_points_custom_reward.update', '1', ['broadcaster_user_id' => '12345', 'reward_id' => '67890']))->willReturn($response);
        $this->subscribeToChannelPointsCustomRewardUpdate($this->bearer, $this->secret, $this->callback, '12345', '67890')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_points_custom_reward_remove(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.channel_points_custom_reward.remove', '1', ['broadcaster_user_id' => '12345', 'reward_id' => '67890']))->willReturn($response);
        $this->subscribeToChannelPointsCustomRewardRemove($this->bearer, $this->secret, $this->callback, '12345', '67890')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_points_custom_reward_redemption_add(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.channel_points_custom_reward_redemption.add', '1', ['broadcaster_user_id' => '12345', 'reward_id' => '67890']))->willReturn($response);
        $this->subscribeToChannelPointsCustomRewardRedemptionAdd($this->bearer, $this->secret, $this->callback, '12345', '67890')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_points_custom_reward_redemption_update(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.channel_points_custom_reward_redemption.update', '1', ['broadcaster_user_id' => '12345', 'reward_id' => '67890']))->willReturn($response);
        $this->subscribeToChannelPointsCustomRewardRedemptionUpdate($this->bearer, $this->secret, $this->callback, '12345', '67890')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_hype_train_begin(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.hype_train.begin', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelHypeTrainBegin($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_hype_train_progress(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.hype_train.progress', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelHypeTrainProgress($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_channel_hype_train_end(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('channel.hype_train.end', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToChannelHypeTrainEnd($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_stream_online(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('stream.online', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToStreamOnline($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_stream_offline(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('stream.offline', '1', ['broadcaster_user_id' => '12345']))->willReturn($response);
        $this->subscribeToStreamOffline($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    function it_should_subscribe_to_user_update(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send($this->generateRequest('stream.offline', '1', ['user_id' => '12345']))->willReturn($response);
        $this->subscribeToUserUpdate($this->bearer, $this->secret, $this->callback, '12345')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}

<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class EventSubApiSpec extends ObjectBehavior
{
    private string $bearer = 'TEST_TOKEN';
    private string $secret = 'SECRET';
    private string $callback = 'https://example.com/';

    private function createEventSubSubscription(string $type, string $version, array $condition, RequestGenerator $requestGenerator, bool $isBatchingEnabled = null)
    {
        $bodyParams = [];

        $bodyParams[] = ['key' => 'type', 'value' => $type];
        $bodyParams[] = ['key' => 'version', 'value' => $version];
        $bodyParams[] = ['key' => 'condition', 'value' => $condition];
        $bodyParams[] = [
            'key' => 'transport',
            'value' => [
                'method' => 'webhook',
                'callback' => $this->callback,
                'secret' => $this->secret,
            ],
        ];

        if (null !== $isBatchingEnabled) {
            $bodyParams[] = ['key' => 'is_batching_enabled', 'value' => $isBatchingEnabled];
        }

        return $requestGenerator->generate('POST', 'eventsub/subscriptions', $this->bearer, [], $bodyParams);
    }

    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_event_sub_subscription(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'eventsub/subscriptions', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->getEventSubSubscription('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_get_event_sub_subscription_with_status(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'eventsub/subscriptions', 'TEST_TOKEN', [['key' => 'status', 'value' => 'enabled']], [])->willReturn($request);
        $this->getEventSubSubscription('TEST_TOKEN', 'enabled')->shouldBe($response);
    }

    function it_should_get_event_sub_subscription_with_type(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'eventsub/subscriptions', 'TEST_TOKEN', [['key' => 'type', 'value' => 'channel.update']], [])->willReturn($request);
        $this->getEventSubSubscription('TEST_TOKEN', null, 'channel.update')->shouldBe($response);
    }

    function it_should_get_event_sub_subscription_with_user_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'eventsub/subscriptions', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '789']], [])->willReturn($request);
        $this->getEventSubSubscription('TEST_TOKEN', null, null, null, '789')->shouldBe($response);
    }

    function it_should_get_event_sub_subscription_with_after(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'eventsub/subscriptions', 'TEST_TOKEN', [['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getEventSubSubscription('TEST_TOKEN', null, null, 'abc')->shouldBe($response);
    }

    function it_should_delete_event_sub_subscription(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'eventsub/subscriptions', 'TEST_TOKEN', [['key' => 'id', 'value' => '123']], [])->willReturn($request);
        $this->deleteEventSubSubscription('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_update(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.update', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelUpdate($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_follow(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.follow', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelFollow($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_subscribe(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.subscribe', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelSubscribe($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_subscription_end(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.subscription.end', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelSubscriptionEnd($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_subscription_gift(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.subscription.gift', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelSubscriptionGift($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_subscription_message(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.subscription.message', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelSubscriptionMessage($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_cheer(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.cheer', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelCheer($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_raid(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.raid', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelRaid($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_ban(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.ban', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelBan($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_unban(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.unban', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelUnban($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_moderator_add(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.moderator.add', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelModeratorAdd($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_moderator_remove(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.moderator.remove', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelModeratorRemove($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_points_custom_reward_add(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.channel_points_custom_reward.add', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPointsCustomRewardAdd($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_points_custom_reward_update(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.channel_points_custom_reward.update', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPointsCustomRewardUpdate($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_points_custom_reward_remove(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.channel_points_custom_reward.remove', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPointsCustomRewardRemove($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_points_custom_reward_redemption_add(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.channel_points_custom_reward_redemption.add', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPointsCustomRewardRedemptionAdd($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_points_custom_reward_redemption_update(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.channel_points_custom_reward_redemption.update', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPointsCustomRewardRedemptionUpdate($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_poll_begin(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.poll.begin', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPollBegin($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_poll_progress(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.poll.progress', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPollProgress($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_poll_endn(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.poll.end', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPollEnd($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_prediction_begin(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.prediction.begin', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPredictionBegin($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_prediction_progress(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.prediction.progress', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPredictionProgress($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_prediction_lock(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.prediction.lock', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPredictionLock($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_prediction_endn(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.prediction.end', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelPredictionEnd($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_hype_train_begin(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.hype_train.begin', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelHypeTrainBegin($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_hype_train_progress(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.hype_train.progress', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelHypeTrainProgress($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_hype_train_end(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.hype_train.end', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelHypeTrainEnd($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_stream_online(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('stream.online', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToStreamOnline($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_stream_offline(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('stream.offline', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToStreamOffline($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_user_update(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('user.update', '1', ['user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToUserUpdate($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_extension_bits_transaction_create(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('extension.bits_transaction.create', '1', ['extension_client_id' => 'deadbeef'], $requestGenerator)->willReturn($request);
        $this->subscribeToExtensionBitsTransactionCreate($this->bearer, $this->secret, $this->callback, 'deadbeef')->shouldBe($response);
    }

    function it_should_subscribe_to_user_authorization_revoke(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('user.authorization.revoke', '1', ['client_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToUserAuthorizationRevoke($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_user_authorization_grant(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('user.authorization.grant', '1', ['client_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToUserAuthorizationGrant($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_goal_begin(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.goal.begin', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelGoalBegin($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_goal_progress(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.goal.progress', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelGoalProgress($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_goal_end(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.goal.end', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelGoalEnd($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_drop_entitelement_grant(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('drop.entitlement.grant', '1', ['organization_id' => '12345'], $requestGenerator, true)->willReturn($request);
        $this->subscribeToDropEntitlementGrant($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_drop_entitelement_grant_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('drop.entitlement.grant', '1', ['organization_id' => '123', 'category_id' => '456', 'campaign_id' => '789'], $requestGenerator, true)->willReturn($request);
        $this->subscribeToDropEntitlementGrant($this->bearer, $this->secret, $this->callback, '123', '456', '789')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_charity_campaign_start(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.charity_campaign.start', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelCharityCampaignStart($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_charity_campaign_progress(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.charity_campaign.progress', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelCharityCampaignProgress($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_charity_campaign_stop(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.charity_campaign.stop', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelCharityCampaignStop($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_charity_campaign_donate(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.charity_campaign.donate', '1', ['broadcaster_user_id' => '12345'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelCharityCampaignDonate($this->bearer, $this->secret, $this->callback, '12345')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_shield_mode_begin(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.shield_mode.begin', '1', ['broadcaster_user_id' => '12345', 'moderator_user_id' => '54321'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelShieldModeBegin($this->bearer, $this->secret, $this->callback, '12345', '54321')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_shield_mode_end(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.shield_mode.end', '1', ['broadcaster_user_id' => '12345', 'moderator_user_id' => '54321'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelShieldModeEnd($this->bearer, $this->secret, $this->callback, '12345', '54321')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_shoutout_create(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.shoutout.create', '1', ['broadcaster_user_id' => '12345', 'moderator_user_id' => '54321'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelShoutoutCreate($this->bearer, $this->secret, $this->callback, '12345', '54321')->shouldBe($response);
    }

    function it_should_subscribe_to_channel_shoutout_receive(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->createEventSubSubscription('channel.shoutout.receive', '1', ['broadcaster_user_id' => '12345', 'moderator_user_id' => '54321'], $requestGenerator)->willReturn($request);
        $this->subscribeToChannelShoutoutReceive($this->bearer, $this->secret, $this->callback, '12345', '54321')->shouldBe($response);
    }
}

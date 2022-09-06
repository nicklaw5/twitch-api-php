<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class EventSubApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-eventsub-subscriptions
     */
    public function getEventSubSubscription(string $bearer, string $status = null, string $type = null, string $after = null, string $userId = null): ResponseInterface
    {
        $queryParamsMap = [];

        if ($status) {
            $queryParamsMap[] = ['key' => 'status', 'value' => $status];
        }

        if ($type) {
            $queryParamsMap[] = ['key' => 'type', 'value' => $type];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        if ($userId) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        }

        return $this->getApi('eventsub/subscriptions', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#create-eventsub-subscription
     */
    public function createEventSubSubscription(string $bearer, string $secret, string $callback, string $type, string $version, array $condition): ResponseInterface
    {
        $bodyParams = [];

        $bodyParams[] = ['key' => 'type', 'value' => $type];
        $bodyParams[] = ['key' => 'version', 'value' => $version];
        $bodyParams[] = ['key' => 'condition', 'value' => $condition];
        $bodyParams[] = [
            'key' => 'transport',
            'value' => [
                'method' => 'webhook',
                'callback' => $callback,
                'secret' => $secret,
            ],
        ];

        return $this->postApi('eventsub/subscriptions', $bearer, [], $bodyParams);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#delete-eventsub-subscription
     */
    public function deleteEventSubSubscription(string $bearer, string $id): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'id', 'value' => $id];

        return $this->deleteApi('eventsub/subscriptions', $bearer, $queryParamsMap);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelupdate
     */
    public function subscribeToChannelUpdate(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'channel.update',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelfollow
     */
    public function subscribeToChannelFollow(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'channel.follow',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelsubscribe
     */
    public function subscribeToChannelSubscribe(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'channel.subscribe',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelsubscriptionend
     */
    public function subscribeToChannelSubscriptionEnd(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'channel.subscription.end',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelsubscriptiongift
     */
    public function subscribeToChannelSubscriptionGift(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'channel.subscription.gift',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelsubscriptionmessage
     */
    public function subscribeToChannelSubscriptionMessage(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'channel.subscription.message',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelcheer
     */
    public function subscribeToChannelCheer(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'channel.cheer',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelraid
     */
    public function subscribeToChannelRaid(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'channel.raid',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelban
     */
    public function subscribeToChannelBan(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'channel.ban',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelunban
     */
    public function subscribeToChannelUnban(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'channel.unban',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelmoderatoradd
     */
    public function subscribeToChannelModeratorAdd(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelModerator($bearer, $secret, $callback, $twitchId, 'add');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelmoderatorremove
     */
    public function subscribeToChannelModeratorRemove(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelModerator($bearer, $secret, $callback, $twitchId, 'remove');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelchannel_points_custom_rewardadd
     */
    public function subscribeToChannelPointsCustomRewardAdd(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelPointsCustomReward($bearer, $secret, $callback, $twitchId, null, 'add');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelchannel_points_custom_rewardupdate
     */
    public function subscribeToChannelPointsCustomRewardUpdate(string $bearer, string $secret, string $callback, string $twitchId, string $rewardId = null): ResponseInterface
    {
        return $this->subscribeToChannelPointsCustomReward($bearer, $secret, $callback, $twitchId, $rewardId, 'update');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelchannel_points_custom_rewardremove
     */
    public function subscribeToChannelPointsCustomRewardRemove(string $bearer, string $secret, string $callback, string $twitchId, string $rewardId = null): ResponseInterface
    {
        return $this->subscribeToChannelPointsCustomReward($bearer, $secret, $callback, $twitchId, $rewardId, 'remove');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelchannel_points_custom_reward_redemptionadd
     */
    public function subscribeToChannelPointsCustomRewardRedemptionAdd(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelPointsCustomRewardRedemption($bearer, $secret, $callback, $twitchId, null, 'add');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelchannel_points_custom_reward_redemptionupdate
     */
    public function subscribeToChannelPointsCustomRewardRedemptionUpdate(string $bearer, string $secret, string $callback, string $twitchId, string $rewardId = null): ResponseInterface
    {
        return $this->subscribeToChannelPointsCustomRewardRedemption($bearer, $secret, $callback, $twitchId, $rewardId, 'update');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelpollbegin
     */
    public function subscribeToChannelPollBegin(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelPoll($bearer, $secret, $callback, $twitchId, 'begin');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelpollprogress
     */
    public function subscribeToChannelPollProgress(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelPoll($bearer, $secret, $callback, $twitchId, 'progress');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelpollend
     */
    public function subscribeToChannelPollEnd(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelPoll($bearer, $secret, $callback, $twitchId, 'end');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelpredictionbegin
     */
    public function subscribeToChannelPredictionBegin(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelPrediction($bearer, $secret, $callback, $twitchId, 'begin');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelpredictionprogress
     */
    public function subscribeToChannelPredictionProgress(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelPrediction($bearer, $secret, $callback, $twitchId, 'progress');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelpredictionprogress
     */
    public function subscribeToChannelPredictionLock(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelPrediction($bearer, $secret, $callback, $twitchId, 'lock');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelpredictionend
     */
    public function subscribeToChannelPredictionEnd(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelPrediction($bearer, $secret, $callback, $twitchId, 'end');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainbegin
     */
    public function subscribeToChannelHypeTrainBegin(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelHypeTrain($bearer, $secret, $callback, $twitchId, 'begin');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainprogress
     */
    public function subscribeToChannelHypeTrainProgress(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelHypeTrain($bearer, $secret, $callback, $twitchId, 'progress');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainend
     */
    public function subscribeToChannelHypeTrainEnd(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelHypeTrain($bearer, $secret, $callback, $twitchId, 'end');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#streamonline
     */
    public function subscribeToStreamOnline(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToStream($bearer, $secret, $callback, $twitchId, 'online');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#streamoffline
     */
    public function subscribeToStreamOffline(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToStream($bearer, $secret, $callback, $twitchId, 'offline');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#userauthorizationrevoke
     */
    public function subscribeToUserAuthorizationRevoke(string $bearer, string $secret, string $callback, string $clientId): ResponseInterface
    {
        return $this->subscribeToUserAuthorization($bearer, $secret, $callback, $clientId, 'revoke');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#userauthorizationgrant
     */
    public function subscribeToUserAuthorizationGrant(string $bearer, string $secret, string $callback, string $clientId): ResponseInterface
    {
        return $this->subscribeToUserAuthorization($bearer, $secret, $callback, $clientId, 'grant');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#userupdate
     */
    public function subscribeToUserUpdate(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'user.update',
            '1',
            ['user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#extensionbits_transactioncreate
     */
    public function subscribeToExtensionBitsTransactionCreate(string $bearer, string $secret, string $callback, string $extensionClientId): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'extension.bits_transaction.create',
            '1',
            ['extension_client_id' => $extensionClientId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelgoalbegin
     */
    public function subscribeToChannelGoalBegin(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelGoal($bearer, $secret, $callback, $twitchId, 'begin');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelgoalprogress
     */
    public function subscribeToChannelGoalProgress(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelGoal($bearer, $secret, $callback, $twitchId, 'progress');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelgoalend
     */
    public function subscribeToChannelGoalEnd(string $bearer, string $secret, string $callback, string $twitchId): ResponseInterface
    {
        return $this->subscribeToChannelGoal($bearer, $secret, $callback, $twitchId, 'end');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#dropentitlementgrant
     */
    public function subscribeToDropEntitlementGrant(string $bearer, string $secret, string $callback, string $organizationId, string $categoryId = null, string $campaign_id = null): ResponseInterface
    {
        $condition = ['organization_id' => $organizationId];
        if ($categoryId) {
            $condition['category_id'] = $categoryId;
        }
        if ($campaign_id) {
            $condition['campaign_id'] = $campaign_id;
        }

        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            'drop.entitlement.grant',
            '1',
            $condition,
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub#verify-a-signature
     */
    public function verifySignature(string $signature, string $secret, string $messageId, string $timestamp, string $body): bool
    {
        [$hashAlgorithm, $expectedHash] = explode('=', $signature);
        $generatedHash = hash_hmac($hashAlgorithm, $messageId.$timestamp.$body, $secret);

        return $expectedHash === $generatedHash;
    }

    private function subscribeToChannelModerator(string $bearer, string $secret, string $callback, string $twitchId, string $eventType): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            sprintf('channel.moderator.%s', $eventType),
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    private function subscribeToChannelPointsCustomReward(string $bearer, string $secret, string $callback, string $twitchId, string $rewardId = null, string $eventType): ResponseInterface
    {
        $condition = ['broadcaster_user_id' => $twitchId];

        if ($rewardId) {
            $condition['reward_id'] = $rewardId;
        }

        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            sprintf('channel.channel_points_custom_reward.%s', $eventType),
            '1',
            $condition,
        );
    }

    private function subscribeToChannelPointsCustomRewardRedemption(string $bearer, string $secret, string $callback, string $twitchId, string $rewardId = null, string $eventType): ResponseInterface
    {
        $condition = ['broadcaster_user_id' => $twitchId];

        if ($rewardId) {
            $condition['reward_id'] = $rewardId;
        }

        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            sprintf('channel.channel_points_custom_reward_redemption.%s', $eventType),
            '1',
            $condition,
        );
    }

    private function subscribeToChannelPoll(string $bearer, string $secret, string $callback, string $twitchId, string $eventType): ResponseInterface
    {
        $condition = ['broadcaster_user_id' => $twitchId];

        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            sprintf('channel.poll.%s', $eventType),
            '1',
            $condition,
        );
    }

    private function subscribeToChannelPrediction(string $bearer, string $secret, string $callback, string $twitchId, string $eventType): ResponseInterface
    {
        $condition = ['broadcaster_user_id' => $twitchId];

        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            sprintf('channel.prediction.%s', $eventType),
            '1',
            $condition,
        );
    }

    private function subscribeToChannelHypeTrain(string $bearer, string $secret, string $callback, string $twitchId, string $eventType): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            sprintf('channel.hype_train.%s', $eventType),
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    private function subscribeToStream(string $bearer, string $secret, string $callback, string $twitchId, string $eventType): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            sprintf('stream.%s', $eventType),
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    private function subscribeToUserAuthorization(string $bearer, string $secret, string $callback, string $clientId, string $eventType): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            sprintf('user.authorization.%s', $eventType),
            '1',
            ['client_id' => $clientId],
        );
    }

    private function subscribeToChannelGoal(string $bearer, string $secret, string $callback, string $twitchId, string $eventType): ResponseInterface
    {
        return $this->createEventSubSubscription(
            $bearer,
            $secret,
            $callback,
            sprintf('channel.goal.%s', $eventType),
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }
}

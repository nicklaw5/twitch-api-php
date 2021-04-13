<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;

class EventSubApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/eventsub
     */
    private function subscribe(string $bearer, string $secret, string $callback, string $type, string $version, array $condition): void
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

        $this->postApi('eventsub/subscriptions', $bearer, [], $bodyParams);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelupdate
     */
    public function subscribeToChannelUpdate(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribe(
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
    public function subscribeToChannelFollow(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribe(
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
    public function subscribeToChannelSubscribe(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribe(
            $bearer,
            $secret,
            $callback,
            'channel.subscribe',
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelcheer
     */
    public function subscribeToChannelCheer(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribe(
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
    public function subscribeToChannelRaid(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribe(
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
    public function subscribeToChannelBan(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribe(
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
    public function subscribeToChannelUnban(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribe(
            $bearer,
            $secret,
            $callback,
            'channel.unban',
            '1',
            ['to_broadcaster_user_id' => $twitchId],
        );
    }

    private function subscribeToChannelModerator(string $bearer, string $secret, string $callback, string $twitchId, string $eventType): void
    {
        $this->subscribe(
            $bearer,
            $secret,
            $callback,
            sprintf('channel.moderator.%s', $eventType),
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelmoderatoradd
     */
    public function subscribeToChannelModeratorAdd(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribeToChannelModerator($twitchId, 'add', $callback, $bearer, $secret);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelmoderatorremove
     */
    public function subscribeToChannelModeratorRemove(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribeToChannelModerator($twitchId, 'remove', $callback, $bearer, $secret);
    }

    private function subscribeToChannelHypeTrain(string $bearer, string $secret, string $callback, string $twitchId, string $eventType): void
    {
        $this->subscribe(
            $bearer,
            $secret,
            $callback,
            sprintf('channel.hype_train.%s', $eventType),
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainbegin
     */
    public function subscribeToChannelHypeTrainBegin(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribeToChannelHypeTrain($bearer, $secret, $callback, $twitchId, 'begin');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainprogress
     */
    public function subscribeToChannelHypeTrainProgress(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribeToChannelHypeTrain($bearer, $secret, $callback, $twitchId, 'progress');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainend
     */
    public function subscribeToChannelHypeTrainEnd(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribeToChannelHypeTrain($bearer, $secret, $callback, $twitchId, 'end');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#stream-subscriptions
     */
    private function subscribeToStream(string $bearer, string $secret, string $callback, string $twitchId, string $eventType): void
    {
        $this->subscribe(
            $bearer,
            $secret,
            $callback,
            sprintf('stream.%s', $eventType),
            '1',
            ['broadcaster_user_id' => $twitchId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#streamonline
     */
    public function subscribeToStreamOnline(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribeToStream($bearer, $secret, $callback, $twitchId, 'online');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#streamoffline
     */
    public function subscribeToStreamOffline(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribeToStream($bearer, $secret, $callback, $twitchId, 'offline');
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#userauthorizationrevoke
     */
    public function subscribeToUserAuthorizationRevoke(string $bearer, string $secret, string $callback, string $clientId): void
    {
        $this->subscribe(
            $bearer,
            $secret,
            $callback,
            'user.authorization.revoke',
            '1',
            ['client_id' => $clientId],
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#userupdate
     */
    public function subscribeToUserUpdate(string $bearer, string $secret, string $callback, string $twitchId): void
    {
        $this->subscribe(
            $bearer,
            $secret,
            $callback,
            'user.update',
            '1',
            ['user_id' => $twitchId],
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
}

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
    private function subscribe(string $type, string $version, array $condition, string $callback, string $bearer, string $secret): void
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
    public function subscribeToChannelUpdate(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribe(
            'channel.update',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelfollow
     */
    public function subscribeToChannelFollow(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribe(
            'channel.follow',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelsubscribe
     */
    public function subscribeToChannelSubscribe(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribe(
            'channel.subscribe',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelcheer
     */
    public function subscribeToChannelCheer(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribe(
            'channel.cheer',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelraid
     */
    public function subscribeToChannelRaid(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribe(
            'channel.raid',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelban
     */
    public function subscribeToChannelBan(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribe(
            'channel.ban',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelunban
     */
    public function subscribeToChannelUnban(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribe(
            'channel.unban',
            '1',
            ['to_broadcaster_user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    private function subscribeToChannelModerator(string $twitchId, string $event, string $callback, string $bearer, string $secret): void
    {
        if (!in_array($event, ['add', 'remove'])) {
            throw new \InvalidArgumentException('Invalid value for channel.moderator event type. Accepted values: add,remove.');
        }

        $this->subscribe(
            sprintf('channel.hype_train.%s', $event),
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelmoderatoradd
     */
    public function subscribeToChannelModeratorAdd(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribeToChannelModerator($twitchId, 'add', $callback, $bearer, $secret);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelmoderatorremove
     */
    public function subscribeToChannelModeratorRemove(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribeToChannelModerator($twitchId, 'remove', $callback, $bearer, $secret);
    }

    private function subscribeToChannelHypeTrain(string $twitchId, string $event, string $callback, string $bearer, string $secret): void
    {
        if (!in_array($event, ['begin', 'progress', 'end'])) {
            throw new \InvalidArgumentException('Invalid value for channel_hype_train event type. Accepted values: begin,progress,end.');
        }

        $this->subscribe(
            sprintf('channel.hype_train.%s', $event),
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainbegin
     */
    public function subscribeToChannelHypeTrainBegin(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribeToChannelHypeTrain($twitchId, 'begin', $callback, $bearer, $secret);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainprogress
     */
    public function subscribeToChannelHypeTrainProgress(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribeToChannelHypeTrain($twitchId, 'progress', $callback, $bearer, $secret);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainend
     */
    public function subscribeToChannelHypeTrainEnd(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribeToChannelHypeTrain($twitchId, 'end', $callback, $bearer, $secret);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#stream-subscriptions
     */
    private function subscribeToStream(string $twitchId, string $event, string $callback, string $bearer, string $secret): void
    {
        if (!in_array($event, ['online', 'offline'])) {
            throw new \InvalidArgumentException('Invalid value for stream event type. Accepted values: online,offline.');
        }

        $this->subscribe(
            sprintf('stream.%s', $event),
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#streamonline
     */
    public function subscribeToStreamOnline(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribeToStream($twitchId, 'online', $callback, $bearer, $secret);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#streamoffline
     */
    public function subscribeToStreamOffline(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribeToStream($twitchId, 'offline', $callback, $bearer, $secret);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#userauthorizationrevoke
     */
    public function subscribeToUserAuthorizationRevoke(string $callback, string $bearer, string $secret): void
    {
        $this->subscribe(
            'user.authorization.revoke',
            '1',
            ['client_id' => $this->clientId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#userupdate
     */
    public function subscribeToUserUpdate(string $twitchId, string $callback, string $bearer, string $secret): void
    {
        $this->subscribe(
            'user.update',
            '1',
            ['user_id' => $twitchId],
            $callback,
            $bearer,
            $secret
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub#verify-a-signature
     */
    public function verifySignature(string $signature, string $messageId, string $timestamp, string $body, string $secret): bool
    {
        [$hashAlgorithm, $expectedHash] = explode('=', $signature);
        $generatedHash = hash_hmac($hashAlgorithm, $messageId.$timestamp.$body, $secret);

        return $expectedHash === $generatedHash;
    }
}

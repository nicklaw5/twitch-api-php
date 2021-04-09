<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use NewTwitchApi\HelixGuzzleClient;

class EventSubApi
{
    private $clientId;
    private $secret;
    private $guzzleClient;

    public function __construct(string $clientId, string $secret, Client $guzzleClient = null)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->guzzleClient = $guzzleClient ?? new HelixGuzzleClient($clientId);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/eventsub
     */
    private function subscribe(string $type, string $version, array $condition, string $callback, string $bearer): void
    {
        $headers = [
            'Client-ID' => $this->clientId,
        ];

        $headers['Authorization'] = sprintf('Bearer %s', $bearer);

        $body = [
            'type' => $type,
            'version' => $version,
            'condition' => $condition,
            'transport' => [
                'method' => 'webhook',
                'callback' => $callback,
                'secret' => $this->secret,
            ],
        ];

        $this->guzzleClient->post('eventsub/subscriptions', [
            'headers' => $headers,
            'body' => json_encode($body),
        ]);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelupdate
     */
    public function subscribeToChannelUpdate(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribe(
            'channel.update',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelfollow
     */
    public function subscribeToChannelFollow(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribe(
            'channel.follow',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelsubscribe
     */
    public function subscribeToChannelSubscribe(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribe(
            'channel.subscribe',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelcheer
     */
    public function subscribeToChannelCheer(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribe(
            'channel.cheer',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelraid
     */
    public function subscribeToChannelRaid(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribe(
            'channel.raid',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelban
     */
    public function subscribeToChannelBan(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribe(
            'channel.ban',
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelunban
     */
    public function subscribeToChannelUnban(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribe(
            'channel.unban',
            '1',
            ['to_broadcaster_user_id' => $twitchId],
            $callback,
            $bearer
        );
    }

    private function subscribeToChannelHypeTrain(string $twitchId, string $event, string $callback, string $bearer): void
    {
        if (!in_array($event, ['begin', 'progress', 'end'])) {
            throw new \InvalidArgumentException('Invalid value for channel_hype_train event type. Accepted values: begin,progress,end.');
        }

        $this->subscribe(
            sprintf('channel.hype_train.%s', $event),
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainbegin
     */
    public function subscribeToChannelHypeTrainBegin(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribeToChannelHypeTrain($twitchId, 'begin', $callback, $bearer);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainprogress
     */
    public function subscribeToChannelHypeTrainProgress(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribeToChannelHypeTrain($twitchId, 'progress', $callback, $bearer);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channelhype_trainend
     */
    public function subscribeToChannelHypeTrainEnd(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribeToChannelHypeTrain($twitchId, 'end', $callback, $bearer);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#stream-subscriptions
     */
    private function subscribeToStream(string $twitchId, string $event, string $callback, string $bearer): void
    {
        if (!in_array($event, ['online', 'offline'])) {
            throw new \InvalidArgumentException('Invalid value for stream event type. Accepted values: online,offline.');
        }

        $this->subscribe(
            sprintf('stream.%s', $event),
            '1',
            ['broadcaster_user_id' => $twitchId],
            $callback,
            $bearer
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#streamonline
     */
    public function subscribeToStreamOnline(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribeToStream($twitchId, 'online', $callback, $bearer);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#streamoffline
     */
    public function subscribeToStreamOffline(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribeToStream($twitchId, 'offline', $callback, $bearer);
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#userauthorizationrevoke
     */
    public function subscribeToUserAuthorizationRevoke(string $callback, string $bearer): void
    {
        $this->subscribe(
            'user.authorization.revoke',
            '1',
            ['client_id' => $this->clientId],
            $callback,
            $bearer
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#userupdate
     */
    public function subscribeToUserUpdate(string $twitchId, string $callback, string $bearer): void
    {
        $this->subscribe(
            'user.update',
            '1',
            ['user_id' => $twitchId],
            $callback,
            $bearer
        );
    }

    /**
     * @link https://dev.twitch.tv/docs/eventsub#verify-a-signature
     */
    public function verifySignature(string $signature, string $messageId, string $timestamp, string $body): bool
    {
        [$hashAlgorithm, $expectedHash] = explode('=', $signature);
        $generatedHash = hash_hmac($hashAlgorithm, $messageId.$timestamp.$body, $this->secret);

        return $expectedHash === $generatedHash;
    }
}

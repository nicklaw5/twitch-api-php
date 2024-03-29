<?php

declare(strict_types=1);

namespace TwitchApi\Webhooks;

use TwitchApi\HelixGuzzleClient;

class WebhooksSubscriptionApi
{
    public const SUBSCRIBE = 'subscribe';
    public const UNSUBSCRIBE = 'unsubscribe';

    private $clientId;
    private $secret;
    private $guzzleClient;

    public function __construct(string $clientId, string $secret, HelixGuzzleClient $guzzleClient = null)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->guzzleClient = $guzzleClient ?? HelixGuzzleClient::getClient($clientId);
    }

    public function subscribeToStream(string $twitchId, string $callback, string $bearer, int $leaseSeconds = 0): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/streams?user_id=%s', $twitchId),
            $callback,
            $bearer,
            $leaseSeconds
        );
    }

    public function subscribeToSubscriptionEvents(string $twitchId, string $callback, string $bearer, int $leaseSeconds = 0): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/subscriptions/events?broadcaster_id=%s&first=1', $twitchId),
            $callback,
            $bearer,
            $leaseSeconds
        );
    }

    public function subscribeToUser(string $twitchId, string $callback, string $bearer, int $leaseSeconds = 0): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/users?id=%s', $twitchId),
            $callback,
            $bearer,
            $leaseSeconds
        );
    }

    public function subscribeToUserFollows(string $followerId, string $followedUserId, int $first, string $callback, string $bearer, int $leaseSeconds = 0): void
    {
        $queryParams = [];
        if ($followerId) {
            $queryParams['from_id'] = $followerId;
        }
        if ($followedUserId) {
            $queryParams['to_id'] = $followedUserId;
        }
        if ($first) {
            $queryParams['first'] = $first;
        }
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/users/follows?%s', http_build_query($queryParams)),
            $callback,
            $bearer,
            $leaseSeconds
        );
    }

    public function unsubscribeFromStream(string $twitchId, string $callback, string $bearer): void
    {
        $this->unsubscribe(
            sprintf('https://api.twitch.tv/helix/streams?user_id=%s', $twitchId),
            $callback,
            $bearer
        );
    }

    public function unsubscribeFromUser(string $twitchId, string $callback, string $bearer)
    {
        $this->unsubscribe(
            sprintf('https://api.twitch.tv/helix/users?id=%s', $twitchId),
            $callback,
            $bearer
        );
    }

    public function unsubscribeFromUserFollows(string $followerId, string $followedUserId, int $first, string $callback, string $bearer)
    {
        $queryParams = [];
        if ($followerId) {
            $queryParams['from_id'] = $followerId;
        }
        if ($followedUserId) {
            $queryParams['to_id'] = $followedUserId;
        }
        if ($first) {
            $queryParams['first'] = $first;
        }
        $this->unsubscribe(
            sprintf('https://api.twitch.tv/helix/users/follows?%s', http_build_query($queryParams)),
            $callback,
            $bearer
        );
    }

    public function validateWebhookEventCallback(string $xHubSignature, string $content): bool
    {
        [$hashAlgorithm, $expectedHash] = explode('=', $xHubSignature);
        $generatedHash = hash_hmac($hashAlgorithm, $content, $this->secret);

        return $expectedHash === $generatedHash;
    }

    private function subscribe(string $topic, string $callback, string $bearer, int $leaseSeconds = 0): void
    {
        $headers = [
            'Client-ID' => $this->clientId,
        ];

        $headers['Authorization'] = sprintf('Bearer %s', $bearer);

        $body = [
            'hub.callback' => $callback,
            'hub.mode' => self::SUBSCRIBE,
            'hub.topic' => $topic,
            'hub.lease_seconds' => $leaseSeconds,
            'hub.secret' => $this->secret,
        ];

        $this->guzzleClient->post('webhooks/hub', [
            'headers' => $headers,
            'body' => json_encode($body),
        ]);
    }

    private function unsubscribe(string $topic, string $callback, string $bearer): void
    {
        $headers = [
            'Client-ID' => $this->clientId,
        ];

        $headers['Authorization'] = sprintf('Bearer %s', $bearer);

        $body = [
            'hub.callback' => $callback,
            'hub.mode' => self::UNSUBSCRIBE,
            'hub.topic' => $topic,
        ];

        $this->guzzleClient->post('webhooks/hub', [
            'headers' => $headers,
            'body' => json_encode($body),
        ]);
    }
}

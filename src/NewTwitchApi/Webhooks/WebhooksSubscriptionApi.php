<?php

declare(strict_types=1);

namespace NewTwitchApi\Webhooks;

use GuzzleHttp\Client;
use NewTwitchApi\HelixGuzzleClient;

class WebhooksSubscriptionApi
{
    public const SUBSCRIBE = 'subscribe';

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var Client|HelixGuzzleClient
     */
    protected $guzzleClient;

    /**
     * WebhooksSubscriptionApi constructor.
     *
     * @param string $clientId
     * @param string $secret
     * @param Client|null $guzzleClient
     */
    public function __construct(string $clientId, string $secret, Client $guzzleClient = null)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->guzzleClient = $guzzleClient ?? new HelixGuzzleClient($clientId);
    }

    /**
     * Subscribe to stream
     *
     * @param string $twitchId
     * @param string $bearer
     * @param string $callback
     * @param int $leaseSeconds
     */
    public function subscribeToStream(string $twitchId, string $bearer, string $callback, int $leaseSeconds = 0): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/streams?user_id=%s', $twitchId),
            $bearer,
            $callback,
            $leaseSeconds
        );
    }

    /**
     * Subscribe to user
     *
     * @param string $twitchId
     * @param string $bearer
     * @param string $callback
     * @param int $leaseSeconds
     */
    public function subscribeToUser(string $twitchId, string $bearer, string $callback, int $leaseSeconds = 0): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/users?id=%s', $twitchId),
            $bearer,
            $callback,
            $leaseSeconds
        );
    }

    /**
     * Subscribe to user follows
     *
     * @param string $followerId
     * @param string $followedUserId
     * @param int $first
     * @param string $bearer
     * @param string $callback
     * @param int $leaseSeconds
     */
    public function subscribeToUserFollows(string $followerId, string $followedUserId, int $first, string $bearer, string $callback, int $leaseSeconds = 0): void
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
            $bearer,
            $callback,
            $leaseSeconds
        );
    }

    /**
     * Validate webhook event callback
     *
     * @param string $xHubSignature
     * @param string $content
     * @return bool
     */
    public function validateWebhookEventCallback(string $xHubSignature, string $content): bool
    {
        [$hashAlgorithm, $expectedHash] = explode('=', $xHubSignature);
        $generatedHash = hash_hmac($hashAlgorithm, $content, $this->secret);

        return $expectedHash === $generatedHash;
    }

    /**
     * Subscribe
     *
     * @param string $topic
     * @param string $bearer
     * @param string $callback
     * @param int $leaseSeconds
     */
    protected function subscribe(string $topic, string $bearer, string $callback, int $leaseSeconds = 0): void
    {
        $headers = [
            'Authorization' => sprintf('Bearer %s', $bearer),
            'Client-ID' => $this->clientId,
        ];

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
}

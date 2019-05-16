<?php

declare(strict_types=1);

namespace NewTwitchApi\Webhooks;

use GuzzleHttp\Client;

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
     * @var Client
     */
    protected $guzzleClient;

    public function __construct(string $clientId, string $secret, Client $guzzleClient)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->guzzleClient = $guzzleClient;
    }

    public function subscribeToStream(string $twitchId, string $callback, string $bearer = null, int $leaseSeconds = 0): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/streams?user_id=%s', $twitchId),
            $callback,
            $bearer,
            $leaseSeconds
        );
    }

    public function subscribeToUser(string $twitchId, string $callback, string $bearer = null, int $leaseSeconds = 0): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/users?id=%s', $twitchId),
            $callback,
            $bearer,
            $leaseSeconds
        );
    }

    public function subscribeToUserFollows(string $followerId, string $followedUserId, int $first, string $callback, string $bearer = null, int $leaseSeconds = 0): void
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

    public function validateWebhookEventCallback(string $xHubSignature, string $content): bool
    {
        [$hashAlgorithm, $expectedHash] = explode('=', $xHubSignature);
        $generatedHash = hash_hmac($hashAlgorithm, $content, $this->secret);

        return $expectedHash === $generatedHash;
    }

    protected function subscribe(string $topic, string $callback, string $bearer = null, int $leaseSeconds = 0): void
    {
        $headers = [
            'Client-ID' => $this->clientId,
        ];
        if (!is_null($bearer)) {
            $headers['Authorization'] = sprintf('Bearer %s', $bearer);
        }

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

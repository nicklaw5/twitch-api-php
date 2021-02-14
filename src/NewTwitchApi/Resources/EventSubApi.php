<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use NewTwitchApi\HelixGuzzleClient;

class EventSubApi
{
    public const VERSION = '1';

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
     * @link https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#stream-subscriptions
     */
    public function subscribeToStream(string $twitchId, string $event, string $callback, string $bearer): void
    {
        if (!in_array($event, ['online', 'offline'])) {
            throw new \InvalidArgumentException('Invalid value for stream event type. Accepted values: online,offline.');
        }

        $this->subscribe(
            sprintf('stream.%s', $event),
            ['broadcaster_user_id' => $twitchId],
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
        $generatedHash = hash_hmac($hashAlgorithm, $messageId . $timestamp . $body, $this->secret);

        return $expectedHash === $generatedHash;
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/eventsub
     */
    private function subscribe(string $type, array $condition, string $callback, string $bearer): void
    {
        $headers = [
            'Client-ID' => $this->clientId,
        ];

        $headers['Authorization'] = sprintf('Bearer %s', $bearer);

        $body = [
            'type' => $type,
            'version' => self::VERSION,
            'condition' => $condition,
            'transport' => [
                'method' => 'webhook',
                'callback' => $callback,
                'secret' => $this->secret
            ]
        ];

        $this->guzzleClient->post('eventsub/subscriptions', [
            'headers' => $headers,
            'body' => json_encode($body),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class SubscriptionsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-broadcaster-subscriptions
     */
    public function getBroadcasterSubscriptions(string $bearer, string $broadcasterId, int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->callApi('subscriptions', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-broadcaster-subscriptions
     */
    public function getBroadcasterSubscribers(string $bearer, string $broadcasterId, array $ids = []): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
        }

        return $this->callApi('subscriptions', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-subscription-events
     */
    public function getSubscriptionEvents(string $bearer, string $broadcasterId, string $eventId = null, string $userId = null, int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        if ($eventId) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $eventId];
        }

        if ($userId) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->callApi('subscriptions/events', $bearer, $queryParamsMap);
    }
}

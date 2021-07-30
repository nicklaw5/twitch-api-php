<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class BitsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-cheermotes
     */
    public function getCheermotes(string $bearer, string $broadcasterId = null): ResponseInterface
    {
        $queryParamsMap = [];

        if ($broadcasterId) {
            $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        }

        return $this->getApi('bits/cheermotes', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-bits-leaderboard
     */
    public function getBitsLeaderboard(string $bearer, int $count = null, string $period = null, string $startedAt = null, string $userId = null): ResponseInterface
    {
        $queryParamsMap = [];

        if ($count) {
            $queryParamsMap[] = ['key' => 'count', 'value' => $count];
        }

        if ($period) {
            $queryParamsMap[] = ['key' => 'period', 'value' => $period];
        }

        if ($startedAt) {
            $queryParamsMap[] = ['key' => 'started_at', 'value' => $startedAt];
        }

        if ($userId) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        }

        return $this->getApi('bits/leaderboard', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-extension-transactions
     */
    public function getExtensionTransactions(string $bearer, string $extensionId, array $transactionIds = [], int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'extension_id', 'value' => $extensionId];

        foreach ($transactionIds as $transactionId) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $transactionId];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->getApi('extensions/transactions', $bearer, $queryParamsMap);
    }
}

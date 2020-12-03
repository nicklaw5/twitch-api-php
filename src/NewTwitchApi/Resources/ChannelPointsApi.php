<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ChannelPointsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     */
    public function getCustomRewardById(string $bearer, string $broadcasterId, string $id, bool $onlyManageableRewards = null): ResponseInterface
    {
        return $this->getCustomReward($bearer, $broadcasterId, [$id], $onlyManageableRewards);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-custom-reward
     */
    public function getCustomReward(string $bearer, string $broadcasterId, array $ids = [], bool $onlyManageableRewards = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }

        if ($onlyManageableRewards) {
            $queryParamsMap[] = ['key' => 'only_manageable_rewards', 'value' => $onlyManageableRewards];
        }

        return $this->callApi('channel_points/custom_rewards', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-custom-reward-redemption
     */
    public function getCustomRewardRedemption(string $bearer, string $broadcasterId, string $rewardId = null, array $ids = [], string $status = null, string $sort = null, string $after = null, string $first = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }

        if ($status) {
            $queryParamsMap[] = ['key' => 'status', 'value' => $status];
        }

        if ($sort) {
            $queryParamsMap[] = ['key' => 'sort', 'value' => $sort];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        return $this->callApi('channel_points/custom_rewards/redemptions', $bearer, $queryParamsMap);
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

        return $this->callApi('bits/leaderboard', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-extension-transactions
     */
    public function getExtensionTransactions(string $bearer, string $extensionId, array $transactionIds = [], int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'extension_id', 'value' => $extensionId];

        foreach ($transactionIds as  $transactionId) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $transactionId];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->callApi('extensions/transactions', $bearer, $queryParamsMap);
    }
}

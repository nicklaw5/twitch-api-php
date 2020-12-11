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

        return $this->getApi('channel_points/custom_rewards', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-custom-reward-redemption
     */
    public function getCustomRewardRedemption(string $bearer, string $broadcasterId, string $rewardId = null, array $ids = [], string $status = null, string $sort = null, string $after = null, string $first = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        if ($rewardId) {
            $queryParamsMap[] = ['key' => 'reward_id', 'value' => $rewardId];
        }

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

        return $this->getApi('channel_points/custom_rewards/redemptions', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#create-custom-rewards
     */
    public function createCustomReward(string $bearer, string $broadcasterId, array $bodyValues = []): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        // Due to the large number of body parameters for this endpoint, please supply an array for the $bodyValues parameter

        return $this->postApi('channel_points/custom_rewards', $bearer, $queryParamsMap, $bodyValues);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#delete-custom-reward
     */
    public function deleteCustomReward(string $bearer, string $broadcasterId, string $id): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        $queryParamsMap[] = ['key' => 'id', 'value' => $id];

        return $this->deleteApi('channel_points/custom_rewards', $bearer, $queryParamsMap);
    }
}

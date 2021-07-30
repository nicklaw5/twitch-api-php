<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class AnalyticsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-extension-analytics
     */
    public function getExtensionAnalytics(string $bearer, string $extensionId = null, string $type = null, int $first = null, string $after = null, string $startedAt = null, string $endedAt = null): ResponseInterface
    {
        $queryParamsMap = [];

        if ($extensionId) {
            $queryParamsMap[] = ['key' => 'extension_id', 'value' => $extensionId];
        }

        if ($type) {
            $queryParamsMap[] = ['key' => 'type', 'value' => $type];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        if ($startedAt) {
            $queryParamsMap[] = ['key' => 'started_at', 'value' => $startedAt];
        }

        if ($endedAt) {
            $queryParamsMap[] = ['key' => 'ended_at', 'value' => $endedAt];
        }

        return $this->getApi('analytics/extensions', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-game-analytics
     */
    public function getGameAnalytics(string $bearer, string $gameId = null, string $type = null, int $first = null, string $after = null, string $startedAt = null, string $endedAt = null): ResponseInterface
    {
        $queryParamsMap = [];

        if ($gameId) {
            $queryParamsMap[] = ['key' => 'game_id', 'value' => $gameId];
        }

        if ($type) {
            $queryParamsMap[] = ['key' => 'type', 'value' => $type];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        if ($startedAt) {
            $queryParamsMap[] = ['key' => 'started_at', 'value' => $startedAt];
        }

        if ($endedAt) {
            $queryParamsMap[] = ['key' => 'ended_at', 'value' => $endedAt];
        }

        return $this->getApi('analytics/games', $bearer, $queryParamsMap);
    }
}

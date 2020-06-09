<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ClipsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     */
    public function getClipsByBroadcasterId(string $broadcasterId, string $bearer, int $first = null, string $before = null, string $after = null, string $startedAt = null, string $endedAt = null): ResponseInterface
    {
        return $this->getClips($bearer, $broadcasterId, NULL, NULL, $first, $before, $after, $startedAt, $endedAt);
    }

    /**
     * @throws GuzzleException
     */
    public function getClipsByGameId(string $gameId, string $bearer, int $first = null, string $before = null, string $after = null, string $startedAt = null, string $endedAt = null): ResponseInterface
    {
        return $this->getClips($bearer, NULL, $gameId, NULL, $first, $before, $after, $startedAt, $endedAt);
    }

    /**
     * @throws GuzzleException
     */
    public function getClipsByIds(string $clipIds, string $bearer, int $first = null, string $before = null, string $after = null, string $startedAt = null, string $endedAt = null): ResponseInterface
    {
        return $this->getClips($bearer, NULL, NULL, $clipIds, $first, $before, $after, $startedAt, $endedAt);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-clips
     */
    public function getClips(string $bearer, string $broadcasterId = null, string $gameId = null, string $clipIds = null, int $first = null, string $before = null, string $after = null, string $startedAt = null, string $endedAt = null): ResponseInterface
    {
        $queryParamsMap = [];
        if ($broadcasterId) {
            $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        }
        if ($gameId) {
            $queryParamsMap[] = ['key' => 'game_id', 'value' => $gameId];
        }
        if ($clipIds) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $clipIds];
        }
        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }
        if ($before) {
            $queryParamsMap[] = ['key' => 'before', 'value' => $before];
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

        return $this->callApi('clips', $queryParamsMap, $bearer);
    }
}

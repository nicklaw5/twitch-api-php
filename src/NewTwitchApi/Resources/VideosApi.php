<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class VideosApi extends AbstractResource
{

  /**
   * @throws GuzzleException
   * @link https://dev.twitch.tv/docs/api/reference/#get-videos
   */
    public function getVideos(string $bearer, array $ids = [], string $userId = null, string $gameId = null, string $first = null, string $before = null, string $after = null, string $language = null, string $period = null, string $sort = null, string $type = null): ResponseInterface
    {
        $queryParamsMap = [];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }

        if ($userId) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        }

        if ($gameId) {
            $queryParamsMap[] = ['key' => 'game_id', 'value' => $gameId];
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

        if ($language) {
            $queryParamsMap[] = ['key' => 'language', 'value' => $language];
        }

        if ($period) {
            $queryParamsMap[] = ['key' => 'period', 'value' => $period];
        }

        if ($sort) {
            $queryParamsMap[] = ['key' => 'sort', 'value' => $sort];
        }

        if ($type) {
            $queryParamsMap[] = ['key' => 'type', 'value' => $type];
        }

        return $this->callApi('videos', $bearer, $queryParamsMap);
    }
}

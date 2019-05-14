<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class StreamsApi extends AbstractResource
{
    /**
     * Get Stream for user Id
     *
     * @param string $userId
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getStreamForUserId(string $userId): ResponseInterface
    {
        return $this->getStreams([$userId]);
    }

    /**
     * @param string $username
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getStreamForUsername(string $username): ResponseInterface
    {
        return $this->getStreams([], [$username]);
    }

    /**
     * Get streams
     *
     * @param array $userIds
     * @param array $usernames
     * @param array $gameIds
     * @param array $communityIds
     * @param array $languages
     * @param int|null $first
     * @param string|null $before
     * @param string|null $after
     * @return ResponseInterface
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-streams
     */
    public function getStreams(array $userIds = [], array $usernames = [], array $gameIds = [], array $communityIds = [], array $languages = [], int $first = null, string $before = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];
        foreach ($userIds as $id) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
        }
        foreach ($usernames as $username) {
            $queryParamsMap[] = ['key' => 'user_login', 'value' => $username];
        }
        foreach ($gameIds as $gameId) {
            $queryParamsMap[] = ['key' => 'game_id', 'value' => $gameId];
        }
        foreach ($communityIds as $communityId) {
            $queryParamsMap[] = ['key' => 'community_id', 'value' => $communityId];
        }
        foreach ($languages as $language) {
            $queryParamsMap[] = ['key' => 'language', 'value' => $language];
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

        return $this->callApi('streams', $queryParamsMap);
    }
}

<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class StreamsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     */
    public function getStreamForUserId(string $userId, string $bearer = null): ResponseInterface
    {
        return $this->getStreams([$userId], [], [], [], [], null, null, null, $bearer);
    }

    /**
     * @throws GuzzleException
     */
    public function getStreamForUsername(string $username, string $bearer = null): ResponseInterface
    {
        return $this->getStreams([], [$username], [], [], [], null, null, null, $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-streams
     */
    public function getStreams(array $userIds = [], array $usernames = [], array $gameIds = [], array $communityIds = [], array $languages = [], int $first = null, string $before = null, string $after = null, $bearer = null): ResponseInterface
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

        return $this->callApi('streams', $queryParamsMap, $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-streams-metadata
     */
    public function getStreamsMetadata(array $userIds = [], array $usernames = [], array $gameIds = [], array $communityIds = [], array $languages = [], int $first = null, string $before = null, string $after = null, string $bearer = null): ResponseInterface
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

        return $this->callApi('streams/metadata', $queryParamsMap, $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-stream-markers
     */
    public function getStreamMarkers(string $bearer, string $userId = null, string $videoId = null, string $first = null, string $before = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];

        if ($userId) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        }

        if ($videoId) {
            $queryParamsMap[] = ['key' => 'video_id', 'value' => $videoId];
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

        return $this->callApi('streams/markers', $queryParamsMap, $bearer);
    }
}

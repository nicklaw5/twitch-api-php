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
    public function getStreamForUserId(int $userId): ResponseInterface
    {
        return $this->getStreams([$userId]);
    }

    /**
     * @throws GuzzleException
     */
    public function getStreamForUsername(string $username): ResponseInterface
    {
        return $this->getStreams([], [$username]);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-streams
     */
    public function getStreams(
        array $userIds = [],
        array $usernames = [],
        array $gameIds = [],
        array $communityIds = [],
        array $languages = [],
        int $first = null,
        string $before = null,
        string $after = null
    ): ResponseInterface {
        $queryParamsMap = [
            'user_id' => $userIds,
            'user_login' => $usernames,
            'game_id' => $gameIds,
            'community_id' => $communityIds,
            'language' => $languages,
            'first' => $first,
            'before' => $before,
            'after' => $after,
        ];

        return $this->callApi('streams', $queryParamsMap);
    }
}

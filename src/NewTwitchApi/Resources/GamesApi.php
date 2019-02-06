<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class GamesApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-games
     */
    public function getGames(array $ids = [], array $names = []): ResponseInterface
    {
        $queryParamsMap = [];
        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }
        foreach ($names as $name) {
            $queryParamsMap[] = ['key' => 'name', 'value' => $name];
        }

        return $this->callApi('games', $queryParamsMap);
    }

    /**
     * @param int $first The number of items to return, default is 20
     * @param null|string $cursor The pagination cursor from a previous request
     * @param bool $after Return results before (false) or after (true) the cursor
     * @return ResponseInterface
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-top-games
     */
    public function getGamesTop($first = 20, $cursor = null, $after = true): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        if ($cursor !== null) {
            $queryParamsMap[] = ['key' => $after ? 'after' : 'before', 'value' => $cursor];
        }
        return $this->callApi('games/top', $queryParamsMap);
    }
}

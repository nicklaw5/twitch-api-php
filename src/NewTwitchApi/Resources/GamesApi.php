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
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-top-games
     */
    public function getGamesTop(int $first = 20, string $cursor = null, bool $after = true): ResponseInterface
    {
        $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        if ($cursor !== null) {
            $queryParamsMap[] = ['key' => $after ? 'after' : 'before', 'value' => $cursor];
        }

        return $this->callApi('games/top', $queryParamsMap);
    }
}

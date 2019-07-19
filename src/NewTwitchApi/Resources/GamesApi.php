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
    public function getGames(array $ids = [], array $names = [], string $bearer = null): ResponseInterface
    {
        $queryParamsMap = [];
        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }
        foreach ($names as $name) {
            $queryParamsMap[] = ['key' => 'name', 'value' => $name];
        }

        return $this->callApi('games', $queryParamsMap, $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-top-games
   */
    public function getTopGames(int $first = null, string $before = null, string $after = null, string $bearer = null): ResponseInterface
    {
        $queryParamsMap = [];

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($before) {
            $queryParamsMap[] = ['key' => 'before', 'value' => $before];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->callApi('games/top', $queryParamsMap, $bearer);
    }
}

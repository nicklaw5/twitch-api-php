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
        $queryParamsMap = [
            'id' => $ids,
            'name' => $names,
        ];

        return $this->callApi('games', $queryParamsMap);
    }
}

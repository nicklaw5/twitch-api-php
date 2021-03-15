<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class TeamsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-channel-teams
     */
    public function getChannelTeams(string $bearer, string $broadcasterId): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        return $this->getApi('teams/channel', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-teams
     */
    public function getTeams(string $bearer, string $name = null, string $id = null): ResponseInterface
    {
        $queryParamsMap = [];

        if ($name) {
            $queryParamsMap[] = ['key' => 'name', 'value' => $name];
        }

        if ($id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }

        return $this->getApi('teams', $bearer, $queryParamsMap);
    }
}

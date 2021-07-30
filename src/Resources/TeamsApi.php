<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

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

    /**
     * @throws GuzzleException
     */
    public function getTeamsByName(string $bearer, string $name): ResponseInterface
    {
        return $this->getTeams($bearer, $name, null);
    }

    /**
     * @throws GuzzleException
     */
    public function getTeamsById(string $bearer, string $id): ResponseInterface
    {
        return $this->getTeams($bearer, null, $id);
    }
}

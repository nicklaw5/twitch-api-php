<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class GoalsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-creator-goals
     */
    public function getGoals(string $bearer, string $broadcasterId): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        return $this->getApi('goals', $bearer, $queryParamsMap);
    }
}

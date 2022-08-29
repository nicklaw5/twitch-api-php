<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class RaidsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#start-a-raid
     */
    public function startRaid(string $bearer, string $fromBroadcasterId, string $toBroadcasterId): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'from_broadcaster_id', 'value' => $fromBroadcasterId];
        $queryParamsMap[] = ['key' => 'to_broadcaster_id', 'value' => $toBroadcasterId];

        return $this->postApi('raids', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#cancel-a-raid
     */
    public function cancelRaid(string $bearer, string $toBroadcasterId): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $toBroadcasterId];

        return $this->deleteApi('raids', $bearer, $queryParamsMap);
    }
}

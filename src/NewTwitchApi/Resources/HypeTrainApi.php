<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class HypeTrainApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-hype-train-events
     */
    public function getHypeTrainEvents(string $bearer, string $broadcasterId, int $first = null, string $id = null, string $cursor = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }

        if ($cursor) {
            $queryParamsMap[] = ['key' => 'cursor', 'value' => $cursor];
        }

        return $this->callApi('bits/cheermotes', $bearer, $queryParamsMap);
    }
}

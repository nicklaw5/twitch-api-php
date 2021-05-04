<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class PollsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-polls
     */
    public function getPolls(string $bearer, string $broadcasterId, array $ids = [], string $after = null, int $first = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        return $this->getApi('polls', $bearer, $queryParamsMap);
    }
}

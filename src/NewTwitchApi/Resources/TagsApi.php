<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class TagsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-all-stream-tags
     */
    public function getAllStreamTags(string $bearer, array $tagIds = [], int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];

        foreach ($tagIds as $tagId) {
            $queryParamsMap[] = ['key' => 'tag_id', 'value' => $tagId];
        }
        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->callApi('tags/streams', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-stream-tags
     */
    public function getStreamTags(string $bearer, string $broadcasterId): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        return $this->callApi('tags/streams', $bearer, $queryParamsMap);
    }
}

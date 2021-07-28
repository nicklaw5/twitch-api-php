<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ChatApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-channel-emotes
     */
    public function getChannelEmotes(string $bearer, string $broadcasterId): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        return $this->getApi('chat/emotes', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-global-emotes
     */
    public function getGlobalEmotes(string $bearer): ResponseInterface
    {
        return $this->getApi('chat/emotes/global', $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-emote-sets
     */
    public function getEmoteSets(string $bearer, array $emoteSetIds = []): ResponseInterface
    {
        $queryParamsMap = [];

        foreach ($emoteSetIds as $emoteSetId) {
            $queryParamsMap[] = ['key' => 'emote_set_id', 'value' => $emoteSetId];
        }

        return $this->getApi('chat/emotes/set', $bearer, $queryParamsMap);
    }

    public function getEmoteSet(string $bearer, string $emoteSetId): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'emote_set_id', 'value' => $emoteSetId];

        return $this->getApi('chat/emotes/set', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-channel-chat-badges
     */
    public function getChannelChatBadges(string $bearer, string $broadcasterId): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        return $this->getApi('chat/badges', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-global-chat-badges
     */
    public function getGlobalChatBadges(string $bearer): ResponseInterface
    {
        return $this->getApi('chat/badges/global', $bearer);
    }
}

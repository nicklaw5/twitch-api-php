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

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-chat-settings
     */
    public function getChatSettings(string $bearer, string $broadcasterId, string $moderatorId = null): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        if ($moderatorId) {
            $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];
        }

        return $this->getApi('chat/settings', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#update-chat-settings
     */
    public function updateChatSettings(string $bearer, string $broadcasterId, string $moderatorId, array $chatSettings): ResponseInterface
    {
        $queryParamsMap = $bodyParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        foreach ($chatSettings as $key => $value) {
            $bodyParamsMap[] = ['key' => $key, 'value' => $value];
        }

        return $this->patchApi('chat/settings', $bearer, $queryParamsMap, $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#send-chat-announcement
     */
    public function sendChatAnnouncement(string $bearer, string $broadcasterId, string $moderatorId, string $message, string $color = null): ResponseInterface
    {
        $queryParamsMap = $bodyParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        $bodyParamsMap[] = ['key' => 'message', 'value' => $message];

        if ($color) {
            $bodyParamsMap[] = ['key' => 'color', 'value' => $color];
        }

        return $this->postApi('chat/announcements', $bearer, $queryParamsMap, $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-user-chat-color
     */
    public function getUserChatColor(string $bearer, string $userId): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];

        return $this->getApi('chat/color', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#update-user-chat-color
     */
    public function updateUserChatColor(string $bearer, string $userId, string $color): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];

        $queryParamsMap[] = ['key' => 'color', 'value' => $color];

        return $this->putApi('chat/color', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-chatters
     */
    public function getChatters(string $bearer, string $broadcasterId, string $moderatorId, int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->getApi('chat/chatters', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#send-a-shoutout
     */
    public function sendShoutout(string $bearer, string $fromBroadcasterId, string $toBroadcasterId, string $moderatorId): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'from_broadcaster_id', 'value' => $fromBroadcasterId];

        $bodyParamsMap[] = ['key' => 'to_broadcaster_id', 'value' => $toBroadcasterId];

        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        return $this->postApi('chat/shoutouts', $bearer, $queryParamsMap);
    }
}

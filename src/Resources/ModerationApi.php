<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ModerationApi extends AbstractResource
{

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-banned-users
     */
    public function getBannedUsers(string $bearer, string $broadcasterId, array $ids = [], string $before = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
        }

        if ($before) {
            $queryParamsMap[] = ['key' => 'before', 'value' => $before];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->getApi('moderation/banned', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-moderators
     */
    public function getModerators(string $bearer, string $broadcasterId, array $ids = [], string $after = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->getApi('moderation/moderators', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#check-automod-status
     */
    public function checkAutoModStatus(string $bearer, string $broadcasterId, string $msgId, string $msgText): ResponseInterface
    {
        $queryParamsMap = $bodyParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        $bodyParamsMap[] = ['key' => 'msg_id', 'value' => $msgId];
        $bodyParamsMap[] = ['key' => 'msg_text', 'value' => $msgText];

        return $this->postApi('moderation/enforcements/status', $bearer, $queryParamsMap, $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#manage-held-automod-messages
     */
    public function manageHeldAutoModMessage(string $bearer, string $userId, string $msgId, string $action): ResponseInterface
    {
        $bodyParamsMap = [];

        $bodyParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        $bodyParamsMap[] = ['key' => 'msg_id', 'value' => $msgId];
        $bodyParamsMap[] = ['key' => 'action', 'value' => $action];

        return $this->postApi('moderation/automod/message', $bearer, [], $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#ban-user
     */
    public function banUser(string $bearer, string $broadcasterId, string $moderatorId, string $userId, string $reason, int $duration = null): ResponseInterface
    {
        $queryParamsMap = $bodyParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        $bodyParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        $bodyParamsMap[] = ['key' => 'reason', 'value' => $reason];

        if ($duration) {
            $bodyParamsMap[] = ['key' => 'duration', 'value' => $duration];
        }

        return $this->postApi('moderation/bans', $bearer, $queryParamsMap, $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#unban-user
     */
    public function unbanUser(string $bearer, string $broadcasterId, string $moderatorId, string $userId): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];

        return $this->deleteApi('moderation/bans', $bearer, $queryParamsMap);
    }
}

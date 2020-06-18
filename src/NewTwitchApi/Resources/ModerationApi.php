<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ModerationApi extends AbstractResource
{

  /**
   * @throws GuzzleException
   * @link https://dev.twitch.tv/docs/api/reference/#get-banned-events
   */
  public function getBannedEvents(string $bearer, string $broadcasterId, array $ids = [], string $first = null, string $after = null): ResponseInterface
  {
    $queryParamsMap = [];

    $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

    foreach ($ids as $id) {
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
    }

    if ($first) {
        $queryParamsMap[] = ['key' => 'first', 'value' => $first];
    }

    if ($after) {
        $queryParamsMap[] = ['key' => 'after', 'value' => $after];
    }

    return $this->callApi('moderation/banned/events', $bearer, $queryParamsMap);
  }

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

    return $this->callApi('moderation/banned', $bearer, $queryParamsMap);
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

    return $this->callApi('moderation/moderators', $bearer, $queryParamsMap);
  }

  /**
  * @throws GuzzleException
  * @link https://dev.twitch.tv/docs/api/reference/#get-moderator-events
  */
  public function getModeratorEvents(string $bearer, string $broadcasterId, array $ids = [], string $after = null): ResponseInterface
  {
    $queryParamsMap = [];

    $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

    foreach ($ids as $id) {
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
    }

    if ($after) {
        $queryParamsMap[] = ['key' => 'after', 'value' => $after];
    }

    return $this->callApi('moderation/moderators/events', $bearer, $queryParamsMap);
  }
}

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
  public function getBannedEvents(string $broadcasterId, string $bearer, array $ids = [], string $first = null, string $after = null): ResponseInterface
  {
    $queryParamsMap = [];

    $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

    foreach ($ids as $id) {
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
    }

    if($first) {
        $queryParamsMap[] = ['key' => 'first', 'value' => $first];
    }

    if($after) {
        $queryParamsMap[] = ['key' => 'after', 'value' => $after];
    }

    return $this->callApi('moderation/banned/events', $queryParamsMap, $bearer);
  }

  /**
  * @throws GuzzleException
  * @link https://dev.twitch.tv/docs/api/reference/#get-banned-users
  */
  public function getBannedUsers(string $broadcasterId, string $bearer, array $ids = [], string $before = null, string $after = null): ResponseInterface
  {
    $queryParamsMap = [];

    $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

    foreach ($ids as $id) {
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
    }

    if($before) {
        $queryParamsMap[] = ['key' => 'before', 'value' => $before];
    }

    if($after) {
        $queryParamsMap[] = ['key' => 'after', 'value' => $after];
    }

    return $this->callApi('moderation/banned', $queryParamsMap, $bearer);
  }

  /**
  * @throws GuzzleException
  * @link https://dev.twitch.tv/docs/api/reference/#get-moderators
  */
  public function getModerators(string $broadcasterId, string $bearer, array $ids = [], string $after = null): ResponseInterface
  {
    $queryParamsMap = [];

    $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

    foreach ($ids as $id) {
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
    }

    if($after) {
        $queryParamsMap[] = ['key' => 'after', 'value' => $after];
    }

    return $this->callApi('moderation/moderators', $queryParamsMap, $bearer);
  }

  /**
  * @throws GuzzleException
  * @link https://dev.twitch.tv/docs/api/reference/#get-moderator-events
  */
  public function getModeratorEvents(string $broadcasterId, string $bearer, array $ids = [], string $after = null): ResponseInterface
  {
    $queryParamsMap = [];

    $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

    foreach ($ids as $id) {
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
    }

    if($after) {
        $queryParamsMap[] = ['key' => 'after', 'value' => $after];
    }

    return $this->callApi('moderation/moderators/events', $queryParamsMap, $bearer);
  }
}

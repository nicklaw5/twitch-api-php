<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class UsersApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     */
    public function getUserByAccessToken(string $bearer, bool $includeEmail = false): ResponseInterface
    {
        return $this->getUsers([], [], $includeEmail, $bearer);
    }

    /**
     * @throws GuzzleException
     */
    public function getUserById(string $bearer, string $id, bool $includeEmail = false): ResponseInterface
    {
        return $this->getUsers([$id], [], $includeEmail, $bearer);
    }

    /**
     * @throws GuzzleException
     */
    public function getUserByUsername(string $bearer, string $username, bool $includeEmail = false): ResponseInterface
    {
        return $this->getUsers([], [$username], $includeEmail, $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-users
     */
    public function getUsers(string $bearer, array $ids = [], array $usernames = [], bool $includeEmail = false): ResponseInterface
    {
        $queryParamsMap = [];
        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }
        foreach ($usernames as $username) {
            $queryParamsMap[] = ['key' => 'login', 'value' => $username];
        }
        if ($includeEmail) {
            $queryParamsMap[] = ['key' => 'scope', 'value' => 'user:read:email'];
        }

        return $this->callApi('users', $queryParamsMap, $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-users-follows
     */
    public function getUsersFollows(string $bearer, string $followerId = null, string $followedUserId = null, int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];
        if ($followerId) {
            $queryParamsMap[] = ['key' => 'from_id', 'value' => $followerId];
        }
        if ($followedUserId) {
            $queryParamsMap[] = ['key' => 'to_id', 'value' => $followedUserId];
        }
        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }
        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->callApi('users/follows', $queryParamsMap, $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-user-extensions
     */
    public function getUserExtensions(string $bearer): ResponseInterface
    {
        $queryParamsMap = [];

        return $this->callApi('users/extensions/list', $queryParamsMap, $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-user-active-extensions
     */
    public function getActiveUserExtensions(string $bearer, string $userId = null): ResponseInterface
    {
        $queryParamsMap = [];

        if ($userId) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        }

        return $this->callApi('users/extensions', $queryParamsMap, $bearer);
    }
}

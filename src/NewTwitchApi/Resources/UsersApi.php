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
    public function getUserByAccessToken(string $accessToken, bool $includeEmail = false): ResponseInterface
    {
        return $this->getUsers([], [], $includeEmail, $accessToken);
    }

    /**
     * @throws GuzzleException
     */
    public function getUserById(string $id, bool $includeEmail = false, string $bearer = null): ResponseInterface
    {
        return $this->getUsers([$id], [], $includeEmail, $bearer);
    }

    /**
     * @throws GuzzleException
     */
    public function getUserByUsername(string $username, bool $includeEmail = false, string $bearer = null): ResponseInterface
    {
        return $this->getUsers([], [$username], $includeEmail, $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-users
     */
    public function getUsers(array $ids = [], array $usernames = [], bool $includeEmail = false, string $bearer = null): ResponseInterface
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
    public function getUsersFollows(string $followerId = null, string $followedUserId = null, int $first = null, string $after = null, string $bearer = null): ResponseInterface
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
}

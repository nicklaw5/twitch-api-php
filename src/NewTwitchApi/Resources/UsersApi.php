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
    public function getUserById(int $id, bool $includeEmail = false): ResponseInterface
    {
        return $this->getUsers([$id], [], $includeEmail);
    }

    /**
     * @throws GuzzleException
     */
    public function getUserByUsername(string $username, bool $includeEmail = false): ResponseInterface
    {
        return $this->getUsers([], [$username], $includeEmail);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-users
     */
    public function getUsers(array $ids = [], array $usernames = [], bool $includeEmail = false, string $bearer = null): ResponseInterface
    {
        $queryParamsMap = [
            'id' => $ids,
            'login' => $usernames,
            'scope' => true === $includeEmail ? 'user:read:email' : '',
        ];

        return $this->callApi('users', $queryParamsMap, $bearer);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-users-follows
     */
    public function getUsersFollows(int $followerId = null, int $followedUserId = null, int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [
            'from_id' => $followerId,
            'to_id' => $followedUserId,
            'first' => $first,
            'after' => $after,
        ];

        return $this->callApi('users/follows', $queryParamsMap);
    }
}

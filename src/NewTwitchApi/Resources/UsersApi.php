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
    public function getUserByAccessToken(string $accessToken): ResponseInterface
    {
        return $this->getUsers([], [], $accessToken);
    }

    /**
     * @throws GuzzleException
     */
    public function getUserById(int $id): ResponseInterface
    {
        return $this->getUsers([$id], []);
    }

    /**
     * @throws GuzzleException
     */
    public function getUserByUsername(string $username): ResponseInterface
    {
        return $this->getUsers([], [$username]);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-users
     */
    public function getUsers(array $ids = [], array $usernames = [], string $bearer = null): ResponseInterface
    {
        $queryParamsMap = [
            'id' => $ids,
            'login' => $usernames,
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

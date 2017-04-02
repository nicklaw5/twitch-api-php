<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\EndpointNotSupportedByApiVersionException;
use TwitchApi\Exceptions\InvalidIdentifierException;
use TwitchApi\Exceptions\InvalidLimitException;
use TwitchApi\Exceptions\InvalidOffsetException;
use TwitchApi\Exceptions\InvalidTypeException;
use TwitchApi\Exceptions\UnsupportedOptionException;

trait Users
{
    /**
     * Get a user from their access token
     *
     * @param string $accessToken
     * @return array|json
     */
    public function getAuthenticatedUser($accessToken)
    {
        return $this->get('user', [], $accessToken);
    }

    /**
     * Get a user
     *
     * @param string|int $userIdentifier
     * @throws InvalidIdentifierException
     * @return array|json
     */
    public function getUser($userIdentifier)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($userIdentifier)) {
            throw new InvalidIdentifierException('user');
        }

        return $this->get(sprintf('users/%s', $userIdentifier));
    }

    /**
     * Get a user from their username
     *
     * @param string $username
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function getUserByUsername($username)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        $params = [
            'login' => $username,
        ];

        return $this->get('users', $params);
    }

    /**
     * Get a user's emotes
     *
     * @param string|int $userIdentifier
     * @param string     $accessToken
     * @throws InvalidIdentifierException
     * @return array|json
     */
    public function getUserEmotes($userIdentifier, $accessToken)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($userIdentifier)) {
            throw new InvalidIdentifierException('user');
        }

        return $this->get(sprintf('users/%s/emotes', $userIdentifier), [], $accessToken);
    }

    /**
     * Check if a user is subscribed to a channel
     *
     * @param string|int $userIdentifier
     * @param string|int $channelIdentifier
     * @param string     $accessToken
     * @throws InvalidIdentifierException
     * @return array|json
     */
    public function checkUserSubscriptionToChannel($userIdentifier, $channelIdentifier, $accessToken)
    {
        if ($this->apiVersionIsGreaterThanV4()) {
            if (!is_numeric($userIdentifier)) {
                throw new InvalidIdentifierException('user');
            }

            if (!is_numeric($channelIdentifier)) {
                throw new InvalidIdentifierException('channel');
            }
        }

        return $this->get(sprintf('users/%s/subscriptions/%s', $userIdentifier, $channelIdentifier), [], $accessToken);
    }

    /**
     * Gets a list of all channels followed by a user
     *
     * @param string|int $userIdentifier
     * @param int    $limit
     * @param int    $offset
     * @param string $direction
     * @param string $sortby
     * @throws InvalidIdentifierException
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @throws UnsupportedOptionException
     * @return array|json
     */
    public function getUsersFollowedChannels($userIdentifier, $limit = 25, $offset = 0, $direction = 'desc', $sortby = 'created_at')
    {
        $availableSortBys = ['created_at', 'last_broadcast', 'login'];

        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($userIdentifier)) {
            throw new InvalidIdentifierException('user');
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        if (!$this->isValidDirection($direction)) {
            throw new InvalidDirectionException();
        }

        if (!in_array($sortby = strtolower($sortby), $availableSortBys)) {
            throw new UnsupportedOptionException('sortby', $availableSortBys);
        }

        return $this->get(sprintf('users/%s/follows/channels', $userIdentifier), [
            'limit' => intval($limit),
            'offset' => intval($offset),
            'direction' => $direction,
            'sortby' => $sortby,
        ]);
    }

    /**
     * Check if a user follows a channel
     *
     * @param string|int $userIdentifier
     * @param string|int $channelIdentifier
     * @throws InvalidIdentifierException
     * @return array|json
     */
    public function checkUserFollowsChannel($userIdentifier, $channelIdentifier)
    {
        if ($this->apiVersionIsGreaterThanV4()) {
            if (!is_numeric($userIdentifier)) {
                throw new InvalidIdentifierException('user');
            }

            if (!is_numeric($channelIdentifier)) {
                throw new InvalidIdentifierException('channel');
            }
        }

        return $this->get(sprintf('users/%s/follows/channels/%s', $userIdentifier, $channelIdentifier));
    }

    /**
     * Have a user follow a channel
     *
     * @param string|int $userIdentifier
     * @param string|int $channelIdentifier
     * @param string     $accessToken
     * @param bool       $notifications
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function followChannel($userIdentifier, $channelIdentifier, $accessToken, $notifications = false)
    {
        if ($this->apiVersionIsGreaterThanV4()) {
            if (!is_numeric($userIdentifier)) {
                throw new InvalidIdentifierException('user');
            }

            if (!is_numeric($channelIdentifier)) {
                throw new InvalidIdentifierException('channel');
            }
        }

        if (!is_bool($notifications)) {
            throw new InvalidTypeException('Notifications', 'boolean', gettype($notifications));
        }

        return $this->put(
            sprintf('users/%s/follows/channels/%s', $userIdentifier, $channelIdentifier),
            ['notifications' => $notifications],
            $accessToken
        );
    }

    /**
     * Have a user unfollow a channel
     *
     * @param string|int $userIdentifier
     * @param string|int $channelIdentifier
     * @param string     $accessToken
     * @throws InvalidIdentifierException
     * @return null|array|json
     */
    public function unfollowChannel($userIdentifier, $channelIdentifier, $accessToken)
    {
        if ($this->apiVersionIsGreaterThanV4()) {
            if (!is_numeric($userIdentifier)) {
                throw new InvalidIdentifierException('user');
            }

            if (!is_numeric($channelIdentifier)) {
                throw new InvalidIdentifierException('channel');
            }
        }

        return $this->delete(sprintf('users/%s/follows/channels/%s', $userIdentifier, $channelIdentifier), [], $accessToken);
    }

    /**
     * Get a user’s block list
     *
     * @param string|int $userIdentifier
     * @param string     $accessToken
     * @param int        $limit
     * @param int        $offset
     * @throws InvalidIdentifierException
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @return array|json
     */
    public function getUserBlockList($userIdentifier, $accessToken, $limit = 25, $offset = 0)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($userIdentifier)) {
            throw new InvalidIdentifierException('user');
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        $params = [
            'limit' => intval($limit),
            'offset' => intval($offset),
        ];

        return $this->get(sprintf('users/%s/blocks', $userIdentifier), $params, $accessToken);
    }

    /**
     * Block a user
     *
     * @param string|int $userIdentifier
     * @param string|int $userToBlockIdentifier
     * @param string     $accessToken
     * @throws InvalidIdentifierException
     * @return array|json
     */
    public function blockUser($userIdentifier, $userToBlockIdentifier, $accessToken)
    {
        if ($this->apiVersionIsGreaterThanV4()) {
            if (!is_numeric($userIdentifier) || !is_numeric($userToBlockIdentifier)) {
                throw new InvalidIdentifierException('user');
            }
        }

        return $this->put(sprintf('users/%s/blocks/%s', $userIdentifier, $userToBlockIdentifier), [], $accessToken);
    }

    /**
     * Unblock a user
     *
     * @param string|int $userIdentifier
     * @param string|int $userToBlockIdentifier
     * @param string     $accessToken
     * @throws InvalidIdentifierException
     * @return null|array|json
     */
    public function unblockUser($userIdentifier, $userToUnlockIdentifier, $accessToken)
    {
        if ($this->apiVersionIsGreaterThanV4()) {
            if (!is_numeric($userIdentifier) || !is_numeric($userToUnlockIdentifier)) {
                throw new InvalidIdentifierException('user');
            }
        }

        return $this->delete(sprintf('users/%s/blocks/%s', $userIdentifier, $userToUnlockIdentifier), [], $accessToken);
    }

    /**
     * Creates a connection between a user and VHS
     *
     * @param string $identifier
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @return null|array|json
     */
    public function createUserVHSConnection($identifier, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        $params = [
            'identifier' => $identifier,
        ];

        return $this->put('user/vhs', $params, $accessToken);
    }

    /**
     * Check whether an authenticated Twitch user is connected to VHS
     *
     * @param string     $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function checkUserVHSConnection($accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        return $this->get('user/vhs', [], $accessToken);
    }

    /**
     * Delete the connection between an authenticated Twitch user and VHS
     *
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @return null|array|json
     */
    public function deleteUserVHSConnection($accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        return $this->delete('user/vhs', [], $accessToken);
    }
}

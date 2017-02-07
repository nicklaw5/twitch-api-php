<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidTypeException;
use TwitchApi\Exceptions\InvalidLimitException;
use TwitchApi\Exceptions\InvalidOffsetException;
use TwitchApi\Exceptions\InvalidIdentifierException;
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
        $availableDirections = ['asc', 'desc'];
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

        if (!in_array($direction = strtolower($direction), $availableDirections)) {
            throw new UnsupportedOptionException('direction', $availableDirections);
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
}

<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidIdentifierException;

trait Users
{
    /**
     * Get a user from their access token
     *
     * @param string $accessToken
     * @return array
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
     * @return array
     */
    public function getUser($userIdentifier)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($userIdentifier)) {
            throw new InvalidIdentifierException('user');
        }

        return $this->get(sprintf('users/%s', (string) $userIdentifier));
    }

    /**
     * Get a user's emotes
     *
     * @param string|int $userIdentifier
     * @param string     $accessToken
     * @throws InvalidIdentifierException
     * @return array
     */
    public function getUserEmotes($userIdentifier, $accessToken)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($userIdentifier)) {
            throw new InvalidIdentifierException('user');
        }

        return $this->get(sprintf('users/%s/emotes', (string) $userIdentifier), [], $accessToken);
    }

    /**
     * Check if a user is subscribed to a channel
     *
     * @param string|int $userIdentifier
     * @param string|int $channelIdentifier
     * @param string     $accessToken
     * @throws InvalidIdentifierException
     * @return array
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

        return $this->get(sprintf('users/%s/subscriptions/%s', (string) $userIdentifier, (string) $channelIdentifier), [], $accessToken);
    }
}

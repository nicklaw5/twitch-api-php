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
        if ($this->getApiVersion() >= 5) {
            if (!is_numeric($userIdentifier)) {
                throw new InvalidUserIdentifierException();
            }
        }

        return $this->get(sprintf('users/%s', (string) $userIdentifier), []);
    }
}

<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidIdentifierException;

trait Channels
{
    /**
     * Get a user's own channel
     *
     * @param string $accessToken
     * @return array|json
     */
    public function getAuthenticatedChannel($accessToken)
    {
        return $this->get('channel', [], $accessToken);
    }

    /**
     * Get a channel
     *
     * @param string|int $channelIdentifier
     * @throws InvalidIdentifierException
     * @return array|json
     */
    public function getChannel($channelIdentifier)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        return $this->get(sprintf('channels/%s', $channelIdentifier));
    }
}

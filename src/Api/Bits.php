<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\EndpointNotSupportedByApiVersionException;
use TwitchApi\Exceptions\InvalidIdentifierException;

trait Bits
{
    /**
     * Get a list of cheermotes
     *
     * @param string|int $channelIdentifier
     * @throws InvalidIdentifierException
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function getCheermotes($channelIdentifier = null)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        if ($channelIdentifier && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        $params = [
            'channel_id' => $channelIdentifier,
        ];

        return $this->get('bits/actions', $params);
    }
}

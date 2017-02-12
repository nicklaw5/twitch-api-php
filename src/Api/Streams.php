<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidIdentifierException;
use TwitchApi\Exceptions\InvalidStreamTypeException;

trait Streams
{
    /**
     * Get the stream information for a user
     *
     * @param int|string $userIdentifier
     * @param string     $streamType
     * @throws InvalidIdentifierException
     * @throws InvalidStreamTypeException
     * @return array|json
     */
    public function getStreamByUser($userIdendifier, $streamType = 'live')
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($userIdendifier)) {
            throw new InvalidIdentifierException('user');
        }

        if (!$this->isValidStreamType($streamType)) {
            throw new InvalidStreamTypeException();
        }

        return $this->get(sprintf('streams/%s', $userIdendifier), ['stream_type' => $streamType]);
    }

}

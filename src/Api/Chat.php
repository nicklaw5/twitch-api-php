<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidIdentifierException;
trait Chat
{
    /**
     * Get chat badges by channel
     *
     * @param string|int $channelIdentifier
     * @throws InvalidIdentifierException
     * @return array|json
     */
    public function getChannelChatBadges($channelIdentifier)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        return $this->get(sprintf('chat/%s/badges', $channelIdentifier));
    }
}

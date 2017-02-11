<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidIdentifierException;
use TwitchApi\Exceptions\InvalidTypeException;

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

    /**
     * Get chat emoticons by set
     *
     * @param string $emotesets (comma-seperated list)
     * @throws InvalidTypeException
     * @return array|json
     */
    public function getChatEmoticonSets($emotesets = null)
    {
        if ($emotesets && !is_string($emotesets)) {
            throw new InvalidTypeException('emotesets', 'string', gettype($emotesets));
        }

        $emotesets = trim($emotesets, ', ');

        return $this->get('chat/emoticon_images', ['emotesets' => $emotesets]);
    }

    /**
     * Get all chat emotes
     *
     * @return array|json
     */
    public function getAllChatEmoticons()
    {
        return $this->get('chat/emoticons');
    }
}

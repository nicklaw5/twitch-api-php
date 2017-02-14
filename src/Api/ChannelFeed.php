<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidIdentifierException;
use TwitchApi\Exceptions\InvalidLimitException;
use TwitchApi\Exceptions\InvalidTypeException;

trait ChannelFeed
{
    /**
     * Get posts from a specific channel feed
     *
     * @param string|int $channelIdentifier
     * @param string     $accessToken
     * @param int        $limit
     * @param string     $cursor
     * @param int        $comments
     * @throws InvalidIdentifierException
     * @throws InvalidLimitException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function getMultipleFeedPosts($channelIdentifier, $accessToken, $limit = 10, $cursor = null, $comments = 5)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if ($cursor && !is_string($cursor)) {
            throw new InvalidTypeException('Cursor', 'string', gettype($cursor));
        }

        if (!is_int($comments)) {
            throw new InvalidTypeException('Comments', 'integer', gettype($comments));
        }

        $params = [
            'limit' => intval($limit),
            'cursor' => $cursor,
            'comments' => $comments,
        ];

        return $this->get(sprintf('feed/%s/posts', $channelIdentifier), $params, $accessToken);
    }
}

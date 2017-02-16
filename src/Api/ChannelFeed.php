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

    /**
     * Get a specific post from a specific channel feed
     *
     * @param string|int $channelIdentifier
     * @param string     $postId
     * @param string     $accessToken
     * @param int        $comments
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function getFeedPost($channelIdentifier, $postId, $accessToken, $comments = 5)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!is_string($postId)) {
            throw new InvalidTypeException('Post ID', 'integer', gettype($postId));
        }

        if (!is_int($comments)) {
            throw new InvalidTypeException('Comments', 'integer', gettype($comments));
        }

        $params = [
            'comments' => $comments,
        ];

        return $this->get(sprintf('feed/%s/posts/%s', $channelIdentifier, $postId), $params, $accessToken);
    }

    /**
     * Create a post in a specific channel feed
     *
     * @param string|int $channelIdentifier
     * @param string     $accessToken
     * @param string     $content
     * @param boolean    $share
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @throws TwitchApiException
     * @return array|json
     */
    public function createFeedPost($channelIdentifier, $accessToken, $content, $share = false)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!is_string($content)) {
            throw new InvalidTypeException('Content', 'string', gettype($content));
        }

        if (!is_bool($share)) {
            throw new InvalidTypeException('Share', 'boolean', gettype($share));
        }

        $params = [
            'share' => $share,
            'content' => $content,
        ];

        return $this->post(sprintf('feed/%s/posts', $channelIdentifier), $params, $accessToken);
    }
}

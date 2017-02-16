<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidIdentifierException;
use TwitchApi\Exceptions\InvalidLimitException;
use TwitchApi\Exceptions\InvalidTypeException;

trait ChannelFeed
{
    /**
     * Get multiple feed posts
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
     * Get a feed post
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
            throw new InvalidTypeException('Post ID', 'string', gettype($postId));
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
     * Create a fedd post
     *
     * @param string|int $channelIdentifier
     * @param string     $accessToken
     * @param string     $content
     * @param boolean    $share
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
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

    /**
     * Delete a feed post
     *
     * @param string|int $channelIdentifier
     * @param string     $postId
     * @param string     $accessToken
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function deleteFeedPost($channelIdentifier, $postId, $accessToken)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!is_string($postId)) {
            throw new InvalidTypeException('Post ID', 'string', gettype($postId));
        }

        return $this->delete(sprintf('feed/%s/posts/%s', $channelIdentifier, $postId), [], $accessToken);
    }

    /**
     * Create a reaction to a feed post
     *
     * @param string|int $channelIdentifier
     * @param string     $postId
     * @param string     $accessToken
     * @param string     $emoteId
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function createFeedPostReaction($channelIdentifier, $postId, $accessToken, $emoteId)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!is_string($postId)) {
            throw new InvalidTypeException('Post ID', 'string', gettype($postId));
        }

        if (!is_string($emoteId)) {
            throw new InvalidTypeException('Reaction', 'string', gettype($emoteId));
        }

        $params = [
            'emote_id' => $emoteId,
        ];

        return $this->post(sprintf('feed/%s/posts/%s/reactions', $channelIdentifier, $postId), $params, $accessToken);
    }

    /**
     * Delete a reaction to a feed post
     *
     * @param string|int $channelIdentifier
     * @param string     $postId
     * @param string     $accessToken
     * @param string     $emoteId
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function deleteFeedPostReaction($channelIdentifier, $postId, $accessToken, $emoteId)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!is_string($postId)) {
            throw new InvalidTypeException('Post ID', 'string', gettype($postId));
        }

        if (!is_string($emoteId)) {
            throw new InvalidTypeException('Reaction', 'string', gettype($emoteId));
        }

        $params = [
            'emote_id' => $emoteId,
        ];

        return $this->delete(sprintf('feed/%s/posts/%s/reactions', $channelIdentifier, $postId), $params, $accessToken);
    }

    /**
     * Get comments from a feed post
     *
     * @param string|int $channelIdentifier
     * @param string     $postId
     * @param string     $accessToken
     * @param int        $limit
     * @param string     $cursor
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @throws InvalidLimitException
     * @return array|json
     */
    public function getFeedComments($channelIdentifier, $postId, $accessToken, $limit = 10, $cursor = null)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!is_string($postId)) {
            throw new InvalidTypeException('Post ID', 'string', gettype($postId));
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if ($cursor && !is_string($cursor)) {
            throw new InvalidTypeException('Cursor', 'string', gettype($cursor));
        }

        $params = [
            'limit' => intval($limit),
            'cursor' => $cursor,
        ];

        return $this->get(sprintf('feed/%s/posts/%s/comments', $channelIdentifier, $postId), $params, $accessToken);
    }

    /**
     * Create a feed post comment
     *
     * @param string|int $channelIdentifier
     * @param string     $postId
     * @param string     $accessToken
     * @param string     $comment
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function createFeedComment($channelIdentifier, $postId, $accessToken, $comment)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!is_string($comment)) {
            throw new InvalidTypeException('Comment', 'string', gettype($comment));
        }

        $params = [
            'content' => $comment,
        ];

        return $this->post(sprintf('feed/%s/posts/%s/comments', $channelIdentifier, $postId), $params, $accessToken);
    }

    /**
     * Delete a feed post comment
     *
     * @param string|int $channelIdentifier
     * @param string     $postId
     * @param string     $accessToken
     * @param string|int $commentId
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function deleteFeedComment($channelIdentifier, $postId, $commentId, $accessToken)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        return $this->delete(sprintf('feed/%s/posts/%s/comments/%s', $channelIdentifier, $postId, $commentId), [], $accessToken);
    }

    /**
     * Create a reaction to a feed comment
     *
     * @param string|int $channelIdentifier
     * @param string     $postId
     * @param string|int $commentId
     * @param string     $accessToken
     * @param string     $emoteId
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function createFeedCommentReaction($channelIdentifier, $postId, $commentId, $accessToken, $emoteId)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!is_string($postId)) {
            throw new InvalidTypeException('Post ID', 'string', gettype($postId));
        }

        if (!is_string($emoteId)) {
            throw new InvalidTypeException('Reaction', 'string', gettype($emoteId));
        }

        $params = [
            'emote_id' => $emoteId,
        ];

        return $this->post(sprintf('feed/%s/posts/%s/comments/%s/reactions', $channelIdentifier, $postId, $commentId), $params, $accessToken);
    }

    /**
     * Delete a reaction to a feed comment
     *
     * @param string|int $channelIdentifier
     * @param string     $postId
     * @param string|int $commentId
     * @param string     $accessToken
     * @param string     $emoteId
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function deleteFeedCommentReaction($channelIdentifier, $postId, $commentId, $accessToken, $emoteId)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!is_string($postId)) {
            throw new InvalidTypeException('Post ID', 'string', gettype($postId));
        }

        if (!is_string($emoteId)) {
            throw new InvalidTypeException('Reaction', 'string', gettype($emoteId));
        }

        $params = [
            'emote_id' => $emoteId,
        ];

        return $this->delete(sprintf('feed/%s/posts/%s/comments/%s/reactions', $channelIdentifier, $postId, $commentId), $params, $accessToken);
    }
}

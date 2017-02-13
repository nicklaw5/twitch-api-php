<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidTypeException;
use TwitchApi\Exceptions\TwitchApiException;
use TwitchApi\Exceptions\UnsupportedOptionException;

trait Clips
{
    /**
     * Get a clip
     *
     * @param string $channel
     * @param string $slug
     * @throws InvalidTypeException
     * @return array|json
     */
    public function getClip($channel, $slug)
    {
        if (!is_string($channel)) {
            throw new InvalidTypeException('Channel', 'string', gettype($channel));
        }

        if (!is_string($slug)) {
            throw new InvalidTypeException('Slug', 'string', gettype($slug));
        }

        return $this->get(sprintf('clips/%s/%s', $channel, $slug));
    }

    /**
     * Get top clips
     *
     * @param string  $channel (comma-seperated list - 10 max)
     * @param string  $cursor
     * @param string  $game (comma-seperated list - 10 max)
     * @param int     $limit
     * @param string  $period
     * @param boolean $trending
     * @throws InvalidTypeException
     * @throws TwitchApiException
     * @throws InvalidLimitException
     * @throws UnsupportedOptionException
     * @return array|json
     */
    public function getTopClips($channel = null, $cursor = null, $game = null, $limit = 10, $period = 'day', $trending = false)
    {
        $validPeriods = ['day', 'week', 'month', 'all'];

        if ($channel) {
             if (!is_string($channel)) {
                throw new InvalidTypeException('channel', 'string', gettype($channel));
            }

            $channel = trim($channel, ', ');
            if ($count = count(explode(',', $channel) > 10)) {
                throw new TwitchApiException(sprintf('Only a maximum of 10 channels can be queried. %d requested.', $count));
            }
        }

        if ($cursor && !is_string($cursor)) {
            throw new InvalidTypeException('cursor', 'string', gettype($cursor));
        }

        if ($game) {
             if (!is_string($game)) {
                throw new InvalidTypeException('game', 'string', gettype($game));
            }

            $game = trim($game, ', ');
            if ($count = count(explode(',', $game) > 10)) {
                throw new TwitchApiException(sprintf('Only a maximum of 10 gamess can be queried. %d requested.', $count));
            }
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!in_array($period = strtolower($period), $validPeriods)) {
            throw new UnsupportedOptionException('period', $validPeriods);
        }

        if (!is_bool($trending)) {
            throw new InvalidTypeException('trending', 'boolean', gettype($trending));
        }

        $params = [
            'channel' => $channel,
            'cursor' => $cursor,
            'game' => $game,
            'limit' => intval($limit),
            'period' => $period,
            'trending' => $trending ? 'true' : 'false',
        ];

        return $this->get('clips/top', $params);
    }

    /**
     * Get clips from channels followed
     *
     * @param string  $accessToken
     * @param int     $limit
     * @param string  $cursor
     * @param boolean $trending
     * @throws InvalidTypeException
     * @throws InvalidLimitException
     * @return array|json
     */
    public function getFollowedClips($accessToken, $limit = 10, $cursor = null, $trending = false)
    {
        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if ($cursor && !is_string($cursor)) {
            throw new InvalidTypeException('cursor', 'string', gettype($cursor));
        }

        if (!is_bool($trending)) {
            throw new InvalidTypeException('trending', 'boolean', gettype($trending));
        }

        $params = [
            'limit' => intval($limit),
            'cursor' => $cursor,
            'trending' => $trending ? 'true' : 'false',
        ];

        return $this->get('clips/followed', $params, $accessToken);
    }
}

<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidIdentifierException;
use TwitchApi\Exceptions\InvalidLimitException;
use TwitchApi\Exceptions\InvalidOffsetException;
use TwitchApi\Exceptions\InvalidStreamTypeException;
use TwitchApi\Exceptions\InvalidTypeException;

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

    /**
     * Get live streams
     *
     * @param string $channel (comma-seperated list)
     * @param string $game
     * @param string $language
     * @param string $streamType
     * @param int    $limit
     * @param int    $offset
     * @throws InvalidTypeException
     * @throws InvalidIdentifierException
     * @throws InvalidStreamTypeException
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @return array|json
     */
    public function getLiveStreams($channel = null, $game = null, $language = null, $streamType = 'live', $limit = 25, $offset = 0)
    {
        if ($channel) {
            if (!is_string($channel)) {
                throw new InvalidTypeException('channel', 'string', gettype($channel));
            }

            $channel = trim($channel, ', ');
            if ($this->apiVersionIsGreaterThanV4()) {
                foreach (explode(',', $channel) as $chan) {
                    if (!is_numeric($chan)) {
                        throw new InvalidIdentifierException('channel');
                    }
                }
            }
        }

        if ($game && !is_string($game)) {
            throw new InvalidTypeException('game', 'string', gettype($game));
        }

        if ($language && !is_string($language)) {
            throw new InvalidTypeException('language', 'string', gettype($language));
        }

        if (!$this->isValidStreamType($streamType)) {
            throw new InvalidStreamTypeException();
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        $params = [
            'channel' => $channel,
            'game' => $game,
            'language' => $language,
            'stream_type' => $streamType,
            'limit' => intval($limit),
            'offset' => intval($offset),
        ];

        return $this->get('streams', $params);
    }

    /**
     * Gets a summary of live streams
     *
     * @param string $game
     * @throws InvalidTypeException
     * @return array|json
     */
    public function getStreamsSummary($game = null)
    {
        if ($game && !is_string($game)) {
            throw new InvalidTypeException('game', 'string', gettype($game));
        }

        return $this->get('streams/summary', ['game' => $game]);
    }

    /**
     * Get a list of all featured live streams
     *
     * @param int $limit
     * @param int $offset
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @return array|json
     */
    public function getFeaturedStreams($limit = 25, $offset = 0)
    {
        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        $params = [
            'limit' => intval($limit),
            'offset' => intval($offset),
        ];

        return $this->get('streams/featured', $params);
    }

    /**
     * Get followed streams
     *
     * @param string $streamType
     * @param int    $limit
     * @param int    $offset
     * @throws InvalidStreamTypeException
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @return array|json
     */
    public function getFollowedStreams($asccessToken, $streamType = 'live', $limit = 25, $offset = 0)
    {
        if (!$this->isValidStreamType($streamType)) {
            throw new InvalidStreamTypeException();
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        $params = [
            'stream_type' => $streamType,
            'limit' => intval($limit),
            'offset' => intval($offset),
        ];

        return $this->get('streams/followed', $params, $asccessToken);
    }
}

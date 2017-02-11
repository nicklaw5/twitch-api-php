<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidLimitException;
use TwitchApi\Exceptions\InvalidOffsetException;
use TwitchApi\Exceptions\InvalidTypeException;
use TwitchApi\Exceptions\TwitchApiException;

trait Search
{
    /**
     * Search for channels by name or description
     *
     * @param string $query
     * @param int    $limit
     * @param int    $offset
     * @throws InvalidTypeException
     * @throws TwitchApiException
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @return array|json
     */
    public function searchChannels($query, $limit = 25, $offset = 0)
    {
        if (!is_string($query)) {
            throw new InvalidTypeException('Query', 'string', gettype($query));
        }

        if (empty($query)) {
            throw new TwitchApiException('A \'query\' parameter is required.');
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        $params = [
            'query' => $query,
            'limit' => intval($limit),
            'offset' => intval($offset),
        ];

        return $this->get('search/channels', $params);
    }

    /**
     * Search for games by name
     *
     * @param string $query
     * @throws InvalidTypeException
     * @throws TwitchApiException
     * @return array|json
     */
    public function searchGames($query)
    {
        if (!is_string($query)) {
            throw new InvalidTypeException('Query', 'string', gettype($query));
        }

        if (empty($query)) {
            throw new TwitchApiException('A \'query\' parameter is required.');
        }

        return $this->get('search/games', ['query' => $query]);
    }

    /**
     * Search for streams by channel description or game name
     *
     * @param string  $query
     * @param int     $limit
     * @param int     $offset
     * @param boolean $hls
     * @throws InvalidTypeException
     * @throws TwitchApiException
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @return array|json
     */
    public function searchStreams($query, $limit = 25, $offset = 0, $hls = null)
    {
        if (!is_string($query)) {
            throw new InvalidTypeException('Query', 'string', gettype($query));
        }

        if (empty($query)) {
            throw new TwitchApiException('A \'query\' parameter is required.');
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        if ($hls !== null && !is_bool($hls)) {
            throw new InvalidTypeException('HLS', 'boolean', gettype($hls));
        }

        $params = [
            'query' => $query,
            'limit' => intval($limit),
            'offset' => intval($offset),
            'hls' => $hls,
        ];

        return $this->get('search/streams', $params);
    }
}

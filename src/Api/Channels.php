<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidIdentifierException;
use TwitchApi\Exceptions\InvalidTypeException;
use TwitchApi\Exceptions\TwitchApiException;

trait Channels
{
    /**
     * Get a user's own channel
     *
     * @param string $accessToken
     * @return array|json
     */
    public function getAuthenticatedChannel($accessToken)
    {
        return $this->get('channel', [], $accessToken);
    }

    /**
     * Get a channel
     *
     * @param string|int $channelIdentifier
     * @throws InvalidIdentifierException
     * @return array|json
     */
    public function getChannel($channelIdentifier)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        return $this->get(sprintf('channels/%s', $channelIdentifier));
    }

    /**
     * Update a user's channel
     *
     * @param string|int $channelIdentifier
     * @param string     $accessToken
     * @param string     $status
     * @param string     $game
     * @param int        $delay
     * @param bool       $channelFeedEnabled
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @throws TwitchApiException
     * @return array|json
     */
    public function updateChannel($channelIdentifier, $accessToken, $status = null, $game = null, $delay = null, $channelFeedEnabled = null)
    {
        $params = [];
        $params['channel'] = [];

        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if ($status) {
            if (!is_string($status)) {
                throw new InvalidTypeException('Status', 'string', gettype($status));
            }
            $params['channel']['status'] = $status;
        }

        if ($game) {
            if (!is_string($game)) {
                throw new InvalidTypeException('Game', 'string', gettype($game));
            }
            $params['channel']['game'] = $game;
        }

        if ($delay) {
            if (!is_numeric($delay)) {
                throw new InvalidTypeException('Delay', 'integer', gettype($delay));
            }
            $params['channel']['delay'] = intval($delay);
        }

        if ($channelFeedEnabled !== null) {
            if (!is_bool($channelFeedEnabled)) {
                throw new InvalidTypeException('ChannelFeedEnabled', 'boolean', gettype($channelFeedEnabled));
            }
            $params['channel']['channel_feed_enabled'] = $channelFeedEnabled;
        }

        if (empty($params['channels'])) {
            throw new TwitchApiException('At least one of the following parameters must be set: status, game, delay or channelFeedEnabled.');
        }

        return $this->put(sprintf('channels/%s', $channelIdentifier), $params, $accessToken);
    }

}

<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidTypeException;

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

}

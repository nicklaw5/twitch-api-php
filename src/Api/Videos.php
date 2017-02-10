<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidIdentifierException;

trait Videos
{
    /**
     * Get a video
     *
     * @param int|string $videoIdentifier
     * @return array|json
     */
    public function getVideo($videoIdentifier)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($videoIdentifier)) {
            throw new InvalidIdentifierException('video');
        }

        return $this->get(sprintf('videos/%s', $videoIdentifier));
    }
}

<?php

namespace TwitchApi\Api;

trait Root
{
    /**
     * Check if an access token is valid
     *
     * @param string accessToken
     * @return array|json
     */
    public function validateAccessToken($accessToken)
    {
        return $this->get('', [], $accessToken);
    }
}

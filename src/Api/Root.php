<?php

namespace TwitchApi\Api;

trait Root
{
    /**
     * Check if an access token is valid
     *
     * @param string accessToken
     * @return array|string
     */
    public function validateAccessToken($accessToken)
    {
        return $this->get('', [], $accessToken);
    }
}

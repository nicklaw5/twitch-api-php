<?php

namespace TwitchApi\Api;

trait Authentication
{
    /**
     * Get the Twitch OAuth URL.
     *
     * @param string $state
     * @param bool   $forceVerify
     * @return string
     */
    public function getAuthenticationUrl($state = null, $forceVerify = false)
    {
        return implode('', [
            $this->baseUri.'oauth2/authorize?response_type=code',
            '&client_id='.$this->clientId,
            '&redirect_uri='.$this->redirectUri,
            '&scope='.implode('+', $this->scope),
            '&state='.$state,
            '&force_verify='.$forceVerify,
        ]);
    }
}

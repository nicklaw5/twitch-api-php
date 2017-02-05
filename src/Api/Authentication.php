<?php

namespace TwitchApi\Api;

trait Authentication
{
    /**
     * Get the Twitch OAuth URL
     *
     * @param string $state
     * @param bool   $forceVerify
     * @return string
     */
    public function getAuthenticationUrl($state = null, $forceVerify = false)
    {
        return implode('', [
            sprintf('%soauth2/authorize', $this->baseUri),
            '?response_type=code',
            sprintf('&client_id=%s', $this->getClientId()),
            sprintf('&redirect_uri=%s', $this->getRedirectUri()),
            sprintf('&scope=%s', implode('+', $this->getScope())),
            sprintf('&state=%s', $state),
            sprintf('&force_verify=%s', $forceVerify ? 'true' : 'false'),
        ]);
    }

    /**
     * Get a user's access credentials, which includes the access token
     *
     * @param string $code
     * @param string $state
     * @return array
     */
    public function getAccessCredentials($code, $state = null)
    {
        $params = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUri,
            'code' => $code,
            'state' => $state,
        ];

        return $this->post('oauth2/token', $params);
    }
}

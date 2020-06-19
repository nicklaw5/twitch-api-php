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
     * @return array|string
     */
    public function getAccessCredentials($code, $state = null)
    {
        return $this->post('oauth2/token', [
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->getRedirectUri(),
            'code' => $code,
            'state' => $state,
        ]);
    }

    /**
     * Get a new access token
     *
     * @param string $refreshToken
     * @return array|string
     */
    public function refreshToken($refreshToken)
    {
        return $this->post('oauth2/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
        ]);
    }

    /**
     * Revoke an access token
     *
     * @param string $accessToken
     * @return array|string
     */
    public function revokeToken($accessToken)
    {
        return $this->post('oauth2/revoke', [
            'client_id' => $this->getClientId(),
            'token' => $accessToken,
        ]);
    }
}

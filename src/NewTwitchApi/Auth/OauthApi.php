<?php

declare(strict_types=1);

namespace NewTwitchApi\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class OauthApi
{
    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var Client|AuthGuzzleClient
     */
    protected $guzzleClient;

    /**
     * OauthApi constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param Client|null $guzzleClient
     */
    public function __construct(string $clientId, string $clientSecret, Client $guzzleClient = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->guzzleClient = $guzzleClient ?? new AuthGuzzleClient();
    }

    /**
     * Get auth URL
     *
     * @param string $redirectUri
     * @param string $responseType
     * @param string $scope
     * @param bool $forceVerify
     * @param string|null $state
     * @return string A full authentication URL, including the Guzzle client's base URI.
     */
    public function getAuthUrl(string $redirectUri, string $responseType = 'code', string $scope = '', bool $forceVerify = false, string $state = null): string
    {
        return sprintf(
            '%s%s',
            $this->guzzleClient->getConfig('base_uri'),
            $this->getPartialAuthUrl($redirectUri, $responseType, $scope, $forceVerify, $state)
        );
    }

    /**
     * Get user access token
     *
     * @param $code
     * @param string $redirectUri
     * @param null $state
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getUserAccessToken($code, string $redirectUri, $state = null): ResponseInterface
    {
        return $this->makeRequest(
            new Request('POST', 'token'),
            [
                RequestOptions::JSON => [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $redirectUri,
                    'code' => $code,
                    'state' => $state,
                ]
            ]
        );
    }

    /**
     * Refresh token
     *
     * @param string $refeshToken
     * @param string $scope
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function refreshToken(string $refeshToken, string $scope = ''): ResponseInterface
    {
        $requestOptions = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refeshToken,
        ];
        if ($scope) {
            $requestOptions['scope'] = $scope;
        }

        return $this->makeRequest(
            new Request('POST', 'token'),
            [
                RequestOptions::JSON => $requestOptions
            ]
        );
    }

    /**
     * Validate token
     *
     * @param string $accessToken
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function validateAccessToken(string $accessToken): ResponseInterface
    {
        return $this->makeRequest(
            new Request(
                'GET',
                'validate',
                [
                    'Authorization' => sprintf('OAuth %s', $accessToken)
                ]
            )
        );
    }

    /**
     * Is the access token valid?
     *
     * @param string $accessToken
     * @return bool
     * @throws GuzzleException
     */
    public function isValidAccessToken(string $accessToken): bool
    {
        return $this->validateAccessToken($accessToken)->getStatusCode() === 200;
    }

    /**
     * Get app access token
     *
     * @param string $scope
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getAppAccessToken(string $scope = ''): ResponseInterface
    {
        return $this->makeRequest(
            new Request('POST', 'token'),
            [
                RequestOptions::JSON => [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type' => 'client_credentials',
                    'scope' => $scope,
                ]
            ]
        );
    }

    /**
     * Make a request
     *
     * @param Request $request
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function makeRequest(Request $request, array $options = []): ResponseInterface
    {
        return $this->guzzleClient->send($request, $options);
    }

    /**
     * Get partial auth URL
     *
     * @param string $redirectUri
     * @param string $responseType
     * @param string $scope
     * @param bool $forceVerify
     * @param string|null $state
     * @return string A partial authentication URL, excluding the Guzzle client's base URI.
     */
    protected function getPartialAuthUrl(string $redirectUri, string $responseType = 'code', string $scope = '', bool $forceVerify = false, string $state = null): string
    {
        $optionalParameters = '';
        $optionalParameters .= $forceVerify ? '&force_verify=true' : '';
        $optionalParameters .= $state ? sprintf('&state=%s', $state) : '';

        return sprintf(
            'authorize?client_id=%s&redirect_uri=%s&response_type=%s&scope=%s%s',
            $this->clientId,
            $redirectUri,
            $responseType,
            $scope,
            $optionalParameters
        );
    }
}

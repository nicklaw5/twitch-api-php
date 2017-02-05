<?php

namespace TwitchApi;

use TwitchApi\Exceptions\InvalidScopeTypeException;
use TwitchApi\Exceptions\UnsupportedApiVersionException;

class TwitchApi extends TwitchRequest
{
    const DEFAULT_API_VERSION = 5;
    const SUPPORTED_API_VERSIONS = [3, 5];

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var int
     */
    protected $apiVersion;

    /**
     * @var string
     */
    protected $redirectUri;

    /**
     * @var array
     */
    protected $scope;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $accessToken;


    /**
     * Instantiate a new TwitchApi instance
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->setScope(isset($options['scope']) ? $options['scope'] : []);
        $this->setClientId(isset($options['client_id']) ? $options['client_id'] : null);
        $this->setRedirectUri(isset($options['redirect_uri']) ? $options['redirect_uri'] : null);
        $this->setClientSecret(isset($options['client_secret']) ? $options['client_secret'] : null);
        $this->setApiVersion(isset($options['api_version']) ? $options['api_version'] : self::DEFAULT_API_VERSION);
    }

    /**
     * Set client ID
     *
     * @param string
     */
    public function setClientId($clientId)
    {
        $this->clientId = (string) $clientId;
    }

    /**
     * Get client ID
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set client secret
     *
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = (string) $clientSecret;
    }

    /**
     * Set API version
     *
     * @param string|int $apiVersion
     * @throws UnsupportedApiVersionException
     */
    public function setApiVersion($apiVersion)
    {
        if (!in_array($apiVersion = intval($apiVersion), self::SUPPORTED_API_VERSIONS)) {
            throw new UnsupportedApiVersionException();
        }

        $this->apiVersion = $apiVersion;
    }

    /**
     * Get API version
     *
     * @return int
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Set redirect URI
     *
     * @param string $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = (string) $redirectUri;
    }

    /**
     * Get redirect URI
     *
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Set scope
     *
     * @param array $scope
     * @throws InvalidScopeTypeException
     */
    public function setScope($scope)
    {
        if (!is_array($scope)) {
            throw new InvalidScopeTypeException(gettype($scope));
        }

        $this->scope = $scope;
    }

    /**
     * Get scope
     *
     * @return array
     */
    public function getScope()
    {
        return $this->scope;
    }
}

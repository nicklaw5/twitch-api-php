<?php

namespace TwitchApi;

use TwitchApi\Exceptions\UnsupportedApiVersionException;

class TwitchApi extends Request
{
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
    protected $apiVersion = 5;

    /**
     * @var string
     */
    protected $redirectUri;

    /**
     * @var array
     */
    protected $scope = [];

    public function __construct(array $options = [])
    {
        $this->clientId = $options['client_id'] ?? null;
        $this->clientSecret = $options['client_secrect'] ?? null;
        $this->apiVersion = $options['api_version'] ? $this->setApiVersion($options['api_version']) : $this->apiVersion;
        $this->redirectUri = $options['redirect_uri'] ?? null;
        $this->scope = $options['scope'] ?? $this->scope;
    }

    /**
     * Set the API version to use for each API request.
     *
     * @param string|int $apiVersion
     */
    public function setApiVersion($apiVersion)
    {
        if (!in_array($apiVersion = intval($apiVersion), self::SUPPORTED_API_VERSIONS)) {
            throw new UnsupportedApiVersionException();
        }

        $this->apiVersion = $apiVersion;
    }
}

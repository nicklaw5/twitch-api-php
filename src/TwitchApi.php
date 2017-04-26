<?php

namespace TwitchApi;

use TwitchApi\Api\Authentication;
use TwitchApi\Api\Bits;
use TwitchApi\Api\ChannelFeed;
use TwitchApi\Api\Channels;
use TwitchApi\Api\Chat;
use TwitchApi\Api\Clips;
use TwitchApi\Api\Collections;
use TwitchApi\Api\Communities;
use TwitchApi\Api\Games;
use TwitchApi\Api\Ingests;
use TwitchApi\Api\Root;
use TwitchApi\Api\Search;
use TwitchApi\Api\Streams;
use TwitchApi\Api\Teams;
use TwitchApi\Api\Users;
use TwitchApi\Api\Videos;
use TwitchApi\Exceptions\ClientIdRequiredException;
use TwitchApi\Exceptions\InvalidTypeException;
use TwitchApi\Exceptions\UnsupportedApiVersionException;

class TwitchApi extends TwitchRequest
{
    use Authentication;
    use Bits;
    use ChannelFeed;
    use Channels;
    use Chat;
    use Clips;
    use Collections;
    use Communities;
    use Games;
    use Ingests;
    use Root;
    use Search;
    use Streams;
    use Teams;
    use Users;
    use Videos;

    /**
     * @var int
     */
    protected $defaultApiVersion = 5;

    /**
     * @var array
     */
    protected $supportedApiVersions = [3, 4, 5];

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
        if (!isset($options['client_id'])) {
            throw new ClientIdRequiredException();
        }

        $this->setClientId($options['client_id']);
        $this->setClientSecret(isset($options['client_secret']) ? $options['client_secret'] : null);
        $this->setRedirectUri(isset($options['redirect_uri']) ? $options['redirect_uri'] : null);
        $this->setApiVersion(isset($options['api_version']) ? $options['api_version'] : $this->getDefaultApiVersion());
        $this->setScope(isset($options['scope']) ? $options['scope'] : []);
    }

    /**
     * Get defaultApiVersion
     *
     * @return int
     */
    public function getDefaultApiVersion()
    {
        return $this->defaultApiVersion;
    }

    /**
     * Get supportedApiVersions
     *
     * @return array
     */
    public function getSupportedApiVersions()
    {
        return $this->supportedApiVersions;
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
     * Get client secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Set API version
     *
     * @param string|int $apiVersion
     * @throws UnsupportedApiVersionException
     */
    public function setApiVersion($apiVersion)
    {
        if (!in_array($apiVersion = intval($apiVersion), $this->getSupportedApiVersions())) {
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
     * @throws InvalidTypeException
     */
    public function setScope($scope)
    {
        if (!is_array($scope)) {
            throw new InvalidTypeException('Scope', 'array', gettype($scope));
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

    /**
     * Returns true if the set API version is greater than v4
     *
     * @return bool
     */
    protected function apiVersionIsGreaterThanV4()
    {
        if ($this->getApiVersion() > 4) {
            return true;
        }

        return false;
    }

    /**
     * Return true if the provided limit is valid
     *
     * @param string|int $limit
     * @return bool
     */
    protected function isValidLimit($limit)
    {
        if (is_numeric($limit) && $limit > 0) {
            return true;
        }

        return false;
    }

    /**
     * Return true if the provided offset is valid
     *
     * @param string|int $offset
     * @return bool
     */
    protected function isValidOffset($offset)
    {
        if (is_numeric($offset) && $offset > -1) {
            return true;
        }

        return false;
    }

    /**
     * Return true if the provided direction is valid
     *
     * @param string $direction
     * @return bool
     */
    protected function isValidDirection($direction)
    {
        $validDirections = ['asc', 'desc'];

        if (in_array(strtolower($direction), $validDirections)) {
            return true;
        }

        return false;
    }

    /**
     * Return true if the provided broadcast type is valid
     *
     * @param string $broadcastType
     * @return bool
     */
    protected function isValidBroadcastType($broadcastType)
    {
        $validBroadcastTypes = ['archive', 'highlight', 'upload'];

        $broadcastTypeArray = explode(',', $broadcastType);
        foreach ($broadcastTypeArray as $type) {
            if (!in_array($type, $validBroadcastTypes)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return true if the provided stream type is valid
     *
     * @param string $streamType
     * @return bool
     */
    protected function isValidStreamType($streamType)
    {
        $validStreamTypes = ['live', 'playlist', 'all'];

        if (in_array(strtolower($streamType), $validStreamTypes)) {
            return true;
        }

        return false;
    }
}

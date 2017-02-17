<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidTypeException;
use TwitchApi\Exceptions\EndpointNotSupportedByApiVersionException;

trait Communities
{
    /**
     * Get community by name
     *
     * @param string $name
     * @throws InvalidTypeException
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function getCommunityByName($name)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if (!is_string($name)) {
            throw new InvalidTypeException('Name', 'string', gettype($name));
        }

        return $this->get('communities', ['name' => $name]);
    }

    /**
     * Get community by ID
     *
     * @param string $id
     * @throws InvalidTypeException
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function getCommunityById($id)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if (!is_string($id)) {
            throw new InvalidTypeException('ID', 'string', gettype($id));
        }

        return $this->get(sprintf('communities/%s', $id));
    }
}

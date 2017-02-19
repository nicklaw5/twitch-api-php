<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\EndpointNotSupportedByApiVersionException;
use TwitchApi\Exceptions\InvalidEmailAddressException;
use TwitchApi\Exceptions\InvalidParameterLengthException;
use TwitchApi\Exceptions\InvalidTypeException;

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

    /**
     * Create a community
     *
     * @param string $name
     * @param string $summary
     * @param string $description
     * @param string $rules
     * @param string $accessToken
     * @throws InvalidParameterLengthException
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function createCommunity($name, $summary, $description, $rules, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if (strlen($name) < 3 || strlen($name) > 25) {
            throw new InvalidParameterLengthException('name');
        }

        if (strlen($summary) > 160) {
            throw new InvalidParameterLengthException('summary');
        }

        if (strlen($description) > 1572864) { // 1.5MB
            throw new InvalidParameterLengthException('description');
        }

        if (strlen($rules) > 1572864) { // 1.5MB
            throw new InvalidParameterLengthException('rules');
        }

        $params = [
            'name' => $name,
            'summary' => $summary,
            'description' => $description,
            'rules' => $rules,
        ];

        return $this->post('communities', $params, $accessToken);
    }

    /**
     * Update a community
     *
     * @param string $communityId
     * @param string $accessToken
     * @param string $summary
     * @param string $description
     * @param string $rules
     * @param string $email
     * @throws InvalidParameterLengthException
     * @throws EndpointNotSupportedByApiVersionException
     * @throws InvalidEmailAddressException
     * @return array|json
     */
    public function updateCommunity($communityId, $accessToken, $summary = null, $description = null, $rules = null, $email = null)
    {
        $params = [];

        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if ($summary) {
            if (strlen($summary) > 160) {
                throw new InvalidParameterLengthException('summary');
            }
            $params['summary'] = $summary;
        }

        if ($description) {
            if (strlen($description) > 1572864) { // 1.5MB
                throw new InvalidParameterLengthException('description');
            }
            $params['description'] = $description;
        }

        if ($rules) {
            if (strlen($rules) > 1572864) { // 1.5MB
                throw new InvalidParameterLengthException('rules');
            }
            $params['rules'] = $rules;
        }

        if ($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                throw new InvalidEmailAddressException();
            }
            $params['email'] = $email;
        }

        return $this->put(sprintf('communities/%s', $communityId), $params, $accessToken);
    }
}

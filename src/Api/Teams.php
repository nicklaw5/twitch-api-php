<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\InvalidLimitException;
use TwitchApi\Exceptions\InvalidOffsetException;
use TwitchApi\Exceptions\InvalidTypeException;

trait Teams
{
    /**
     * Get a team by name
     *
     * @param string $name
     * @throws InvalidTypeException
     * @return array|json
     */
    public function getTeam($name)
    {
        if (!is_string($name)) {
            throw new InvalidTypeException('Name', 'string', gettype($name));
        }

        return $this->get(sprintf('teams/%s', $name));
    }

    /**
     * Get all active teams
     *
     * @param int $limit
     * @param int $offset
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @return array|json
     */
    public function getAllTeams($limit = 25, $offset = 0)
    {
        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        $params = [
            'limit' => intval($limit),
            'offset' => intval($offset),
        ];

        return $this->get('teams', $params);
    }
}

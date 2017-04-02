<?php

namespace TwitchApi\Exceptions;

class EndpointNotSupportedByApiVersionException extends TwitchApiException
{
    /**
     * @var string $endpoint
     */
    public function __construct()
    {
        parent::__construct('This endpoint is not supported by the set API version.');
    }
}

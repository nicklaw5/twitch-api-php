<?php

namespace TwitchApi\Exceptions;

class EndpointNotSupportedByApiVersionException extends TwitchApiException
{
    /**
     * @var string $endpoint
     */
    public function __construct($endpoint)
    {
        parent::__construct(sprintf('The \'%s\' endpoint is not supported by the set API version.', $endpoint));
    }
}

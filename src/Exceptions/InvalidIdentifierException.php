<?php

namespace TwitchApi\Exceptions;

class InvalidIdentifierException extends TwitchApiException
{
    /**
     * @var string $type
     */
    public function __construct($type)
    {
        parent::__construct(sprintf('Invalid %s identifier provided.', $type));
    }
}

<?php

namespace TwitchApi\Exceptions;

class InvalidIdentifierException extends TwitchApiException
{
    public function __construct($type)
    {
        parent::__construct(sprintf('Invalid %s identifier provided.', $type));
    }
}

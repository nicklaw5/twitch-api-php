<?php

namespace TwitchApi\Exceptions;

class InvalidOffsetException extends TwitchApiException
{
    public function __construct()
    {
        parent::__construct('Invalid \'offset\' provided. Offset must be numeric with a value of 0 or greater.');
    }
}

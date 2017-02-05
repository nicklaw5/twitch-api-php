<?php

namespace TwitchApi\Exceptions;

class InvalidScopeTypeException extends InvalidTypeException
{
    public function __construct($provided)
    {
        parent::__construct('Scope expects to be of type \'array\', \''.$provided.'\' provided instead.');
    }
}

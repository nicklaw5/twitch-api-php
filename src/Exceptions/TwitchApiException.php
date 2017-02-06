<?php

namespace TwitchApi\Exceptions;

class TwitchApiException extends \Exception
{
    /**
     * @var string $message
     * @var int    $code
     */
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }
}

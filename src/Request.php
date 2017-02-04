<?php

namespace TwitchApi;

use GuzzleHttp\Client;

class Request
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var float
     */
    protected $timeout = 10.0;

    public function __construct()
    {
        $client = new Client([
            'base_uri' => 'http://httpbin.org',
            'timeout'  => $this->timeout,
        ]);
    }
}

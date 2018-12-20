<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use GuzzleHttp\Exception\GuzzleException;
use NewTwitchApi\Cli\Exceptions\ExitCliException;
use Psr\Http\Message\ResponseInterface;

interface CliEndpointInterface
{
    public function getName(): string;
    /**
     * @throws ExitCliException
     * @throws GuzzleException
     */
    public function execute(): ResponseInterface;
}

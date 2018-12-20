<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\Cli\Exceptions\ExitCliException;
use Psr\Http\Message\ResponseInterface;

class ExitCliEndpoint extends AbstractCliEndpoint
{
    public function __construct()
    {
        // Don't need Guzzle client to quit
    }

    public function getName(): string
    {
        return 'Quit';
    }

    /** @throws ExitCliException */
    public function execute(): ResponseInterface
    {
        throw new ExitCliException('Exit from CLI client requested.');
    }
}

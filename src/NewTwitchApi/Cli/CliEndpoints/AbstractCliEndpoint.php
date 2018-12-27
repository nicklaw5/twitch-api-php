<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\Cli\IO\InputOutput;
use NewTwitchApi\Cli\IO\InputReader;
use NewTwitchApi\Cli\IO\OutputWriter;
use NewTwitchApi\NewTwitchApi;

abstract class AbstractCliEndpoint implements CliEndpointInterface
{
    private $twitchApi;
    private $inputOutput;

    public function __construct(NewTwitchApi $twitchApi, InputOutput $inputOutput)
    {
        $this->twitchApi = $twitchApi;
        $this->inputOutput = $inputOutput;
    }

    public function getTwitchApi(): NewTwitchApi
    {
        return $this->twitchApi;
    }

    public function getInputReader(): InputReader
    {
        return $this->inputOutput->getInputReader();
    }

    public function getOutputWriter(): OutputWriter
    {
        return $this->inputOutput->getOutputWriter();
    }
}

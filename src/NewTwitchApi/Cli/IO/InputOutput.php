<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\IO;

use NewTwitchApi\Cli\IO\InputReader;
use NewTwitchApi\Cli\IO\OutputWriter;

class InputOutput
{
    private $inputReader;
    private $outputWriter;

    public function __construct(InputReader $inputReader, OutputWriter $outputWriter)
    {
        $this->inputReader = $inputReader;
        $this->outputWriter = $outputWriter;
    }

    public function getInputReader(): InputReader
    {
        return $this->inputReader;
    }

    public function getOutputWriter(): OutputWriter
    {
        return $this->outputWriter;
    }
}

<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\IO;

class InputReader
{
    private $stdin;

    public function __construct(Stdin $stdin)
    {
        $this->stdin = $stdin;
    }

    public function readFromStdin(): string
    {
        return trim($this->stdin->read());
    }

    public function readIntFromStdin(): int
    {
        return (int) $this->readFromStdin();
    }

    public function readCSVIntoArrayFromStdin(): array
    {
        return array_filter(explode(',', $this->readFromStdin()));
    }
}

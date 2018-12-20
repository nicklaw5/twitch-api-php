<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\IO;

class Stdin
{
    public function read(): string
    {
        return fgets(STDIN);
    }
}

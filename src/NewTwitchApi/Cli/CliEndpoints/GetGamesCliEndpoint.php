<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use Psr\Http\Message\ResponseInterface;

class GetGamesCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get Games';
    }

    public function execute(): ResponseInterface
    {
        $this->getOutputWriter()->write('IDs (separated by commas): ');
        $ids = $this->getInputReader()->readCSVIntoArrayFromStdin();
        $this->getOutputWriter()->write('Names (separated by commas): ');
        $names = $this->getInputReader()->readCSVIntoArrayFromStdin();

        return $this->getTwitchApi()->getGamesApi()->getGames($ids, $names);
    }
}

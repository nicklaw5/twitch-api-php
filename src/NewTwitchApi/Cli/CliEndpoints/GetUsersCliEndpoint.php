<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use Psr\Http\Message\ResponseInterface;

class GetUsersCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get Users';
    }

    public function execute(): ResponseInterface
    {
        $this->getOutputWriter()->write('IDs (separated by commas): ');
        $ids = $this->getInputReader()->readCSVIntoArrayFromStdin();
        $this->getOutputWriter()->write('Usernames (separated by commas): ');
        $usernames = $this->getInputReader()->readCSVIntoArrayFromStdin();
        $this->getOutputWriter()->write('Include email address? (y/n) ');
        $includeEmail = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getUsersApi()->getUsers(
            $ids,
            $usernames,
            $includeEmail === 'y'
        );
    }
}

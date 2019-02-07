<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use Psr\Http\Message\ResponseInterface;

class GetUsersFollowsCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get Users Follows';
    }

    public function execute(): ResponseInterface
    {
        $this->getOutputWriter()->write('Follower ID: ');
        $followerId = $this->getInputReader()->readFromStdin();
        $this->getOutputWriter()->write('Followed User ID: ');
        $followedUserId = $this->getInputReader()->readFromStdin();
        $this->getOutputWriter()->write('Max results to return: ');
        $first = $this->getInputReader()->readIntFromStdin();
        $this->getOutputWriter()->write('Cursor value next page starts with: ');
        $after = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getUsersApi()->getUsersFollows(
            $followerId,
            $followedUserId,
            $first,
            $after
        );
    }
}

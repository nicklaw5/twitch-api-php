<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use Psr\Http\Message\ResponseInterface;

class GetUserWithAccessTokenCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get User with Access Token';
    }

    public function execute(): ResponseInterface
    {
        $this->getOutputWriter()->write('Access Token: ');
        $accessToken = $this->getInputReader()->readFromStdin();
        $this->getOutputWriter()->write('Include email address? (y/n) ');
        $includeEmail = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getUsersApi()->getUserByAccessToken(
            $accessToken,
            $includeEmail === 'y'
        );
    }
}

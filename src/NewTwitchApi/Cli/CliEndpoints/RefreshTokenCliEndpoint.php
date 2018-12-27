<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use Psr\Http\Message\ResponseInterface;

class RefreshTokenCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Refresh an Access Token';
    }

    public function execute(): ResponseInterface
    {
        $this->getOutputWriter()->write('Refresh token: ');
        $refreshToken = $this->getInputReader()->readFromStdin();
        $this->getOutputWriter()->write('Scope (comma-separated string): ');
        $scope = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getOauthApi()->refreshToken($refreshToken, $scope);
    }
}

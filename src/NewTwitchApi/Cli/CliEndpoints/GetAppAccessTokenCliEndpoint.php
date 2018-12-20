<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use Psr\Http\Message\ResponseInterface;

class GetAppAccessTokenCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get an App Access Token';
    }

    public function execute(): ResponseInterface
    {
        $this->getOutputWriter()->write('Scope: ');
        $scope = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getOauthApi()->getAppAccessToken($scope);
    }
}

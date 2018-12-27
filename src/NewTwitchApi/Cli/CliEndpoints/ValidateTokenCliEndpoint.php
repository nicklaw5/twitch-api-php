<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use Psr\Http\Message\ResponseInterface;

class ValidateTokenCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Validate an Access Token';
    }

    public function execute(): ResponseInterface
    {
        $this->getOutputWriter()->write('Access token: ');
        $accessToken = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getOauthApi()->validateAccessToken($accessToken);
    }
}

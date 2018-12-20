<?php

declare(strict_types = 1);

namespace NewTwitchApi\Cli;

use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use InvalidArgumentException;
use NewTwitchApi\Auth\AuthGuzzleClient;
use NewTwitchApi\Cli\CliEndpoints\CliEndpointInterface;
use NewTwitchApi\Cli\CliEndpoints\ExitCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\GetAppAccessTokenCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\GetGamesCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\GetStreamsCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\GetUsersCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\GetUsersFollowsCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\GetUserWithAccessTokenCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\GetWebhookSubscriptionsCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\RefreshTokenCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\ValidateTokenCliEndpoint;
use NewTwitchApi\Cli\Exceptions\ExitCliException;
use NewTwitchApi\Cli\IO\InputOutput;
use NewTwitchApi\Cli\IO\InputReader;
use NewTwitchApi\Cli\IO\OutputWriter;
use NewTwitchApi\Cli\IO\Stdin;
use NewTwitchApi\HelixGuzzleClient;
use NewTwitchApi\NewTwitchApi;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CliClient
{
    /** @var array */
    private $endpoints;

    private $request;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(array $argv)
    {
        if (!isset($argv[1], $argv[2])) {
            throw new InvalidArgumentException(sprintf('Usage: php %s <client-id> <client-secret>', $argv[0]));
        }

        $clientId = $argv[1];
        $clientSecret = $argv[2];

        $helixGuzzleClient = $this->getHelixGuzzleClient($clientId);
        $authGuzzleclient = $this->getAuthGuzzleClient();
        $newTwitchApi = new NewTwitchApi($helixGuzzleClient, $clientId, $clientSecret, $authGuzzleclient);
        $inputOutput = new InputOutput(
            new InputReader(new Stdin()),
            new OutputWriter()
        );
        $this->endpoints = [
            new ExitCliEndpoint(),
            new ValidateTokenCliEndpoint($newTwitchApi, $inputOutput),
            new RefreshTokenCliEndpoint($newTwitchApi, $inputOutput),
            new GetAppAccessTokenCliEndpoint($newTwitchApi, $inputOutput),
            new GetGamesCliEndpoint($newTwitchApi, $inputOutput),
            new GetStreamsCliEndpoint($newTwitchApi, $inputOutput),
            new GetUsersCliEndpoint($newTwitchApi, $inputOutput),
            new GetUserWithAccessTokenCliEndpoint($newTwitchApi, $inputOutput),
            new GetUsersFollowsCliEndpoint($newTwitchApi, $inputOutput),
            new GetWebhookSubscriptionsCliEndpoint($newTwitchApi, $inputOutput),
        ];
    }

    public function run(): void
    {
        echo 'Twitch API Testing Tool'.PHP_EOL;

        while (true) {
            try {
                $endpoint = $this->promptForEndpoint();
                echo $endpoint->getName() . PHP_EOL;
                $response = $endpoint->execute();
                echo PHP_EOL . $this->getRequest()->getRequestTarget() . PHP_EOL;
                $this->printResponse($response);
            } catch (ClientException $e) {
                echo PHP_EOL . $this->getRequest()->getRequestTarget() . PHP_EOL;
                $this->printResponse($e->getResponse());
            } catch (ExitCliException $e) {
                exit;
            } catch (Exception | GuzzleException $e) {
                echo $e->getMessage().PHP_EOL;
            }
        }
    }

    /** @throws InvalidArgumentException */
    private function promptForEndpoint(): CliEndpointInterface
    {
        echo PHP_EOL;
        echo 'Which endpoint would you like to call?'.PHP_EOL;
        foreach ($this->endpoints as $key => $endpoint) {
            echo sprintf('%d) %s'.PHP_EOL, $key, $endpoint->getName());
        }
        echo 'Choice: ';
        $choice = (int) fgets(STDIN);
        echo PHP_EOL;

        if (!array_key_exists($choice, $this->endpoints)) {
            throw new InvalidArgumentException('Invalid choice.');
        }

        return $this->endpoints[$choice];
    }

    private function getHelixGuzzleClient(string $clientId): HelixGuzzleClient
    {
        return new HelixGuzzleClient($clientId, [
            'handler' => $this->createRequestHandlerStack(),
        ]);
    }

    private function getAuthGuzzleClient(): AuthGuzzleClient
    {
        return new AuthGuzzleClient([
            'handler' => $this->createRequestHandlerStack(),
        ]);
    }

    private function createRequestHandlerStack(): HandlerStack
    {
        $handlerStack = HandlerStack::create();
        $handlerStack->push(
            $this->createGuzzleRequestMiddleware()
        );

        return $handlerStack;
    }

    private function createGuzzleRequestMiddleware(): callable
    {
        return Middleware::tap(function ($request) {
            $this->setRequest($request);
        });
    }

    private function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    /**
     * @param ResponseInterface $response
     */
    private function printResponse(ResponseInterface $response): void
    {
        echo PHP_EOL . json_encode(json_decode($response->getBody()->getContents()), JSON_PRETTY_PRINT) . PHP_EOL;
    }
}

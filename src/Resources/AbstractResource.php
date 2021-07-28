<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use TwitchApi\HelixGuzzleClient;
use TwitchApi\RequestGenerator;

abstract class AbstractResource
{
    protected $guzzleClient;
    private $requestGenerator;

    public function __construct(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator)
    {
        $this->guzzleClient = $guzzleClient;
        $this->requestGenerator = $requestGenerator;
    }

    /**
     * @throws GuzzleException
     */
    protected function getApi(string $uriEndpoint, string $bearer, array $queryParamsMap = [], array $bodyParams = []): ResponseInterface
    {
        return $this->sendToApi('GET', $uriEndpoint, $bearer, $queryParamsMap, $bodyParams);
    }

    /**
     * @throws GuzzleException
     */
    protected function getApiWithOptionalAuth(string $uriEndpoint, string $bearer = null, array $queryParamsMap = [], array $bodyParams = []): ResponseInterface
    {
        return $this->sendToApi('GET', $uriEndpoint, $bearer, $queryParamsMap, $bodyParams);
    }

    /**
     * @throws GuzzleException
     */
    protected function deleteApi(string $uriEndpoint, string $bearer, array $queryParamsMap = [], array $bodyParams = []): ResponseInterface
    {
        return $this->sendToApi('DELETE', $uriEndpoint, $bearer, $queryParamsMap, $bodyParams);
    }

    /**
     * @throws GuzzleException
     */
    protected function patchApi(string $uriEndpoint, string $bearer, array $queryParamsMap = [], array $bodyParams = []): ResponseInterface
    {
        return $this->sendToApi('PATCH', $uriEndpoint, $bearer, $queryParamsMap, $bodyParams);
    }

    /**
     * @throws GuzzleException
     */
    protected function postApi(string $uriEndpoint, string $bearer, array $queryParamsMap = [], array $bodyParams = []): ResponseInterface
    {
        return $this->sendToApi('POST', $uriEndpoint, $bearer, $queryParamsMap, $bodyParams);
    }

    /**
     * @throws GuzzleException
     */
    protected function putApi(string $uriEndpoint, string $bearer, array $queryParamsMap = [], array $bodyParams = []): ResponseInterface
    {
        return $this->sendToApi('PUT', $uriEndpoint, $bearer, $queryParamsMap, $bodyParams);
    }

    private function sendToApi(string $httpMethod, string $uriEndpoint, string $bearer = null, array $queryParamsMap = [], array $bodyParams = []): ResponseInterface
    {
        return $this->guzzleClient->send($this->requestGenerator->generate($httpMethod, $uriEndpoint, $bearer, $queryParamsMap, $bodyParams));
    }
}

<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractResource
{
    protected $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
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

    private function sendToApi(string $httpMethod, string $uriEndpoint, string $bearer, array $queryParamsMap = [], array $bodyParams = []): ResponseInterface
    {
        if (count($bodyParams) > 0) {
            $request = new Request(
                $httpMethod,
                sprintf('%s%s',
                $uriEndpoint,
                $this->generateQueryParams($queryParamsMap)),
                ['Authorization' => sprintf('Bearer %s', $bearer), 'Accept' => 'application/json'],
                json_encode($bodyParams)
            );
        } else {
            $request = new Request(
                $httpMethod,
                sprintf('%s%s',
                $uriEndpoint,
                $this->generateQueryParams($queryParamsMap)),
                ['Authorization' => sprintf('Bearer %s', $bearer)]
            );
        }

        return $this->guzzleClient->send($request);
    }

    /**
     * $queryParamsMap should be a mapping of the param key expected in the API call URL,
     * and the value to be sent for that key.
     *
     * [['key' => 'param_key', 'value' => 42],['key' => 'other_key', 'value' => 'asdf']]
     * would result in
     * ?param_key=42&other_key=asdf
     */
    protected function generateQueryParams(array $queryParamsMap): string
    {
        $queryStringParams = '';
        foreach ($queryParamsMap as $paramMap) {
            if ($paramMap['value'] !== null) {
                if (is_bool($paramMap['value'])) {
                    $paramMap['value'] = (int) $paramMap['value'];
                }
                $format = is_int($paramMap['value']) ? '%d' : '%s';
                $queryStringParams .= sprintf('&%s='.$format, $paramMap['key'], $paramMap['value']);
            }
        }

        return $queryStringParams ? '?'.substr($queryStringParams, 1) : '';
    }
}

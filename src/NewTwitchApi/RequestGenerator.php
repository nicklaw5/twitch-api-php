<?php

namespace NewTwitchApi;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class RequestGenerator
{
    public function generate(string $httpMethod, string $uriEndpoint, string $bearer, array $queryParamsMap = [], array $bodyParams = []): RequestInterface
    {
        if (count($bodyParams) > 0) {
            $request = new Request(
                $httpMethod,
                sprintf(
                    '%s%s',
                    $uriEndpoint,
                    $this->generateQueryParams($queryParamsMap)
                ),
                ['Authorization' => sprintf('Bearer %s', $bearer), 'Accept' => 'application/json'],
                $this->generateBodyParams($bodyParams)
            );
        } else {
            $request = new Request(
                $httpMethod,
                sprintf(
                    '%s%s',
                    $uriEndpoint,
                    $this->generateQueryParams($queryParamsMap)
                ),
                ['Authorization' => sprintf('Bearer %s', $bearer)]
            );
        }

        return $request;
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

    protected function generateBodyParams(array $bodyParamsMap): string
    {
        $bodyParams = [];
        foreach ($bodyParamsMap as $bodyParam) {
            if ($bodyParam['value'] !== null) {
                $bodyParams[$bodyParam['key']] = $bodyParam['value'];
            }
        }

        return json_encode($bodyParams);
    }
}

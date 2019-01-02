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
    protected function callApi(string $uriEndpoint, array $queryParamsMap = [], string $bearer = null): ResponseInterface
    {
        $request = new Request(
            'GET',
            sprintf('%s%s', $uriEndpoint, $this->generateQueryParams($queryParamsMap)),
            $bearer ? ['Authorization' => sprintf('Bearer %s', $bearer)] : []
        );

        return $this->guzzleClient->send($request);
    }

    /**
     * $queryParamsMap should be a mapping of the param key expected in the API call URL,
     * and the value to be sent for that key.
     *
     * For example, the following array:
     *
     * [
     *   'int_key'    => 42,
     *   'bool_key'   => true,
     *   'string_key' => 'twitch',
     *   'array_key'  => ['is', 'number', 1],
     * ]
     *
     * would result in the following query params:
     *
     *  ?int_key=42&bool_key=true&string_key=twitch&array_key=is&array_key=number&array_key=1
     */
    protected function generateQueryParams(array $queryParamsMap): string
    {
        $queryStringParams = '';

        foreach ($queryParamsMap as $key => $value) {
            $queryStringParams .= $this->generateQueryStringFragment($key, $value);
        }

        return $queryStringParams ? '?' . substr($queryStringParams, 1) : '';
    }

    /**
     * @param mixed $value
     */
    private function generateQueryStringFragment(string $key, $value): string
    {
        switch (gettype($value)) {
            case 'string':
                return $this->generateStringFragment($key, $value);
            case 'integer':
                return $this->generateIntegerFragment($key, $value);
            case 'boolean':
                return $this->generateBooleanFragment($key, $value);
            case 'array':
                return $this->generateArrayFragement($key, $value);
            default:
                return '';
        }
    }

    private function generateStringFragment(string $key, string $value): string
    {
        if ($value !== '') {
            return sprintf('&%s=%s', $key, $value);
        }

        return '';
    }

    private function generateIntegerFragment(string $key, int $value): string
    {
        return sprintf('&%s=%d', $key, $value);
    }

    private function generateBooleanFragment(string $key, bool $value): string
    {
        $boolString = $value ? 'true' : 'false';
        return sprintf('&%s=%s', $key, $boolString);
    }

    private function generateArrayFragement(string $key, array $value): string
    {
        $arrayString = '';
        foreach ($value as $v) {
            $vType = gettype($v);
            if (!in_array($vType, ['string', 'integer'])) {
                continue;
            }

            $format = $vType === 'integer' ? '%d' : '%s';
            $arrayString .= sprintf('&%s=' . $format, $key, $v);
        }

        return $arrayString;
    }
}

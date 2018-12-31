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
            switch (gettype($value)) {
                case 'string':
                    $this->appendStringToQuery($queryStringParams, $key, $value);
                    break;
                case 'integer':
                    $this->appendIntegerToQuery($queryStringParams, $key, $value);
                    break;
                case 'boolean':
                    $this->appendBooleanToQuery($queryStringParams, $key, $value);
                    break;
                case 'array':
                    $this->appendArrayToQuery($queryStringParams, $key, $value);
                    break;
                default:
                    break;
            }
        }

        return $queryStringParams ? '?' . substr($queryStringParams, 1) : '';
    }

    private function appendStringToQuery(string &$queryStringParams, string $key, string $value): void
    {
        if ($value !== '') {
            $queryStringParams .= sprintf('&%s=%s', $key, $value);
        }
    }

    private function appendIntegerToQuery(string &$queryStringParams, string $key, int $value): void
    {
        $queryStringParams .= sprintf('&%s=%d', $key, $value);
    }

    private function appendBooleanToQuery(string &$queryStringParams, string $key, bool $value): void
    {
        $boolString = $value ? 'true' : 'false';
        $queryStringParams .= sprintf('&%s=%s', $key, $boolString);
    }

    private function appendArrayToQuery(string &$queryStringParams, string $key, array $value): void
    {
        foreach ($value as $v) {
            $vType = gettype($v);
            if (!in_array($vType, ['string', 'integer'])) {
                continue;
            }

            $format = $vType === 'integer' ? '%d' : '%s';
            $queryStringParams .= sprintf('&%s=' . $format, $key, $v);
        }
    }
}

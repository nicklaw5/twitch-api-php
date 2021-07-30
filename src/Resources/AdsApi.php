<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class AdsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#start-commercial
     */
    public function startCommercial(string $bearer, string $broadcasterId, int $length): ResponseInterface
    {
        $bodyParamsMap = [];

        $bodyParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $bodyParamsMap[] = ['key' => 'length', 'value' => $length];

        return $this->postApi('channels/commercial', $bearer, [], $bodyParamsMap);
    }
}

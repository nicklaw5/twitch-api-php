<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class WhispersApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#send-whisper
     */
    public function sendWhisper(string $bearer, string $fromUserId, string $toUserId, string $message): ResponseInterface
    {
        $queryParamsMap = $bodyParamsMap = [];

        $queryParamsMap[] = ['key' => 'from_user_id', 'value' => $fromUserId];
        $queryParamsMap[] = ['key' => 'to_user_id', 'value' => $toUserId];

        $bodyParamsMap[] = ['key' => 'message', 'value' => $message];

        return $this->postApi('whispers', $bearer, $queryParamsMap, $bodyParamsMap);
    }
}

<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class WebhooksApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-webhook-subscriptions
     */
    public function getWebhookSubscriptions(string $accessToken, int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [
            'first' => $first,
            'after' => $after,
        ];

        return $this->callApi('webhooks/subscriptions', $queryParamsMap, $accessToken);
    }
}

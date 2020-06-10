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
    public function getWebhookSubscriptions(string $bearer, int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];
        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }
        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->callApi('webhooks/subscriptions', $bearer, $queryParamsMap);
    }
}

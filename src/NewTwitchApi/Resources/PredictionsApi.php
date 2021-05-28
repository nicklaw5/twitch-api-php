<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class PredictionsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-predictions
     */
    public function getPredictions(string $bearer, string $broadcasterId, array $ids = [], string $after = null, int $first = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        return $this->getApi('predictions', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#create-prediction
     */
    public function createPrediction(string $bearer, string $broadcasterId, string $title, array $outcomes, int $predictionWindow): ResponseInterface
    {
        $bodyParamsMap = [];

        $bodyParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $bodyParamsMap[] = ['key' => 'title', 'value' => $title];
        $bodyParamsMap[] = ['key' => 'outcomes', 'value' => $outcomes];
        $bodyParamsMap[] = ['key' => 'prediction_window', 'value' => $predictionWindow];

        return $this->postApi('predictions', $bearer, [], $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#end-prediction
     */
    public function endPrediction(string $bearer, string $broadcasterId, string $pollId, string $status, string $winningOutcomeId = null): ResponseInterface
    {
        $bodyParamsMap = [];

        $bodyParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $bodyParamsMap[] = ['key' => 'id', 'value' => $pollId];
        $bodyParamsMap[] = ['key' => 'status', 'value' => $status];

        if ($winningOutcomeId) {
            $bodyParamsMap[] = ['key' => 'winning_outcome_id', 'value' => $winningOutcomeId];
        }

        return $this->patchApi('predictions', $bearer, [], $bodyParamsMap);
    }
}

<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class YahooFinanceApiClient implements FinanceApiClientInterface
{

    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    private const URL = 'https://yh-finance.p.rapidapi.com/auto-complete';
    private const X_RAPID_HOST = 'yh-finance.p.rapidapi.com';
    private const x_PRIVATE_KEY = 'ae8762f3bfmsh4f0a9b062ff7a6fp16bde5jsnf9ba705d2db2';

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fetchStockProfile($symbol, $region): JsonResponse
    {

        $response = $this->httpClient->request('GET', self::URL, [
            'query'   => [
                'q'      => $symbol,
                'region' => $region,
            ],
            'headers' => [
                'X-RapidAPI-Key'  => self::x_PRIVATE_KEY,
                'X-RapidAPI-Host' => self::X_RAPID_HOST,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            return new JsonResponse('Finance API Client Error', 400);
        }

        $stockProfile = json_decode($response->getContent())->quotes[0];

        $stockProfileAsArray = [
            'symbol'       => $stockProfile->symbol,
            'shortName'    => $stockProfile->shortname,
            'quoteType'    => $stockProfile->quoteType,
            'exchangeName' => $stockProfile->exchange,
        ];

       return new JsonResponse($stockProfileAsArray, 200);

    }

}
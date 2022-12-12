<?php

namespace App\Tests\integration;


use App\Tests\DatabaseDependentTestCase;

class YahooFinanceApiClientTest extends DatabaseDependentTestCase
{


    /**
     * @test
     * @group integration
     */
    public function testYahooFinanceClientReturnCorrectData()
    {

        // TEST INTEGRATION OF YAHOO FINANCE API

        // Yahoo finance api client
        $yahooFinanceApiClient = self::$kernel->getContainer()->get('yahoo-finance-api-client');

        // Do something
        $response = $yahooFinanceApiClient->fetchStockProfile('AMZN', 'US');

        $stockProfile = json_decode($response->getContent());

        // Make assertions
        $this->assertSame('AMZN', $stockProfile->symbol);
        $this->assertSame('Amazon.com, Inc.', $stockProfile->shortName);
        $this->assertSame('NMS', $stockProfile->exchangeName);
        $this->assertSame('EQUITY', $stockProfile->quoteType);

    }


}
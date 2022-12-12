<?php

namespace App\Tests;

use App\Entity\Stock;

class TestStock extends DatabaseDependentTestCase
{

    /** @test */
    public function testCanBeCreatedInDatabase()
    {

        /** @var Stock $stock */
        $stock = new Stock();
        $stock->setSymbol('AMZN');
        $stock->setShortName('Amazon.com, Inc.');
        $stock->setQuoteType('EQUITY');
        $stock->setExchangeName('NMS');


        // Do something
        $this->entityManager->persist($stock);
        $this->entityManager->flush();


        $stockRepository = $this->entityManager->getRepository(Stock::class);

        /** @var Stock $stockRecord */
        $stockRecord = $stockRepository->findOneBy(['symbol' => 'AMZN']);

        // Make assertions
        $this->assertEquals('AMZN', $stockRecord->getSymbol());
        $this->assertEquals('Amazon.com, Inc.', $stockRecord->getShortName());
        $this->assertEquals('NMS', $stockRecord->getExchangeName());
        $this->assertEquals('EQUITY', $stockRecord->getQuoteType());

    }

}
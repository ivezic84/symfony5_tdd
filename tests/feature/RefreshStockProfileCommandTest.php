<?php

namespace App\Tests\feature;

use App\Entity\Stock;
use App\Tests\DatabaseDependentTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class RefreshStockProfileCommandTest extends DatabaseDependentTestCase
{

    /** @test */
    public function refreshStockProfileTest()
    {

        // SETUP //
        $application = new Application(self::$kernel);

        // Command
        $command = $application->find('app:refresh-stock-profile');

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'symbol' => 'AMZN',
            'region' => 'US',
        ]);


        $repository = $this->entityManager->getRepository(Stock::class);

        /** @var Stock $stock */
        $stock = $repository->findOneBy(['symbol' => 'AMZN']);


        // Make assertions
        $this->assertSame('AMZN', $stock->getSymbol());
        $this->assertSame('Amazon.com, Inc.', $stock->getShortName());
        $this->assertSame('NMS', $stock->getExchangeName());
        $this->assertSame('EQUITY', $stock->getQuoteType());

    }


}
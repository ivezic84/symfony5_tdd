<?php

namespace App\Command;

use App\Entity\Stock;
use App\Http\FinanceApiClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RefreshStockProfileCommand extends Command
{

    protected static $defaultName = 'app:refresh-stock-profile';
    protected static $defaultDescription = 'Refresh stock profile command';

    /**
     * @var EntityManagerInterface
     */
    private $entityManagerInterface;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var FinanceApiClientInterface
     */
    private $financeApiClient;
    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(
        EntityManagerInterface    $entityManagerInterface,
        FinanceApiClientInterface $financeApiClient,
        SerializerInterface       $serializer,
        LoggerInterface           $logger
    )
    {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->financeApiClient       = $financeApiClient;
        $this->serializer             = $serializer;
        $this->logger                 = $logger;

        parent::__construct();
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('symbol', InputArgument::REQUIRED, 'Stock symbol e.g. AMZN for Amazon')
            ->addArgument('region', InputArgument::REQUIRED, 'Region of the company e.g. US for United States');
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        try {

            $stockProfile = $this->financeApiClient->fetchStockProfile($input->getArgument('symbol'), $input->getArgument('region'));

            if ($stockProfile->getStatusCode() != 200) {
                return Command::FAILURE;
            }

            $stock = $this->serializer->deserialize($stockProfile->getContent(), Stock::class, 'json');

            $this->entityManagerInterface->persist($stock);
            $this->entityManagerInterface->flush();

            $output->writeln($stock->getShortName() . ' has been saved / updated.');

            return Command::SUCCESS;

        } catch (\Exception $exception) {

            $this->logger->warning($exception->getMessage());

            return Command::FAILURE;

        }

    }


}
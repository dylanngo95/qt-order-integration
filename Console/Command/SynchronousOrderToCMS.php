<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Console\Command;

use Magento\Framework\App\State;
use QT\OrderIntegration\Model\OrderIntegrationRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SynchronousOrderToCMS
 * @package QT\OrderIntegration\Console\Command
 */
class SynchronousOrderToCMS extends AbstractCommand
{
    /**
     * @var OrderIntegrationRepository
     */
    private OrderIntegrationRepository $orderIntegrationRepository;

    public function __construct(
        State $state,
        OrderIntegrationRepository $orderIntegrationRepository
    ) {
        parent::__construct($state);
        $this->orderIntegrationRepository = $orderIntegrationRepository;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('qt:synchronous_order');
        $this->setDescription('N/A');
        parent::configure();
    }

    /**
     * CLI command description
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->setAreaIfNotDefined();

        $output->write('test');
        $orderIntegrations = $this->orderIntegrationRepository->getOrderIntegrationNew();
        foreach ($orderIntegrations as $orderIntegration) {

        }
    }
}

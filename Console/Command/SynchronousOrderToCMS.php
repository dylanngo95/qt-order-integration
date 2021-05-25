<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Console\Command;

use Magento\Framework\App\State;
use QT\OrderIntegration\Api\Data\OrderIntegrationInterface;
use QT\OrderIntegration\Helper\Config;
use QT\OrderIntegration\Model\OrderIntegrationRepository;
use QT\OrderIntegration\Request\SynchronousOrderRequest;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SynchronousOrderToCMS
 * @package QT\OrderIntegration\Console\Command
 */
class SynchronousOrderToCMS extends AbstractCommand
{

    const RESPONSE_SUCCESS = 200;

    /**
     * @var OrderIntegrationRepository
     */
    private OrderIntegrationRepository $orderIntegrationRepository;

    /**
     * @var SynchronousOrderRequest
     */
    private SynchronousOrderRequest $synchronousOrderRequest;

    /**
     * @var Config
     */
    private Config $config;

    public function __construct(
        State $state,
        OrderIntegrationRepository $orderIntegrationRepository,
        SynchronousOrderRequest $synchronousOrderRequest,
        Config $config
    )
    {
        parent::__construct($state);
        $this->orderIntegrationRepository = $orderIntegrationRepository;
        $this->synchronousOrderRequest = $synchronousOrderRequest;
        $this->config = $config;
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
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->setAreaIfNotDefined();

        $orderIntegrationNews = $this->orderIntegrationRepository->getOrderIntegrationNew();
        if ($orderIntegrationNews) {
            foreach ($orderIntegrationNews as $orderIntegration) {
                $orderIntegrationItem = $this->orderIntegrationRepository->getById($orderIntegration->getEntityId());
                $this->syncOrderToCMS($orderIntegrationItem);
            }
        } else {
            $orderIntegrationFails = $this->orderIntegrationRepository->getOrderIntegrationFail();
            foreach ($orderIntegrationFails as $orderIntegration) {
                $orderIntegrationItem = $this->orderIntegrationRepository->getById($orderIntegration->getEntityId());
                if ($orderIntegrationItem->getMaxTry() >= $this->config->getMaxTry()) {
                    break;
                }
                $this->syncOrderToCMS($orderIntegrationItem);
            }
        }
        $output->writeln("Start synchronous order to cms");
    }

    /**
     * Sync Order To CMS.
     *
     * @param OrderIntegrationInterface $orderIntegrationItem
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    private function syncOrderToCMS(OrderIntegrationInterface $orderIntegrationItem)
    {
        $this->orderIntegrationRepository->updateStatusById(
            $orderIntegrationItem->getEntityId(),
            OrderIntegrationInterface::STATUS_PROCESSING
        );
        $response = $this->synchronousOrderRequest->synchronousOrderById($orderIntegrationItem->getEntityId());
        if ($response->getStatusCode() !== self::RESPONSE_SUCCESS) {
            $this->orderIntegrationRepository->updateStatusById(
                $orderIntegrationItem->getEntityId(),
                OrderIntegrationInterface::STATUS_FAIL,
                $response->getReasonPhrase()
            );
        } else {
            $this->orderIntegrationRepository->updateStatusById(
                $orderIntegrationItem->getEntityId(),
                OrderIntegrationInterface::STATUS_COMPLETE
            );
        }
    }
}

<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Observer;


use Magento\Framework\Event\Observer;
use QT\OrderIntegration\Api\Data\OrderIntegrationInterface;
use QT\OrderIntegration\Api\Data\OrderIntegrationInterfaceFactory;
use QT\OrderIntegration\Model\OrderIntegrationRepository;

/**
 * Class OrderIntegrationObserver
 * @package QT\OrderIntegration\Observer
 */
class OrderIntegrationObserver implements \Magento\Framework\Event\ObserverInterface
{
    private OrderIntegrationRepository $orderIntegrationRepository;

    private OrderIntegrationInterfaceFactory $orderIntegrationFactory;

    public function __construct(
        OrderIntegrationRepository $orderIntegrationRepository,
        OrderIntegrationInterfaceFactory $orderIntegrationFactory
    )
    {
        $this->orderIntegrationRepository = $orderIntegrationRepository;
        $this->orderIntegrationFactory = $orderIntegrationFactory;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function execute(Observer $observer)
    {
        /* @var $order \Magento\Sales\Model\Order */
        $order = $observer->getEvent()->getOrder();

        /** @var OrderIntegrationInterface $orderIntegration */
        $orderIntegration = $this->orderIntegrationFactory->create();

        $orderIntegration->setStoreId((int) $order->getStoreId());
        $orderIntegration->setOrderId((int) $order->getEntityId());
        $orderIntegration->setStatus(OrderIntegrationInterface::STATUS_NEW);

        $this->orderIntegrationRepository->save($orderIntegration);
    }
}

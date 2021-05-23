<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Model;


use Magento\Framework\Exception\CouldNotSaveException;
use QT\OrderIntegration\Api\Data\OrderIntegrationInterface;
use QT\OrderIntegration\Api\OrderIntegrationRepositoryInterface;
use QT\OrderIntegration\Model\ResourceModel\OrderIntegration as ObjectResourceModel;
use QT\OrderIntegration\Model\OrderIntegrationFactory as ObjectModelFactory;

/**
 * Class OrderIntegrationRepository
 * @package QT\OrderIntegration\Model
 */
class OrderIntegrationRepository implements OrderIntegrationRepositoryInterface
{
    /**
     * @var ObjectResourceModel
     */
    private ObjectResourceModel $objectResourceModel;

    /**
     * @var OrderIntegrationFactory
     */
    private OrderIntegrationFactory $objectModelFactory;

    /**
     * OrderIntegrationRepository constructor.
     * @param ObjectResourceModel $objectResourceModel
     * @param OrderIntegrationFactory $objectModelFactory
     */
    public function __construct(
        ObjectResourceModel $objectResourceModel,
        ObjectModelFactory $objectModelFactory
    )
    {
        $this->objectResourceModel = $objectResourceModel;
        $this->objectModelFactory = $objectModelFactory;
    }

    /**
     * @param OrderIntegrationInterface $orderIntegration
     * @return OrderIntegrationInterface
     * @throws CouldNotSaveException
     */
    public function save(OrderIntegrationInterface $orderIntegration): OrderIntegrationInterface
    {
        try {
            $this->objectResourceModel->save($orderIntegration);
            return $orderIntegration;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }

    public function getOrderIntegrationNew(): array
    {
        // TODO: Implement getOrderIntegrationNew() method.
    }
}

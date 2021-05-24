<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Model;


use Magento\Framework\Exception\CouldNotSaveException;
use QT\OrderIntegration\Api\Data\OrderIntegrationInterface;
use QT\OrderIntegration\Api\OrderIntegrationRepositoryInterface;
use QT\OrderIntegration\Helper\Config;
use QT\OrderIntegration\Model\ResourceModel\OrderIntegration as ObjectResourceModel;
use QT\OrderIntegration\Model\OrderIntegrationFactory as ObjectModelFactory;
use QT\OrderIntegration\Model\ResourceModel\OrderIntegration\Collection as OrderIntegrationCollection;

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
     * @var OrderIntegrationCollection
     */
    private OrderIntegrationCollection $orderIntegrationCollection;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * OrderIntegrationRepository constructor.
     * @param ObjectResourceModel $objectResourceModel
     * @param OrderIntegrationFactory $objectModelFactory
     * @param OrderIntegrationCollection $orderIntegrationCollection
     * @param Config $config
     */
    public function __construct(
        ObjectResourceModel $objectResourceModel,
        ObjectModelFactory $objectModelFactory,
        OrderIntegrationCollection $orderIntegrationCollection,
        Config $config
    )
    {
        $this->objectResourceModel = $objectResourceModel;
        $this->objectModelFactory = $objectModelFactory;
        $this->orderIntegrationCollection = $orderIntegrationCollection;
        $this->config = $config;
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

    /**
     * Get By Id.
     *
     * @param int $id
     * @return OrderIntegrationInterface|null
     */
    public function getById(int $id): ?OrderIntegrationInterface
    {
        $customSalesOrder = $this->objectModelFactory->create();
        $this->objectResourceModel->load($customSalesOrder, $id);
        if (!$customSalesOrder->getEntityId()) {
            return null;
        }
        return $customSalesOrder;
    }

    /**
     * Get By Id.
     *
     * @param int $id
     * @param int $status
     * @param string|null $comment
     * @return OrderIntegrationInterface|null
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function updateStatusById(int $id, int $status, ?string $comment = null): ?OrderIntegrationInterface
    {
        /** @var OrderIntegrationInterface $customSalesOrder */
        $customSalesOrder = $this->objectModelFactory->create();
        $this->objectResourceModel->load($customSalesOrder, $id);
        if (!$customSalesOrder->getEntityId()) {
            return null;
        }
        $customSalesOrder->setStatus($status);
        $customSalesOrder->setComment($comment);
        $this->objectResourceModel->save($customSalesOrder);
        return $customSalesOrder;
    }

    /**
     * Get Order Integration New.
     *
     * @return array
     */
    public function getOrderIntegrationNew(): ?array
    {
        $batchSize = $this->config->getBatchSize() ?? 500;
        $result = $this->orderIntegrationCollection
            ->addFieldToSelect(['entity_id'])
            ->addFieldToFilter('status', ['eq' => OrderIntegrationInterface::STATUS_NEW])
            ->setPageSize($batchSize);
        return $result->getItems() ?? null;
    }
}

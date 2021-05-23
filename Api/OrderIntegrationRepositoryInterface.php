<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Api;


/**
 * Interface OrderIntegrationRepositoryInterface
 * @package QT\OrderIntegration\Api
 */
interface OrderIntegrationRepositoryInterface
{
    /**
     * @param \QT\OrderIntegration\Api\Data\OrderIntegrationInterface $orderIntegration
     * @return \QT\OrderIntegration\Api\Data\OrderIntegrationInterface
     */
    public function save(\QT\OrderIntegration\Api\Data\OrderIntegrationInterface $orderIntegration): \QT\OrderIntegration\Api\Data\OrderIntegrationInterface;

    /**
     * @return  \QT\OrderIntegration\Api\Data\OrderIntegrationInterface[]
     */
    public function getOrderIntegrationNew(): array;
}

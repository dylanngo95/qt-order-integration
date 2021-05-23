<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Api\Data;

/**
 * Interface OrderIntegrationInterface
 * @package QT\OrderIntegration\Api\Data
 */
interface OrderIntegrationInterface
{
    /**
     * String constants for property names
     */
    const ENTITY_ID = "entity_id";
    const STORE_ID = "store_id";
    const ORDER_ID = "order_id";
    const STATUS = "status";
    const COMMENT = "comment";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    const STATUS_NEW = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_FAIL = 2;
    const STATUS_COMPLETE = 3;

    /**
     * Getter for EntityId.
     *
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * Setter for EntityId.
     *
     * @param int|null $entityId
     *
     * @return void
     */
    public function setEntityId(?int $entityId): void;

    /**
     * Getter for StoreId.
     *
     * @return int|null
     */
    public function getStoreId(): ?int;

    /**
     * Setter for StoreId.
     *
     * @param int|null $storeId
     *
     * @return void
     */
    public function setStoreId(?int $storeId): void;

    /**
     * Getter for OrderId.
     *
     * @return int|null
     */
    public function getOrderId(): ?int;

    /**
     * Setter for OrderId.
     *
     * @param int|null $orderId
     *
     * @return void
     */
    public function setOrderId(?int $orderId): void;

    /**
     * Getter for Status.
     *
     * @return int|null
     */
    public function getStatus(): ?int;

    /**
     * Setter for Status.
     *
     * @param int|null $status
     *
     * @return void
     */
    public function setStatus(?int $status): void;

    /**
     * Getter for Comment.
     *
     * @return string|null
     */
    public function getComment(): ?string;

    /**
     * Setter for Comment.
     *
     * @param string|null $comment
     *
     * @return void
     */
    public function setComment(?string $comment): void;

    /**
     * Getter for CreatedAt.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Setter for CreatedAt.
     *
     * @param string|null $createdAt
     *
     * @return void
     */
    public function setCreatedAt(?string $createdAt): void;

    /**
     * Getter for UpdatedAt.
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Setter for UpdatedAt.
     *
     * @param string|null $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt(?string $updatedAt): void;
}

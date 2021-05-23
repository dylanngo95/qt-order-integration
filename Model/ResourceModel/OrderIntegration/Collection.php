<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Model\ResourceModel\OrderIntegration;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use QT\OrderIntegration\Model\OrderIntegration as Model;
use QT\OrderIntegration\Model\ResourceModel\OrderIntegration as ResourceModel;

/**
 * Class Collection
 * @package QT\OrderIntegration\Model\ResourceModel\OrderIntegration
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'order_integration_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}

<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class OrderIntegration
 * @package QT\OrderIntegration\Model\ResourceModel
 */
class  OrderIntegration extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'order_integration_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('order_integration', 'entity_id');
        $this->_useIsObjectNew = true;
    }
}

<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;


/**
 * Class Config
 * @package QT\OrderIntegration\Helper
 */
class Config extends AbstractHelper
{
    const ORDER_INTEGRATION_ENABLE = 'order_integration/general/enabled';
    const ORDER_INTEGRATION_BATCH_SIZE = 'order_integration/general/batch_size';
    const ORDER_INTEGRATION_LOG_PAYLOAD = 'order_integration/general/log_payload';
    const ORDER_INTEGRATION_ENDPOINT_URL = 'order_integration/api_credentials/api_endpoint_url';
    const ORDER_INTEGRATION_TOKEN = 'order_integration/api_credentials/token';

    /**
     * @var array
     */
    private $cache = [];

    /**
     * Get Config Value.
     *
     * @param $path
     * @param $storeId
     * @return mixed
     */
    public function getConfigValue($path, $storeId = null)
    {
        $cacheKey = "$path-$storeId";
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }
        $value = $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORES,
            $storeId
        );
        $this->cache[$cacheKey] = $value;
        return $value;
    }

    /**
     * Is Enable.
     *
     * @param null $storeId
     * @return mixed
     */
    public function isEnable($storeId = null)
    {
        return $this->getConfigValue(
            self::ORDER_INTEGRATION_ENABLE,
            $storeId
        );
    }

    /**
     * Is Log Payload.
     *
     * @param $storeId
     * @return mixed
     */
    public function isLogPayload($storeId = null)
    {
        return $this->getConfigValue(
            self::ORDER_INTEGRATION_LOG_PAYLOAD,
            $storeId
        );
    }

    /**
     * Get Batch Size.
     *
     * @param null $storeId
     * @return mixed
     */
    public function getBatchSize($storeId = null)
    {
        return $this->getConfigValue(
            self::ORDER_INTEGRATION_BATCH_SIZE,
            $storeId
        );
    }

    /**
     * Get Endpoint Url.
     *
     * @param null $storeId
     * @return mixed
     */
    public function getEndpointUrl($storeId = null)
    {
        return $this->getConfigValue(
            self::ORDER_INTEGRATION_ENDPOINT_URL,
            $storeId
        );
    }

    /**
     * Get Token.
     *
     * @param null $storeId
     * @return mixed
     */
    public function getToken($storeId = null)
    {
        return $this->getConfigValue(
            self::ORDER_INTEGRATION_TOKEN,
            $storeId
        );
    }
}

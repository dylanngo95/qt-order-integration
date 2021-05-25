<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Logger;


use Psr\Log\LoggerInterface;
use QT\OrderIntegration\Helper\Config;

/**
 * Class Logger
 * @package QT\OrderIntegration\Logger
 */
class Logger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Config
     */
    private $config;

    /**
     * Logger constructor.
     * @param LoggerInterface $logger
     * @param Config $config
     */
    public function __construct(
        LoggerInterface $logger,
        Config $config
    ) {
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * Log Info.
     *
     * @param $message
     * @param array $context
     */
    public function logInfo($message, array $context = [])
    {
        if ($this->config->isLogPayload()) {
            $this->logger->info($message, $context);
        }
    }

    /**
     * Log Critical.
     *
     * @param $message
     * @param array $context
     */
    public function logCritical($message, array $context = [])
    {
        $this->logger->critical($message, $context);
    }

    /**
     * Log Debug.
     *
     * @param $message
     * @param array $context
     */
    public function logDebug($message, array $context = [])
    {
        $this->logger->debug($message, $context);
    }
}

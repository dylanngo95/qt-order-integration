<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Request;


use QT\OrderIntegration\Helper\Config;
use Magento\Framework\Webapi\Rest\Request;

/**
 * Class SynchronousOrderRequest
 * @package QT\OrderIntegration\Request
 */
class SynchronousOrderRequest
{
    const REQUEST_URI = 'orders/notify';

    private ClientRequest $clientRequest;

    private Config $config;

    /**
     * Synchronous Order Request constructor.
     *
     * @param ClientRequest $clientRequest
     * @param Config $config
     */
    public function __construct(
        ClientRequest $clientRequest,
        Config $config
    )
    {
        $this->clientRequest = $clientRequest;
        $this->config = $config;
    }

    /**
     * Synchronous Order By Id.
     *
     * @param $orderId
     * @return \GuzzleHttp\Psr7\Response|\Psr\Http\Message\ResponseInterface
     */
    public function synchronousOrderById($orderId)
    {
        $baseUri = $this->config->getEndpointUrl();

        $headers = [
            "token" => $this->config->getToken()
        ];
        $params = [
            'headers' => $headers
        ];

       return $this->clientRequest->doRequest(
            $baseUri,
            self::REQUEST_URI . "/" . $orderId,
            $params,
            Request::HTTP_METHOD_POST
        );
    }
}

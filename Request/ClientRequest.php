<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Request;

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use QT\OrderIntegration\Logger\Logger;

/**
 * Class ClientRequest
 * @package QT\OrderIntegration\Request
 */
class ClientRequest
{
    private ClientFactory $clientFactory;

    private ResponseFactory $responseFactory;

    private Logger $logger;

    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        Logger $logger
    )
    {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->logger = $logger;
    }

    /**
     * Do Request.
     *
     * @param string $baseUri
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     * @return Response|\Psr\Http\Message\ResponseInterface
     */
    public function doRequest(
        string $baseUri,
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    )
    {
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => $baseUri
        ]]);

        $this->logger->logInfo(
            'logging request:',
            [
                'requestMethod' => $requestMethod,
                'baseUri' => $baseUri,
                'uriEndpoint' => $uriEndpoint,
                'params' => $params
            ]
        );

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }
}

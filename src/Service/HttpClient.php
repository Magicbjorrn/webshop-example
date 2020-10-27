<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpClient
{
    protected $container;
    protected $logger;
    protected $httpClient;

    public function __construct(ContainerInterface $container, LoggerInterface $logger, HttpClientInterface $httpClient)
    {
        $this->container = $container;
        $this->logger = $logger;
        $this->httpClient = $httpClient;
    }

    public function executeHttpPostRequest($url = '', $data = [], $postdataName = 'form_params')
    {
        try {
            $response = $this->httpClient->request('POST', $url, [$postdataName => $data]);

            $result = $this->getHttpResponse($response);
            if (is_array($result) && key_exists('error', $result)) {
                $this->logger->error('Error returned from backend system: ' . $result['error']);
            }

            return $result;
        } catch(\Exception $e) {
            $this->logger->error('Error while executing POST request: ' . $e->getMessage());
            return "Error: " . $e;
        }
    }

    public function executeHttpGetRequest($url = '', $data = [])
    {
        try {
            $paramstring = "?";

            foreach ($data as $key => $value) {
                if ($key) {
                    $paramstring .= $key . '=' . $value . '&';
                }
            }

            $response = $this->httpClient->request('GET', $url . $paramstring);

            $result = $this->getHttpResponse($response);
            if (is_array($result) && key_exists('error', $result)) {
                $this->logger->error('Error returned from backend system: ' . $result['error']);
            }

            return $result;
        } catch(\Exception $e) {
            $this->logger->error('Error while executing GET request: ' . $e->getMessage());
            return "Error: " . $e;
        }
    }

    public function getHttpResponse($response)
    {
        $body = $response->getContent();

        return $this->isJson($body) ?  json_decode($body) : $body;
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

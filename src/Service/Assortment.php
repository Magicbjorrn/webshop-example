<?php

namespace App\Service;

class Assortment
{
    const NO_ASSORTMENT_FOUND = "no assortment found";

    protected $httpClient;
    protected $container;

    /**
     * Assortment constructor.
     * @param $container
     * @param HttpClient $client
     */
    public function __construct($container, HttpClient $client)
    {
        $this->httpClient = $client;
        $this->container = $container;
    }

    public function getAssortmentData()
    {
        try {
            if ($this->container->get('session')->get('_order')) {
                return $this->container->get('session')->get('_order')->assortment;
            }

            $orderData = $this->httpClient->executeHttpGetRequest(
                $this->container->getParameter('assortment_api_getassortment_url')
            );

            if ($orderData->assortment) {
                $this->container->get('session')->set('_order', $orderData);

                return $orderData->assortment;
            }

            $this->container->get('logger')->error('no order');

            throw new \Exception(self::NO_ASSORTMENT_FOUND);
        } catch (\Exception $e) {
            if ($e->getMessage() == self::NO_ASSORTMENT_FOUND) {
                throw new \Exception(self::NO_ASSORTMENT_FOUND);
            }

            throw new \Exception('server not reachable');
        }
    }
}

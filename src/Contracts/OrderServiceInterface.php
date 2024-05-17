<?php

namespace Biztory\Storefront\Contracts;

use Biztory\Storefront\DTO\Services\SaleOrderData;
use Biztory\Storefront\DTO\StoreOrderData;

interface OrderServiceInterface
{
    // private SaleOrderData $payload;
    /**
     * create the payload for the order
     */
    public function createPayload(StoreOrderData $data): SaleOrderData;

    /**
     * send the payload to the respective service
     */
    public function callApi(StoreOrderData $data): void;

    /**
     * get api base url
     */
    public function getApiBaseUrl(): string;
}


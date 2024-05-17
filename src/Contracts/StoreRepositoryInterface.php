<?php

namespace Biztory\Storefront\Contracts;

use Biztory\Storefront\DTO\StoreOrderData;
use Biztory\Storefront\DTO\StoreSettingsData;

interface StoreRepositoryInterface
{
    /**
     * get the settings for the store
     */
    public function getSettings(): StoreSettingsData;

    /**
     * set the settings for the store
     */
    public function setSettings(StoreSettingsData $payload): void;

    /**
     * place an order
     */
    public function placeOrder(StoreOrderData $payload): StoreOrderData;
}

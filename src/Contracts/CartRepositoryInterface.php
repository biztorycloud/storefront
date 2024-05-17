<?php

namespace Biztory\Storefront\Contracts;

use Biztory\Storefront\DTO\CartData;

interface CartRepositoryInterface
{
    /**
     * get the cart for the current user
     */
    public function get(): CartData;

    /**
     * set the cart for the current user
     */
    public function set(CartData $cart): void;
}

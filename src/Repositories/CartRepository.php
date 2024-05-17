<?php

namespace Biztory\Storefront\Repositories;

use App\Util\Facade\Settings;
use Biztory\Storefront\Contracts\CartRepositoryInterface;
use Biztory\Storefront\DTO\CartData;

class CartRepository implements CartRepositoryInterface
{
    public function get(): CartData
    {
        return CartData::from(Settings::get($this->getCartKey(), []));
    }

    public function set(CartData $cart): void
    {
        Settings::set($this->getCartKey(), $cart->toArray());
    }

    public function clearCart(): void
    {
        Settings::set($this->getCartKey(), []);
    }

    private function getCartExpiry()
    {
        // get from settings, otherwise use default value from config
        return Settings::get('storefront:cart_expiry') ?: config('storefront.cart_expiry');
    }

    private function getCartKey()
    {
        /** @var User $user */
        $user = auth()->user();

        return 'cart.'.(auth_customer_id() ?? $user->currentAccessToken()->id);
    }
}

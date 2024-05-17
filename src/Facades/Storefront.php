<?php

namespace Biztory\Storefront\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Biztory\Storefront\Storefront
 */
class Storefront extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Biztory\Storefront\Storefront::class;
    }
}

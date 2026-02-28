<?php

use Biztory\Storefront\Http\Controllers\CouponController;
use Spatie\LaravelData\DataCollection;

it('can get coupon', function () {
    $ctrl = new CouponController;
    $response = $ctrl->index(request());
    expect($response)
        ->toBeInstanceOf(DataCollection::class)
        ->toHaveCount(2);
});

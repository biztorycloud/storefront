<?php

use Spatie\LaravelData\DataCollection;
use Biztory\Storefront\Http\Controllers\CouponController;

it('can get coupon', function () {
    $ctrl = new CouponController();
    $response = $ctrl->index(request());
    expect($response)
        ->toBeInstanceOf(DataCollection::class)
        ->toHaveCount(2)
    ;
});

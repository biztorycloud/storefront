<?php

namespace Biztory\Storefront\Http\Controllers;

use Biztory\Storefront\DTO\CouponData;
use Biztory\Storefront\Enums\DiscountType;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\LaravelData\DataCollection;

class CouponController extends Controller
{
    public function __construct() {}

    /**
     * @return DataCollection<CouponData>
     */
    public function index(Request $request): DataCollection
    {
        return CouponData::collection([
            new CouponData(
                id: '1',
                name: 'Coupon 1',
                description: 'Coupon 1 description',
                discount_amount: 10,
                discount_type: DiscountType::Percentage,
            ),
            new CouponData(
                id: '2',
                name: 'Coupon 2',
                description: 'Coupon 2 description',
                discount_amount: 5,
                discount_type: DiscountType::Percentage,
            ),
        ]);
    }
}

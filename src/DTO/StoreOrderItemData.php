<?php

namespace Biztory\Storefront\DTO;

use App\Product;
use App\Util\Facade\Settings;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class StoreOrderItemData extends Data
{
    public function __construct(
        #[MapName('item_id'), Exists(Product::class, 'id', null, true)]
        public int $product_id,
        public string $code,
        public ?string $description,
        #[Min(0)]
        public float $quantity,
        #[Min(0)]
        public float $price,
        #[Min(0)]
        public float $total,
        #[Min(0)]
        public ?float $discount,
        #[Min(0), MapName('total_tax')]
        public ?float $tax,
        public ?string $tax_label,
        public ?float $tax_value,
        public int|Optional $id,
        public ?array $classifications,
    ) {}

    public static function rules()
    {
        return [
            'classifications' => [
                Settings::get('enable_eInvoicing') ? 'required' : 'nullable',
            ],
        ];
    }
}

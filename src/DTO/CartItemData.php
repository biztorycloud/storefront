<?php

namespace Biztory\Storefront\DTO;

use App\Product;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;

class CartItemData extends Data
{
    public function __construct(
        #[Exists(Product::class, 'id')]
        public int $id,
        public string $name,
        public float $quantity,
        public float $price,
    ) {
    }

    public static function rules(): array
    {
        return [
            // TODO: max validation against current stock
            'quantity' => ['gt:0', 'lte:1000'],
            'price' => ['gt:0'],
        ];
    }
}

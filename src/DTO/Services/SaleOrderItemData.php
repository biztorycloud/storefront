<?php

namespace Biztory\Storefront\DTO\Services;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SaleOrderItemData extends Data
{
    public function __construct(
        public string $code,
        public float $qty,
        public float $price,
        public int|Optional $item_id,
        public ?string $description,
        public Optional|string|null $unit,
        public ?string $tax_label,
        public ?float $tax_value,
        public ?float $discount,
        public array|Optional $serial_numbers,
        public array|Optional $edited_serials,
        #[Max(9999999)]
        public ?float $total_tax = 0,
        #[Max(9999999)]
        public float $total = 0,
    ) {
    }
}

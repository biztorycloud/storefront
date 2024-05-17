<?php

namespace Biztory\Storefront\DTO;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CartData extends Data
{
    public function __construct(
        #[DataCollectionOf(CartItemData::class)]
        public ?DataCollection $items = null,
    ) {
        $this->items = $items ?: new DataCollection(CartItemData::class, []);
    }
}

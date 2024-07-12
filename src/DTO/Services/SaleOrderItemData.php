<?php

namespace Biztory\Storefront\DTO\Services;

use Faker\Factory;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\Validation\Max;

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
        public ?array $classifications,
        #[Max(9999999)]
        public ?float $total_tax = 0,
        #[Max(9999999)]
        public float $total = 0,
    ) {
    }

    public static function fake(): self
    {
        $faker = Factory::create();

        return new self(
            code: $faker->word(),
            qty: $faker->randomFloat(2, 0, 9999999),
            price: $faker->randomFloat(2, 0, 9999999),
            item_id: $faker->numberBetween(1, 9999999),
            description: $faker->sentence(5),
            unit: $faker->word(),
            tax_label: $faker->word(),
            tax_value: $faker->randomFloat(2, 0, 9999999),
            discount: $faker->randomFloat(2, 0, 9999999),
            serial_numbers: [$faker->word(), $faker->word()],
            edited_serials: [$faker->word(), $faker->word()],
            classifications: ['022'],
            total_tax: $faker->randomFloat(2, 0, 9999999),
            total: $faker->randomFloat(2, 0, 9999999),
        );
    }

    public static function fakeCollection(): DataCollection
    {
        return self::collection(
            array_fill(0, random_int(1, 10), self::fake())
        );
    }
}

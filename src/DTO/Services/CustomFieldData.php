<?php

namespace Biztory\Storefront\DTO\Services;

use Faker\Factory;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class CustomFieldData extends Data
{
    public function __construct(
        public string $key,
        public ?string $value,
        public array|Optional $options,
        public bool|Optional $printable = false,
        public string|Optional $type = 'text',
    ) {}

    public static function fake(): self
    {
        $faker = Factory::create();

        return new self(
            key: $faker->word(),
            value: $faker->word(),
            options: [$faker->word(), $faker->word()],
            printable: $faker->boolean(),
            type: $faker->randomElement(['text', 'number', 'date', 'select', 'checkbox']),
        );
    }

    public static function fakeCollection(): DataCollection
    {
        return self::collection(
            array_fill(0, random_int(1, 3), self::fake())
        );
    }
}

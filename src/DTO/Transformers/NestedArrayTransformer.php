<?php

namespace Biztory\Storefront\DTO\Transformers;

use Illuminate\Support\Arr;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class NestedArrayTransformer implements Transformer
{
    public function __construct(
        protected string $field
    ) {}

    public function transform(DataProperty $property, mixed $value): mixed
    {
        $array = [];
        Arr::set($array, $this->field, $value);

        return $array ?? $value;
    }
}

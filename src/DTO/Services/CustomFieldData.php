<?php

namespace Biztory\Storefront\DTO\Services;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CustomFieldData extends Data
{
    public function __construct(
        public string $key,
        public ?string $value,
        public array|Optional $options,
        public bool|Optional $printable = false,
        public string|Optional $type = 'text',
    ) {
    }
}

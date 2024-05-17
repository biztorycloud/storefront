<?php

namespace Biztory\Storefront\DTO;

use App\Branch;
use App\PaymentTerm;
use App\User;
use Biztory\Storefront\Enums\CurrencyCode;
use Biztory\Storefront\Enums\DocumentType;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class StoreSettingsData extends Data
{
    public function __construct(
        public string|Optional $name,
        #[Email]
        public string|Optional $email,
        public string|Optional $logo,
        // default values
        public CurrencyCode|Optional $default_currency,
        public DocumentType|Optional $default_document_type,
        public string|Optional|null $default_gateway,
        #[Exists(Branch::class, 'id', null, true)]
        public int|Optional $default_branch_id,
        #[Exists(PaymentTerm::class, 'id', null, true)]
        public int|Optional $default_payment_term_id,
        #[Exists(User::class, 'id', null, true)]
        public int|Optional|null $default_staff_id,
        #[Exists(User::class, 'id', null, true)]
        public int|Optional $default_author_id,
        public array|Optional $default_source_custom_field,
        // flags
        public bool|Optional $enable_guest_checkout,
        public bool|Optional $enable_postpaid,
        // notifications
        public NotificationSettingsData|Optional $notifications,
    ) {
    }
}

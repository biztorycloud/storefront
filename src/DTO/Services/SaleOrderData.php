<?php

namespace Biztory\Storefront\DTO\Services;

use App\PaymentTerm;
use Biztory\Storefront\Enums\RoundingMode;
use Faker\Factory;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Optional;

class SaleOrderData extends Data
{
    public function __construct(
        public Optional|int $id,
        public Optional|string $ref_num,
        #[In('/cashsale', 'extra_1', 'extra_2', 'normal')]
        public Optional|string $sal_type,
        #[Date]
        public string $invoice_date,
        #[Date]
        public ?string $gst_supply_date,
        public string $payee,
        public Optional|int $payee_id,
        #[Email]
        public ?string $email,
        public ?string $phone,
        public ?int $staff_id,
        public Optional|int $author_id,
        #[Max(200)]
        public Optional|string $billing_attn,
        #[Max(100)]
        public string $billing_addr_1,
        #[Max(100)]
        public ?string $billing_addr_2,
        #[Max(100)]
        public ?string $billing_addr_3,
        #[Max(10)]
        public string $billing_zip,
        #[Max(100)]
        public string $billing_city,
        #[Max(100)]
        public string $billing_state,
        #[Max(200)]
        public ?string $shipping_attn,
        #[Max(100)]
        public ?string $shipping_addr_1,
        #[Max(100)]
        public ?string $shipping_addr_2,
        #[Max(100)]
        public ?string $shipping_addr_3,
        #[Max(10)]
        public ?string $shipping_zip,
        #[Max(100)]
        public ?string $shipping_city,
        #[Max(100)]
        public ?string $shipping_state,
        #[Max(5000)]
        public Optional|string|null $remark,
        public Optional|float $rounding,
        public Optional|RoundingMode $roundingMode,
        public float $total,
        #[Max(255)]
        public Optional|string $custom_formula,
        public Optional|bool $tax_inclusive,
        public Optional|bool $is_receipt,
        public Optional|bool $is_relief,
        public Optional|bool $export_of_goods,
        public Optional|bool $is_gst,
        public Optional|bool $is_sst,
        public Optional|PaymentTerm $payment_term,
        #[RequiredIf('payment_term', true)]
        public int|Lazy|Optional $payment_term_id,
        #[DataCollectionOf(ScheduledTransactionData::class)]
        public DataCollection|Optional|Lazy $terms,

        #[DataCollectionOf(SaleOrderItemData::class)]
        public Lazy|DataCollection $items,

        public ?CurrencyData $currency,
        public float|Optional|Lazy $currency_total,
        public DiscountServiceChargeData|Optional $discount,
        public DiscountServiceChargeData|Optional $service_charge,
        #[DataCollectionOf(CustomFieldData::class)]
        public DataCollection|Optional $custom_fields,
        /**
         * @var array<string, mixed>
         */
        public array|Optional|Lazy $meta,
        public bool $update_payee = false,
    ) {}

    public static function fake(): self
    {
        $faker = Factory::create();

        return new self(
            id: $faker->randomNumber(),
            ref_num: $faker->word,
            sal_type: $faker->randomElement(['cashsale', 'extra_1', 'extra_2', 'normal']),
            invoice_date: $faker->date(),
            gst_supply_date: $faker->date(),
            payee: $faker->name,
            payee_id: $faker->randomNumber(),
            email: $faker->email,
            phone: $faker->phoneNumber,
            staff_id: $faker->randomNumber(),
            author_id: $faker->randomNumber(),
            billing_attn: $faker->word,
            billing_addr_1: $faker->word,
            billing_addr_2: $faker->word,
            billing_addr_3: $faker->word,
            billing_zip: $faker->word,
            billing_city: $faker->word,
            billing_state: $faker->word,
            shipping_attn: $faker->word,
            shipping_addr_1: $faker->word,
            shipping_addr_2: $faker->word,
            shipping_addr_3: $faker->word,
            shipping_zip: $faker->word,
            shipping_city: $faker->word,
            shipping_state: $faker->word,
            remark: $faker->word,
            rounding: $faker->randomFloat(),
            roundingMode: $faker->randomElement(RoundingMode::cases()),
            total: $faker->randomFloat(),
            custom_formula: $faker->word,
            tax_inclusive: $faker->boolean,
            is_receipt: $faker->boolean,
            is_relief: $faker->boolean,
            export_of_goods: $faker->boolean,
            is_gst: $faker->boolean,
            is_sst: $faker->boolean,
            payment_term: PaymentTerm::find(1),
            payment_term_id: 1,
            terms: ScheduledTransactionData::fakeCollection(),
            items: SaleOrderItemData::fakeCollection(),
            currency: CurrencyData::fake(),
            currency_total: $faker->randomFloat(),
            discount: DiscountServiceChargeData::fake(),
            service_charge: DiscountServiceChargeData::fake(),
            custom_fields: CustomFieldData::fakeCollection(),
            meta: $faker->words,
            update_payee: $faker->boolean,
        );
    }
}

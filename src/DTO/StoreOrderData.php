<?php

namespace Biztory\Storefront\DTO;

use App\Customer;
use App\PaymentTerm;
use App\User;
use Biztory\Storefront\Contracts\StoreRepositoryInterface;
use Biztory\Storefront\DTO\Services\CustomFieldData;
use Biztory\Storefront\DTO\Services\DiscountServiceChargeData;
use Biztory\Storefront\DTO\Services\ScheduledTransactionData;
use Biztory\Storefront\Enums\ApprovalStatus;
use Biztory\Storefront\Enums\CurrencyCode;
use Biztory\Storefront\Enums\Document;
use Biztory\Storefront\Enums\DocumentType;
use Biztory\Storefront\Enums\PaymentTermUnitText;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Optional;

class StoreOrderData extends Data
{
    public PaymentTerm|Optional|Lazy $payment_term;

    public function __construct(
        public Optional|int $id,
        public Document|Optional $type,
        public DocumentType|Optional $doc_type,
        public Optional|string $ref_num,
        #[Date]
        public string $invoice_date,
        public string $payee,
        #[Exists(Customer::class, 'id', null, true)]
        public int $payee_id,
        #[Min(0)]
        public float $total,
        #[MapInputName('currency.iso'), MapOutputName('currency')]
        public CurrencyCode|Optional $currency_iso,
        /**
         * @var array<string, mixed>
         */
        // public array|Optional $meta,
        #[Exists(User::class, 'id', null, true)]
        public int|null $staff_id,
        #[Min(0)]
        public ?float $currency_total,
        public string $billing_addr_1,
        public ?string $billing_addr_2,
        public ?string $billing_addr_3,
        public string $billing_zip,
        public string $billing_city,
        public string $billing_state,
        public ?string $billing_attn,
        public string $shipping_addr_1,
        public ?string $shipping_addr_2,
        public ?string $shipping_addr_3,
        public string $shipping_zip,
        public string $shipping_city,
        public string $shipping_state,
        public ?string $shipping_attn,
        #[Email]
        public string|null|Optional $email,
        public string|null|Optional $phone,
        #[Exists(PaymentTerm::class, 'id', null, true)]
        public ?int $payment_term_id,
        #[DataCollectionOf(ScheduledTransactionData::class)]
        public DataCollection|Optional|Lazy $terms,
        public ?ApprovalStatus $status,
        #[DataCollectionOf(CustomFieldData::class)]
        public DataCollection|Lazy|Optional $custom_fields,
        public ?int $branch_id,
        public ?int $author_id,
        #[DataCollectionOf(StoreOrderItemData::class)]
        public Lazy|DataCollection $items,
        public ?bool $tax_inclusive,
        public ?DiscountServiceChargeData $discount,
        public ?DiscountServiceChargeData $service_charge,
        #[MapInputName('currency.exchange_rate'), Rule('gt:0')]
        public float|Lazy|Optional $currency_exchange_rate = 1,
        public ?float $rounding = 0,
    ) {
        $defaults = $this->getStoreDefaults();

        $this->branch_id = $branch_id ?? $defaults->default_branch_id;
        $this->staff_id = $staff_id ?? $defaults->default_staff_id;
        $this->author_id = $author_id ?? $defaults->default_author_id;
        $this->payment_term_id = $payment_term_id ?? $defaults->default_payment_term_id;
        $this->payment_term = $this->getPaymentTerm($this->payment_term_id);
        $this->terms = $this->payment_term ? $this->getPaymentTermSchedules($this->payment_term) : $terms;
        $this->type = $defaults->default_document;
        $this->doc_type = $defaults->default_document_types[$this->type->value];
        $this->status = $status ?? ApprovalStatus::Active;
        $this->tax_inclusive = ! is_null($tax_inclusive) ? $tax_inclusive : true;
        $this->billing_attn = $billing_attn ?? $this->payee;
        $this->shipping_attn = $shipping_attn ?? $this->billing_attn;
        $this->currency_iso = $currency_iso ?? $defaults->default_currency;
        $this->currency_total = $currency_total ?? $this->total;
        // calculate currency_total
        $this->total = $this->currency_total * $this->currency_exchange_rate;
        // default custom field
        $this->custom_fields = CustomFieldData::collection([
            $defaults->default_source_custom_field,
            ...(class_basename($custom_fields) === 'DataCollection' ? $custom_fields : []),
        ]);
    }

    /**
     * @return ScheduledTransactionData[]
     */
    private function getPaymentTermSchedules(PaymentTerm $payment_term): DataCollection
    {
        /**
         * @var array<int, PaymentTermData>
         */

        $terms = array_filter($payment_term->terms, fn (array $term) => isset($term['percent']) &&  $term['percent'] !== null);
        $terms = PaymentTermData::collection($terms);

        $result = ScheduledTransactionData::collection([]);
        if (! empty($terms)) {
            foreach ($terms as $term) {
                $result[] = ScheduledTransactionData::from([
                    'date' => $this->calculateDueDate(Carbon::parse($this->invoice_date), $term->due_unit_label, $term->due_num),
                    'amount' => $this->calculateTermAmount($this->total, $term->percent, $this->currency_exchange_rate),
                    'remark' => $this->generateTermRemark($term),
                ]);
            }
        }

        return $result;
    }

    private function getPaymentTerm(int $payment_term_id): PaymentTerm
    {
        $ttl = 60 * 60 * 24;

        return cache()->remember("payment_terms:{$payment_term_id}", $ttl, fn () => PaymentTerm::findOrFail($payment_term_id));
    }

    private function getStoreDefaults(): StoreSettingsData
    {
        return app(StoreRepositoryInterface::class)->getSettings();
    }

    private function calculateDueDate(Carbon $date, PaymentTermUnitText $due_unit, ?int $due_num): ?Carbon
    {
        return match ($due_unit) {
            null => null,
            PaymentTermUnitText::Today => $date,
            PaymentTermUnitText::NextMonth => $date->addMonth()->startOfMonth(),
            PaymentTermUnitText::EndOfMonth => $date->endOfMonth(),
            default => $due_num ? $date->add($due_num, $due_unit->value) : null,
        };
    }

    private function calculateTermAmount(float $grandTotal, float $percent, float $currency_exchange_rate = 1): float
    {
        return $grandTotal * $percent / 100 * $currency_exchange_rate;
    }

    private function generateTermRemark(PaymentTermData $term): string
    {
        return sprintf(
            "{$term->percent}%% | %s %s",
            $term->due_unit_label ? $term->due_num : '',
            $term->due_unit_label ? $term->due_unit_label->value : ''
        );
    }
}

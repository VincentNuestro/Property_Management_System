<?php

namespace App\DataMigration\Mappers;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Property;
use App\Models\Tenant;

class PaymentMapper extends BaseMapper
{
    /**
     * Map legacy payment data to new schema
     */
    public function map(array $legacyData): array
    {
        $propertyId = $this->findPropertyId($legacyData['PropertyID'] ?? $legacyData['MallID'] ?? null);
        $tenantId = $this->findTenantId($legacyData['TenantID'] ?? null);

        return [
            'property_id' => $propertyId,
            'tenant_id' => $tenantId,
            'payment_number' => $this->cleanString($legacyData['PaymentNo'] ?? $legacyData['ReceiptNo'] ?? $legacyData['PaymentNumber'] ?? ''),
            'payment_date' => $this->parseDate($legacyData['PaymentDate'] ?? $legacyData['DatePaid'] ?? null) ?? now(),
            'payment_method' => $this->mapPaymentMethod($legacyData['PaymentMethod'] ?? $legacyData['PaymentType'] ?? 'cash'),
            'amount' => $this->toDecimal($legacyData['Amount'] ?? $legacyData['PaymentAmount'] ?? 0),
            'reference_number' => $this->cleanString($legacyData['ReferenceNo'] ?? $legacyData['ReferenceNumber'] ?? $legacyData['TransactionRef'] ?? null),
            'check_number' => $this->cleanString($legacyData['CheckNo'] ?? $legacyData['CheckNumber'] ?? $legacyData['ChequeNumber'] ?? null),
            'check_date' => $this->parseDate($legacyData['CheckDate'] ?? $legacyData['ChequeDate'] ?? null),
            'bank_name' => $this->cleanString($legacyData['BankName'] ?? $legacyData['Bank'] ?? null),
            'status' => $this->mapPaymentStatus($legacyData['Status'] ?? 'cleared'),
            'bounced_date' => $this->parseDate($legacyData['BouncedDate'] ?? $legacyData['DateBounced'] ?? null),
            'bounced_reason' => $this->cleanString($legacyData['BouncedReason'] ?? $legacyData['BounceReason'] ?? null),
            'notes' => $this->cleanString($legacyData['Notes'] ?? $legacyData['Remarks'] ?? null),
            'created_at' => $this->parseDate($legacyData['DateCreated'] ?? null) ?? now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Validate mapped payment data
     */
    public function validate(array $data): bool
    {
        // Required fields
        if (empty($data['property_id']) || empty($data['tenant_id']) || empty($data['payment_number'])) {
            return false;
        }

        // Validate enums
        if (!$this->isValidEnum(PaymentMethod::class, $data['payment_method'])) {
            return false;
        }

        if (!$this->isValidEnum(PaymentStatus::class, $data['status'])) {
            return false;
        }

        // Validate amount
        if ($data['amount'] <= 0) {
            return false;
        }

        // If payment method is check, check_number should be present
        if ($data['payment_method'] === PaymentMethod::CHECK->value && empty($data['check_number'])) {
            // This is a warning, not a hard validation failure
        }

        return true;
    }

    /**
     * Map legacy payment method to PaymentMethod enum
     */
    protected function mapPaymentMethod(?string $method): string
    {
        $methodMap = [
            'cash' => PaymentMethod::CASH->value,
            'Cash' => PaymentMethod::CASH->value,
            'check' => PaymentMethod::CHECK->value,
            'Check' => PaymentMethod::CHECK->value,
            'cheque' => PaymentMethod::CHECK->value,
            'Cheque' => PaymentMethod::CHECK->value,
            'bank transfer' => PaymentMethod::BANK_TRANSFER->value,
            'Bank Transfer' => PaymentMethod::BANK_TRANSFER->value,
            'transfer' => PaymentMethod::BANK_TRANSFER->value,
            'Transfer' => PaymentMethod::BANK_TRANSFER->value,
            'wire' => PaymentMethod::BANK_TRANSFER->value,
            'Wire' => PaymentMethod::BANK_TRANSFER->value,
            'credit card' => PaymentMethod::CREDIT_CARD->value,
            'Credit Card' => PaymentMethod::CREDIT_CARD->value,
            'card' => PaymentMethod::CREDIT_CARD->value,
            'Card' => PaymentMethod::CREDIT_CARD->value,
            'online' => PaymentMethod::ONLINE->value,
            'Online' => PaymentMethod::ONLINE->value,
            'paypal' => PaymentMethod::ONLINE->value,
            'PayPal' => PaymentMethod::ONLINE->value,
        ];

        return $methodMap[$method] ?? PaymentMethod::CASH->value;
    }

    /**
     * Map legacy payment status to PaymentStatus enum
     */
    protected function mapPaymentStatus(?string $status): string
    {
        $statusMap = [
            'pending' => PaymentStatus::PENDING->value,
            'Pending' => PaymentStatus::PENDING->value,
            'cleared' => PaymentStatus::CLEARED->value,
            'Cleared' => PaymentStatus::CLEARED->value,
            'completed' => PaymentStatus::CLEARED->value,
            'Completed' => PaymentStatus::CLEARED->value,
            'approved' => PaymentStatus::CLEARED->value,
            'Approved' => PaymentStatus::CLEARED->value,
            'bounced' => PaymentStatus::BOUNCED->value,
            'Bounced' => PaymentStatus::BOUNCED->value,
            'returned' => PaymentStatus::BOUNCED->value,
            'Returned' => PaymentStatus::BOUNCED->value,
            'dishonored' => PaymentStatus::BOUNCED->value,
            'Dishonored' => PaymentStatus::BOUNCED->value,
            'void' => PaymentStatus::VOID->value,
            'Void' => PaymentStatus::VOID->value,
            'cancelled' => PaymentStatus::VOID->value,
            'Cancelled' => PaymentStatus::VOID->value,
        ];

        return $statusMap[$status] ?? PaymentStatus::CLEARED->value;
    }

    protected function findPropertyId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }
        return Property::where('id', $legacyId)->value('id');
    }

    protected function findTenantId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }
        return Tenant::where('id', $legacyId)->value('id');
    }
}

<?php

namespace App\DataMigration\Mappers;

use App\Enums\InvoiceStatus;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\LeaseContract;

class InvoiceMapper extends BaseMapper
{
    /**
     * Map legacy invoice data to new schema
     */
    public function map(array $legacyData): array
    {
        $propertyId = $this->findPropertyId($legacyData['PropertyID'] ?? $legacyData['MallID'] ?? null);
        $tenantId = $this->findTenantId($legacyData['TenantID'] ?? null);
        $leaseContractId = $this->findLeaseContractId($legacyData['ContractID'] ?? $legacyData['LeaseContractID'] ?? null);

        $subtotal = $this->toDecimal($legacyData['Subtotal'] ?? $legacyData['Amount'] ?? 0);
        $taxAmount = $this->toDecimal($legacyData['TaxAmount'] ?? $legacyData['Tax'] ?? 0);
        $totalAmount = $this->toDecimal($legacyData['TotalAmount'] ?? $legacyData['Total'] ?? ($subtotal + $taxAmount));
        $amountPaid = $this->toDecimal($legacyData['AmountPaid'] ?? $legacyData['Paid'] ?? 0);

        return [
            'property_id' => $propertyId,
            'tenant_id' => $tenantId,
            'lease_contract_id' => $leaseContractId,
            'invoice_number' => $this->cleanString($legacyData['InvoiceNo'] ?? $legacyData['SOANo'] ?? $legacyData['InvoiceNumber'] ?? ''),
            'invoice_date' => $this->parseDate($legacyData['InvoiceDate'] ?? $legacyData['SOADate'] ?? $legacyData['BillingDate'] ?? null) ?? now(),
            'due_date' => $this->parseDate($legacyData['DueDate'] ?? $legacyData['PaymentDueDate'] ?? null) ?? now()->addDays(30),
            'period_start' => $this->parseDate($legacyData['PeriodStart'] ?? $legacyData['BillingPeriodStart'] ?? null),
            'period_end' => $this->parseDate($legacyData['PeriodEnd'] ?? $legacyData['BillingPeriodEnd'] ?? null),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'amount_paid' => $amountPaid,
            'status' => $this->mapInvoiceStatus($legacyData['Status'] ?? null, $amountPaid, $totalAmount),
            'notes' => $this->cleanString($legacyData['Notes'] ?? $legacyData['Remarks'] ?? null),
            'created_at' => $this->parseDate($legacyData['DateCreated'] ?? null) ?? now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Validate mapped invoice data
     */
    public function validate(array $data): bool
    {
        // Required fields
        if (empty($data['property_id']) || empty($data['tenant_id']) || empty($data['invoice_number'])) {
            return false;
        }

        // Validate enum
        if (!$this->isValidEnum(InvoiceStatus::class, $data['status'])) {
            return false;
        }

        // Validate amounts
        if ($data['total_amount'] < 0 || $data['amount_paid'] < 0) {
            return false;
        }

        if ($data['amount_paid'] > $data['total_amount']) {
            return false; // Amount paid cannot exceed total
        }

        return true;
    }

    /**
     * Map legacy invoice status to InvoiceStatus enum
     * Also auto-determine status based on payment amounts
     */
    protected function mapInvoiceStatus(?string $status, float $amountPaid, float $totalAmount): string
    {
        // Auto-determine based on amounts
        if ($amountPaid >= $totalAmount) {
            return InvoiceStatus::PAID->value;
        }

        if ($amountPaid > 0 && $amountPaid < $totalAmount) {
            return InvoiceStatus::PARTIALLY_PAID->value;
        }

        // Map legacy status values
        $statusMap = [
            'draft' => InvoiceStatus::DRAFT->value,
            'Draft' => InvoiceStatus::DRAFT->value,
            'pending' => InvoiceStatus::SENT->value,
            'Pending' => InvoiceStatus::SENT->value,
            'sent' => InvoiceStatus::SENT->value,
            'Sent' => InvoiceStatus::SENT->value,
            'unpaid' => InvoiceStatus::SENT->value,
            'Unpaid' => InvoiceStatus::SENT->value,
            'partially paid' => InvoiceStatus::PARTIALLY_PAID->value,
            'Partially Paid' => InvoiceStatus::PARTIALLY_PAID->value,
            'partial' => InvoiceStatus::PARTIALLY_PAID->value,
            'Partial' => InvoiceStatus::PARTIALLY_PAID->value,
            'paid' => InvoiceStatus::PAID->value,
            'Paid' => InvoiceStatus::PAID->value,
            'overdue' => InvoiceStatus::OVERDUE->value,
            'Overdue' => InvoiceStatus::OVERDUE->value,
            'void' => InvoiceStatus::VOID->value,
            'Void' => InvoiceStatus::VOID->value,
            'cancelled' => InvoiceStatus::VOID->value,
            'Cancelled' => InvoiceStatus::VOID->value,
        ];

        return $statusMap[$status] ?? InvoiceStatus::SENT->value;
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

    protected function findLeaseContractId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }
        return LeaseContract::where('id', $legacyId)->value('id');
    }
}

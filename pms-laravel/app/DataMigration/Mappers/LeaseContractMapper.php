<?php

namespace App\DataMigration\Mappers;

use App\Enums\LeaseStatus;
use App\Enums\BillingCycle;
use App\Models\Property;
use App\Models\Tenant;

class LeaseContractMapper extends BaseMapper
{
    /**
     * Map legacy lease contract data to new schema
     */
    public function map(array $legacyData): array
    {
        $propertyId = $this->findPropertyId($legacyData['PropertyID'] ?? $legacyData['MallID'] ?? null);
        $tenantId = $this->findTenantId($legacyData['TenantID'] ?? null);

        return [
            'property_id' => $propertyId,
            'tenant_id' => $tenantId,
            'contract_number' => $this->cleanString($legacyData['ContractNo'] ?? $legacyData['ContractNumber'] ?? ''),
            'contract_date' => $this->parseDate($legacyData['ContractDate'] ?? $legacyData['DateSigned'] ?? null) ?? now(),
            'start_date' => $this->parseDate($legacyData['StartDate'] ?? $legacyData['LeaseStart'] ?? null) ?? now(),
            'end_date' => $this->parseDate($legacyData['EndDate'] ?? $legacyData['LeaseEnd'] ?? null),
            'lease_term_months' => $this->toInt($legacyData['LeaseTermMonths'] ?? $legacyData['Term'] ?? $legacyData['LeaseTerm'] ?? null),
            'security_deposit' => $this->toDecimal($legacyData['SecurityDeposit'] ?? $legacyData['Deposit'] ?? 0),
            'advance_rent_months' => $this->toInt($legacyData['AdvanceRentMonths'] ?? $legacyData['Advance'] ?? 0),
            'billing_cycle' => $this->mapBillingCycle($legacyData['BillingCycle'] ?? $legacyData['BillingFrequency'] ?? 'monthly'),
            'billing_day' => $this->toInt($legacyData['BillingDay'] ?? $legacyData['DueDay'] ?? 1),
            'escalation_rate' => $this->toDecimal($legacyData['EscalationRate'] ?? $legacyData['Escalation'] ?? null),
            'escalation_frequency_months' => $this->toInt($legacyData['EscalationFrequency'] ?? 12),
            'next_escalation_date' => $this->parseDate($legacyData['NextEscalationDate'] ?? null),
            'payment_terms_days' => $this->toInt($legacyData['PaymentTerms'] ?? $legacyData['GracePeriod'] ?? 0),
            'status' => $this->mapLeaseStatus($legacyData['Status'] ?? 'active'),
            'terminated_date' => $this->parseDate($legacyData['TerminatedDate'] ?? $legacyData['DateTerminated'] ?? null),
            'termination_reason' => $this->cleanString($legacyData['TerminationReason'] ?? null),
            'notes' => $this->cleanString($legacyData['Notes'] ?? $legacyData['Remarks'] ?? null),
            'created_at' => $this->parseDate($legacyData['DateCreated'] ?? null) ?? now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Validate mapped lease contract data
     */
    public function validate(array $data): bool
    {
        // Required fields
        if (empty($data['property_id']) || empty($data['tenant_id']) || empty($data['contract_number'])) {
            return false;
        }

        // Validate enums
        if (!$this->isValidEnum(LeaseStatus::class, $data['status'])) {
            return false;
        }

        if (!$this->isValidEnum(BillingCycle::class, $data['billing_cycle'])) {
            return false;
        }

        // Validate dates
        if ($data['start_date'] && $data['end_date']) {
            if ($data['end_date'] < $data['start_date']) {
                return false;
            }
        }

        return true;
    }

    /**
     * Map legacy lease status to LeaseStatus enum
     */
    protected function mapLeaseStatus(?string $status): string
    {
        $statusMap = [
            'draft' => LeaseStatus::DRAFT->value,
            'Draft' => LeaseStatus::DRAFT->value,
            'pending' => LeaseStatus::DRAFT->value,
            'Pending' => LeaseStatus::DRAFT->value,
            'active' => LeaseStatus::ACTIVE->value,
            'Active' => LeaseStatus::ACTIVE->value,
            'ongoing' => LeaseStatus::ACTIVE->value,
            'Ongoing' => LeaseStatus::ACTIVE->value,
            'current' => LeaseStatus::ACTIVE->value,
            'Current' => LeaseStatus::ACTIVE->value,
            'expired' => LeaseStatus::EXPIRED->value,
            'Expired' => LeaseStatus::EXPIRED->value,
            'terminated' => LeaseStatus::TERMINATED->value,
            'Terminated' => LeaseStatus::TERMINATED->value,
            'cancelled' => LeaseStatus::TERMINATED->value,
            'Cancelled' => LeaseStatus::TERMINATED->value,
            'renewed' => LeaseStatus::RENEWED->value,
            'Renewed' => LeaseStatus::RENEWED->value,
        ];

        return $statusMap[$status] ?? LeaseStatus::ACTIVE->value;
    }

    /**
     * Map legacy billing cycle to BillingCycle enum
     */
    protected function mapBillingCycle(?string $cycle): string
    {
        $cycleMap = [
            'monthly' => BillingCycle::MONTHLY->value,
            'Monthly' => BillingCycle::MONTHLY->value,
            'quarterly' => BillingCycle::QUARTERLY->value,
            'Quarterly' => BillingCycle::QUARTERLY->value,
            'annually' => BillingCycle::ANNUALLY->value,
            'Annually' => BillingCycle::ANNUALLY->value,
            'yearly' => BillingCycle::ANNUALLY->value,
            'Yearly' => BillingCycle::ANNUALLY->value,
        ];

        return $cycleMap[$cycle] ?? BillingCycle::MONTHLY->value;
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

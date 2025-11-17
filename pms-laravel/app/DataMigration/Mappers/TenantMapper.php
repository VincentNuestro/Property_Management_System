<?php

namespace App\DataMigration\Mappers;

use App\Enums\TenantType;
use App\Enums\TenantStatus;
use App\Models\Company;

class TenantMapper extends BaseMapper
{
    /**
     * Map legacy tenant data to new schema
     */
    public function map(array $legacyData): array
    {
        // Determine tenant type
        $tenantType = $this->determineTenantType($legacyData);
        $companyId = $this->findCompanyId($legacyData['CompanyID'] ?? null);

        return [
            'tenant_type' => $tenantType,
            'first_name' => $this->getFirstName($legacyData, $tenantType),
            'last_name' => $this->getLastName($legacyData, $tenantType),
            'company_id' => $companyId,
            'email' => $this->cleanEmail($legacyData['Email'] ?? $legacyData['ContactEmail'] ?? null),
            'phone' => $this->cleanString($legacyData['Phone'] ?? $legacyData['ContactNumber'] ?? null),
            'mobile' => $this->cleanString($legacyData['Mobile'] ?? $legacyData['CellNumber'] ?? $legacyData['MobileNumber'] ?? null),
            'address_line1' => $this->cleanString($legacyData['Address'] ?? $legacyData['Address1'] ?? null),
            'address_line2' => $this->cleanString($legacyData['Address2'] ?? null),
            'city' => $this->cleanString($legacyData['City'] ?? null),
            'state' => $this->cleanString($legacyData['Province'] ?? $legacyData['State'] ?? null),
            'postal_code' => $this->cleanString($legacyData['ZipCode'] ?? $legacyData['PostalCode'] ?? null),
            'country' => $this->cleanString($legacyData['Country'] ?? 'Philippines'),
            'government_id_type' => $this->cleanString($legacyData['IDType'] ?? $legacyData['GovernmentIDType'] ?? null),
            'government_id_number' => $this->cleanString($legacyData['IDNumber'] ?? $legacyData['GovernmentIDNumber'] ?? null),
            'date_of_birth' => $this->parseDate($legacyData['DateOfBirth'] ?? $legacyData['BirthDate'] ?? null),
            'nationality' => $this->cleanString($legacyData['Nationality'] ?? null),
            'status' => $this->mapTenantStatus($legacyData['Status'] ?? 'active'),
            'notes' => $this->cleanString($legacyData['Notes'] ?? $legacyData['Remarks'] ?? null),
            'created_at' => $this->parseDate($legacyData['DateCreated'] ?? null) ?? now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Validate mapped tenant data
     */
    public function validate(array $data): bool
    {
        // Required fields
        if (empty($data['tenant_type'])) {
            return false;
        }

        // Validate tenant type enum
        if (!$this->isValidEnum(TenantType::class, $data['tenant_type'])) {
            return false;
        }

        // Validate tenant status enum
        if (!$this->isValidEnum(TenantStatus::class, $data['status'])) {
            return false;
        }

        // For individual tenants, require at least first name or last name
        if ($data['tenant_type'] === TenantType::INDIVIDUAL->value) {
            if (empty($data['first_name']) && empty($data['last_name'])) {
                return false;
            }
        }

        // For corporate tenants, require company_id
        if ($data['tenant_type'] === TenantType::CORPORATE->value) {
            if (empty($data['company_id'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine tenant type from legacy data
     */
    protected function determineTenantType(array $legacyData): string
    {
        // Check explicit tenant type field
        if (isset($legacyData['TenantType'])) {
            return $this->mapTenantType($legacyData['TenantType']);
        }

        // If has CompanyID, likely corporate
        if (!empty($legacyData['CompanyID'])) {
            return TenantType::CORPORATE->value;
        }

        // If has company name but no first/last name, corporate
        if (!empty($legacyData['CompanyName']) && empty($legacyData['FirstName']) && empty($legacyData['LastName'])) {
            return TenantType::CORPORATE->value;
        }

        // Default to individual
        return TenantType::INDIVIDUAL->value;
    }

    /**
     * Get first name based on tenant type
     */
    protected function getFirstName(array $legacyData, string $tenantType): ?string
    {
        if ($tenantType === TenantType::CORPORATE->value) {
            // For corporate, use contact person first name
            return $this->cleanString($legacyData['ContactFirstName'] ?? $legacyData['ContactPerson'] ?? null);
        }

        return $this->cleanString($legacyData['FirstName'] ?? $legacyData['FName'] ?? null);
    }

    /**
     * Get last name based on tenant type
     */
    protected function getLastName(array $legacyData, string $tenantType): ?string
    {
        if ($tenantType === TenantType::CORPORATE->value) {
            // For corporate, use contact person last name
            return $this->cleanString($legacyData['ContactLastName'] ?? null);
        }

        return $this->cleanString($legacyData['LastName'] ?? $legacyData['LName'] ?? null);
    }

    /**
     * Map legacy tenant type to TenantType enum
     */
    protected function mapTenantType(?string $type): string
    {
        $typeMap = [
            'individual' => TenantType::INDIVIDUAL->value,
            'Individual' => TenantType::INDIVIDUAL->value,
            'personal' => TenantType::INDIVIDUAL->value,
            'Personal' => TenantType::INDIVIDUAL->value,
            'corporate' => TenantType::CORPORATE->value,
            'Corporate' => TenantType::CORPORATE->value,
            'company' => TenantType::CORPORATE->value,
            'Company' => TenantType::CORPORATE->value,
            'business' => TenantType::CORPORATE->value,
            'Business' => TenantType::CORPORATE->value,
        ];

        return $typeMap[$type] ?? TenantType::INDIVIDUAL->value;
    }

    /**
     * Map legacy tenant status to TenantStatus enum
     */
    protected function mapTenantStatus(?string $status): string
    {
        $statusMap = [
            'active' => TenantStatus::ACTIVE->value,
            'Active' => TenantStatus::ACTIVE->value,
            '1' => TenantStatus::ACTIVE->value,
            'inactive' => TenantStatus::INACTIVE->value,
            'Inactive' => TenantStatus::INACTIVE->value,
            '0' => TenantStatus::INACTIVE->value,
            'blacklisted' => TenantStatus::BLACKLISTED->value,
            'Blacklisted' => TenantStatus::BLACKLISTED->value,
            'blacklist' => TenantStatus::BLACKLISTED->value,
            'Blacklist' => TenantStatus::BLACKLISTED->value,
            'banned' => TenantStatus::BLACKLISTED->value,
            'Banned' => TenantStatus::BLACKLISTED->value,
        ];

        return $statusMap[$status] ?? TenantStatus::ACTIVE->value;
    }

    protected function findCompanyId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }
        return Company::where('id', $legacyId)->value('id');
    }
}

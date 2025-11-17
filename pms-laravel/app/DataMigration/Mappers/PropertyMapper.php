<?php

namespace App\DataMigration\Mappers;

use App\Enums\PropertyType;

class PropertyMapper extends BaseMapper
{
    /**
     * Map legacy property data to new schema
     */
    public function map(array $legacyData): array
    {
        return [
            'code' => $this->cleanString($legacyData['MallCode'] ?? $legacyData['PropertyCode'] ?? ''),
            'name' => $this->cleanString($legacyData['MallName'] ?? $legacyData['PropertyName'] ?? ''),
            'type' => $this->mapPropertyType($legacyData['PropertyType'] ?? $legacyData['Type'] ?? 'mall'),
            'address_line1' => $this->cleanString($legacyData['Address'] ?? $legacyData['Address1'] ?? null),
            'address_line2' => $this->cleanString($legacyData['Address2'] ?? null),
            'city' => $this->cleanString($legacyData['City'] ?? null),
            'state' => $this->cleanString($legacyData['Province'] ?? $legacyData['State'] ?? null),
            'postal_code' => $this->cleanString($legacyData['ZipCode'] ?? $legacyData['PostalCode'] ?? null),
            'country' => $this->cleanString($legacyData['Country'] ?? 'Philippines'),
            'phone' => $this->cleanString($legacyData['ContactNumber'] ?? $legacyData['Phone'] ?? null),
            'email' => $this->cleanEmail($legacyData['Email'] ?? null),
            'tax_id' => $this->cleanString($legacyData['TIN'] ?? $legacyData['TaxID'] ?? null),
            'status' => $this->mapStatus($legacyData['Status'] ?? 'active'),
            'created_at' => $this->parseDate($legacyData['DateCreated'] ?? null) ?? now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Validate mapped property data
     */
    public function validate(array $data): bool
    {
        // Required fields
        if (empty($data['code']) || empty($data['name'])) {
            return false;
        }

        // Validate property type enum
        if (!$this->isValidEnum(PropertyType::class, $data['type'])) {
            return false;
        }

        return true;
    }

    /**
     * Map legacy property type to PropertyType enum
     */
    protected function mapPropertyType(?string $type): string
    {
        $typeMap = [
            'mall' => PropertyType::MALL->value,
            'Mall' => PropertyType::MALL->value,
            'shopping mall' => PropertyType::MALL->value,
            'Shopping Mall' => PropertyType::MALL->value,
            'office' => PropertyType::OFFICE_BUILDING->value,
            'Office' => PropertyType::OFFICE_BUILDING->value,
            'office building' => PropertyType::OFFICE_BUILDING->value,
            'Office Building' => PropertyType::OFFICE_BUILDING->value,
            'residential' => PropertyType::RESIDENTIAL->value,
            'Residential' => PropertyType::RESIDENTIAL->value,
            'mixed use' => PropertyType::MIXED_USE->value,
            'Mixed Use' => PropertyType::MIXED_USE->value,
            'industrial' => PropertyType::INDUSTRIAL->value,
            'Industrial' => PropertyType::INDUSTRIAL->value,
        ];

        return $typeMap[$type] ?? PropertyType::MALL->value;
    }
}

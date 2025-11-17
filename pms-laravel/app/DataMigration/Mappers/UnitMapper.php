<?php

namespace App\DataMigration\Mappers;

use App\Enums\UnitType;
use App\Enums\UnitStatus;
use App\Models\Property;
use App\Models\Building;
use App\Models\Floor;

class UnitMapper extends BaseMapper
{
    /**
     * Map legacy unit data to new schema
     */
    public function map(array $legacyData): array
    {
        $propertyId = $this->findPropertyId($legacyData['PropertyID'] ?? $legacyData['MallID'] ?? null);
        $buildingId = $this->findBuildingId($legacyData['BuildingID'] ?? $legacyData['BldgID'] ?? null);
        $floorId = $this->findFloorId($legacyData['FloorID'] ?? null);

        return [
            'property_id' => $propertyId,
            'building_id' => $buildingId,
            'floor_id' => $floorId,
            'unit_code' => $this->cleanString($legacyData['UnitCode'] ?? $legacyData['Code'] ?? ''),
            'unit_number' => $this->cleanString($legacyData['UnitNumber'] ?? $legacyData['Number'] ?? ''),
            'type' => $this->mapUnitType($legacyData['UnitType'] ?? $legacyData['Type'] ?? 'commercial'),
            'classification' => $this->cleanString($legacyData['Classification'] ?? $legacyData['Category'] ?? null),
            'area_sqm' => $this->toDecimal($legacyData['FloorArea'] ?? $legacyData['SQM'] ?? null),
            'bedrooms' => $this->toInt($legacyData['Bedrooms'] ?? $legacyData['NoOfBedrooms'] ?? null),
            'bathrooms' => $this->toInt($legacyData['Bathrooms'] ?? $legacyData['NoOfBathrooms'] ?? null),
            'status' => $this->mapUnitStatus($legacyData['Status'] ?? 'vacant'),
            'base_rent' => $this->toDecimal($legacyData['MonthlyRent'] ?? $legacyData['BaseRent'] ?? $legacyData['Rent'] ?? 0),
            'association_dues' => $this->toDecimal($legacyData['AssociationDues'] ?? $legacyData['Dues'] ?? 0),
            'description' => $this->cleanString($legacyData['Description'] ?? null),
            'notes' => $this->cleanString($legacyData['Notes'] ?? $legacyData['Remarks'] ?? null),
            'created_at' => $this->parseDate($legacyData['DateCreated'] ?? null) ?? now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Validate mapped unit data
     */
    public function validate(array $data): bool
    {
        // Required fields
        if (empty($data['property_id']) || empty($data['unit_code'])) {
            return false;
        }

        // Validate enums
        if (!$this->isValidEnum(UnitType::class, $data['type'])) {
            return false;
        }

        if (!$this->isValidEnum(UnitStatus::class, $data['status'])) {
            return false;
        }

        return true;
    }

    /**
     * Map legacy unit type to UnitType enum
     */
    protected function mapUnitType(?string $type): string
    {
        $typeMap = [
            'commercial' => UnitType::COMMERCIAL->value,
            'Commercial' => UnitType::COMMERCIAL->value,
            'retail' => UnitType::COMMERCIAL->value,
            'Retail' => UnitType::COMMERCIAL->value,
            'shop' => UnitType::COMMERCIAL->value,
            'Shop' => UnitType::COMMERCIAL->value,
            'office' => UnitType::OFFICE->value,
            'Office' => UnitType::OFFICE->value,
            'residential' => UnitType::RESIDENTIAL->value,
            'Residential' => UnitType::RESIDENTIAL->value,
            'condo' => UnitType::RESIDENTIAL->value,
            'Condo' => UnitType::RESIDENTIAL->value,
            'apartment' => UnitType::RESIDENTIAL->value,
            'Apartment' => UnitType::RESIDENTIAL->value,
            'parking' => UnitType::PARKING->value,
            'Parking' => UnitType::PARKING->value,
            'storage' => UnitType::STORAGE->value,
            'Storage' => UnitType::STORAGE->value,
            'warehouse' => UnitType::STORAGE->value,
            'Warehouse' => UnitType::STORAGE->value,
            'kiosk' => UnitType::KIOSK->value,
            'Kiosk' => UnitType::KIOSK->value,
        ];

        return $typeMap[$type] ?? UnitType::COMMERCIAL->value;
    }

    /**
     * Map legacy unit status to UnitStatus enum
     */
    protected function mapUnitStatus(?string $status): string
    {
        $statusMap = [
            'vacant' => UnitStatus::VACANT->value,
            'Vacant' => UnitStatus::VACANT->value,
            'available' => UnitStatus::VACANT->value,
            'Available' => UnitStatus::VACANT->value,
            'occupied' => UnitStatus::OCCUPIED->value,
            'Occupied' => UnitStatus::OCCUPIED->value,
            'leased' => UnitStatus::OCCUPIED->value,
            'Leased' => UnitStatus::OCCUPIED->value,
            'reserved' => UnitStatus::RESERVED->value,
            'Reserved' => UnitStatus::RESERVED->value,
            'maintenance' => UnitStatus::MAINTENANCE->value,
            'Maintenance' => UnitStatus::MAINTENANCE->value,
            'under maintenance' => UnitStatus::MAINTENANCE->value,
            'Under Maintenance' => UnitStatus::MAINTENANCE->value,
            'unavailable' => UnitStatus::UNAVAILABLE->value,
            'Unavailable' => UnitStatus::UNAVAILABLE->value,
            'inactive' => UnitStatus::UNAVAILABLE->value,
            'Inactive' => UnitStatus::UNAVAILABLE->value,
        ];

        return $statusMap[$status] ?? UnitStatus::VACANT->value;
    }

    protected function findPropertyId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }
        return Property::where('id', $legacyId)->value('id');
    }

    protected function findBuildingId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }
        return Building::where('id', $legacyId)->value('id');
    }

    protected function findFloorId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }
        return Floor::where('id', $legacyId)->value('id');
    }
}

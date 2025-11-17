<?php

namespace App\DataMigration\Mappers;

use Exception;

abstract class BaseMapper
{
    /**
     * Map legacy data to new schema
     */
    abstract public function map(array $legacyData): array;

    /**
     * Validate mapped data
     */
    abstract public function validate(array $data): bool;

    /**
     * Clean string value
     */
    protected function cleanString(?string $value): ?string
    {
        if (!$value || trim($value) === '') {
            return null;
        }

        return trim($value);
    }

    /**
     * Clean and validate email
     */
    protected function cleanEmail(?string $email): ?string
    {
        $email = $this->cleanString($email);

        if (!$email) {
            return null;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        return strtolower($email);
    }

    /**
     * Parse date value
     */
    protected function parseDate($value)
    {
        if (!$value || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value)->startOfDay();
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Parse datetime value
     */
    protected function parseDateTime($value)
    {
        if (!$value || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Map legacy status to new status
     */
    protected function mapStatus(?string $status): string
    {
        $statusMap = [
            'active' => 'active',
            'Active' => 'active',
            '1' => 'active',
            'inactive' => 'inactive',
            'Inactive' => 'inactive',
            '0' => 'inactive',
            'deleted' => 'inactive',
            'Deleted' => 'inactive',
        ];

        return $statusMap[$status] ?? 'active';
    }

    /**
     * Check if value is valid enum
     */
    protected function isValidEnum(string $enumClass, $value): bool
    {
        if (!enum_exists($enumClass)) {
            return false;
        }

        $cases = $enumClass::cases();
        $values = array_map(fn($case) => $case->value, $cases);

        return in_array($value, $values);
    }

    /**
     * Convert to decimal
     */
    protected function toDecimal($value, int $precision = 2): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return round((float) $value, $precision);
    }

    /**
     * Convert to integer
     */
    protected function toInt($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (int) $value;
    }

    /**
     * Convert to boolean
     */
    protected function toBool($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        $trueValues = ['1', 'true', 'yes', 'on', 1, true];
        return in_array($value, $trueValues, true);
    }
}

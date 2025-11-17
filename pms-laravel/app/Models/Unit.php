<?php

namespace App\Models;

use App\Enums\UnitType;
use App\Enums\UnitStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Unit extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'property_id',
        'building_id',
        'floor_id',
        'unit_code',
        'unit_number',
        'type',
        'classification',
        'area_sqm',
        'bedrooms',
        'bathrooms',
        'status',
        'base_rent',
        'association_dues',
        'description',
        'notes',
    ];

    protected $casts = [
        'property_id' => 'integer',
        'building_id' => 'integer',
        'floor_id' => 'integer',
        'type' => UnitType::class,
        'status' => UnitStatus::class,
        'area_sqm' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'base_rent' => 'decimal:2',
        'association_dues' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Activity log configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['unit_code', 'unit_number', 'type', 'status', 'base_rent'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Relationships
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function leaseContracts(): BelongsToMany
    {
        return $this->belongsToMany(LeaseContract::class, 'lease_contract_unit')
            ->withPivot('monthly_rent', 'association_dues')
            ->withTimestamps();
    }

    public function activeLeaseContract(): BelongsToMany
    {
        return $this->leaseContracts()
            ->wherePivot('status', 'active')
            ->latest();
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    /**
     * Accessors
     */
    public function getFullLocationAttribute(): string
    {
        $parts = [
            $this->property->name,
        ];

        if ($this->building) {
            $parts[] = $this->building->name;
        }

        if ($this->floor) {
            $parts[] = $this->floor->display_name;
        }

        $parts[] = $this->unit_number;

        return implode(' - ', $parts);
    }

    public function getTotalMonthlyChargeAttribute(): float
    {
        return (float) ($this->base_rent + $this->association_dues);
    }

    /**
     * Scopes
     */
    public function scopeVacant($query)
    {
        return $query->where('status', UnitStatus::VACANT);
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', UnitStatus::OCCUPIED);
    }

    public function scopeReserved($query)
    {
        return $query->where('status', UnitStatus::RESERVED);
    }

    public function scopeMaintenance($query)
    {
        return $query->where('status', UnitStatus::MAINTENANCE);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', UnitStatus::UNAVAILABLE);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', UnitStatus::VACANT);
    }

    public function scopeOfType($query, UnitType $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForProperty($query, int $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeForBuilding($query, int $buildingId)
    {
        return $query->where('building_id', $buildingId);
    }

    public function scopeForFloor($query, int $floorId)
    {
        return $query->where('floor_id', $floorId);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('unit_code', 'like', "%{$term}%")
              ->orWhere('unit_number', 'like', "%{$term}%")
              ->orWhere('classification', 'like', "%{$term}%");
        });
    }
}

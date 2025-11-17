<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Reservation extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'property_id',
        'unit_id',
        'tenant_id',
        'reservation_number',
        'reservation_date',
        'reservation_fee',
        'reservation_paid',
        'expiry_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'property_id' => 'integer',
        'unit_id' => 'integer',
        'tenant_id' => 'integer',
        'status' => ReservationStatus::class,
        'reservation_date' => 'date',
        'expiry_date' => 'date',
        'reservation_fee' => 'decimal:2',
        'reservation_paid' => 'decimal:2',
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
            ->logOnly(['reservation_number', 'unit_id', 'tenant_id', 'status'])
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

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Accessors
     */
    public function getBalanceAttribute(): float
    {
        return (float) ($this->reservation_fee - $this->reservation_paid);
    }

    public function getIsFullyPaidAttribute(): bool
    {
        return $this->balance <= 0;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function getDaysUntilExpiryAttribute(): ?int
    {
        if (!$this->expiry_date) {
            return null;
        }

        return now()->diffInDays($this->expiry_date, false);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', ReservationStatus::ACTIVE);
    }

    public function scopeConverted($query)
    {
        return $query->where('status', ReservationStatus::CONVERTED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', ReservationStatus::CANCELLED);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', ReservationStatus::EXPIRED);
    }

    public function scopeForProperty($query, int $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeForUnit($query, int $unitId)
    {
        return $query->where('unit_id', $unitId);
    }

    public function scopeForTenant($query, int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeUnpaid($query)
    {
        return $query->whereColumn('reservation_paid', '<', 'reservation_fee');
    }

    public function scopeExpiringWithin($query, int $days)
    {
        return $query->where('expiry_date', '<=', now()->addDays($days))
                     ->where('expiry_date', '>=', now());
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('reservation_number', 'like', "%{$term}%")
              ->orWhereHas('tenant', function ($tq) use ($term) {
                  $tq->where('first_name', 'like', "%{$term}%")
                     ->orWhere('last_name', 'like', "%{$term}%");
              })
              ->orWhereHas('unit', function ($uq) use ($term) {
                  $uq->where('unit_code', 'like', "%{$term}%")
                     ->orWhere('unit_number', 'like', "%{$term}%");
              });
        });
    }
}

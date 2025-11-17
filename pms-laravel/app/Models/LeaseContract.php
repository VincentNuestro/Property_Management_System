<?php

namespace App\Models;

use App\Enums\LeaseStatus;
use App\Enums\BillingCycle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LeaseContract extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'contract_number',
        'contract_date',
        'start_date',
        'end_date',
        'lease_term_months',
        'security_deposit',
        'advance_rent_months',
        'billing_cycle',
        'billing_day',
        'escalation_rate',
        'escalation_frequency_months',
        'next_escalation_date',
        'payment_terms_days',
        'status',
        'terminated_date',
        'termination_reason',
        'notes',
    ];

    protected $casts = [
        'property_id' => 'integer',
        'tenant_id' => 'integer',
        'status' => LeaseStatus::class,
        'billing_cycle' => BillingCycle::class,
        'contract_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'terminated_date' => 'date',
        'next_escalation_date' => 'date',
        'lease_term_months' => 'integer',
        'security_deposit' => 'decimal:2',
        'advance_rent_months' => 'integer',
        'billing_day' => 'integer',
        'escalation_rate' => 'decimal:2',
        'escalation_frequency_months' => 'integer',
        'payment_terms_days' => 'integer',
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
            ->logOnly(['contract_number', 'tenant_id', 'status', 'start_date', 'end_date'])
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

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'lease_contract_unit')
            ->withPivot('monthly_rent', 'association_dues')
            ->withTimestamps();
    }

    public function contractCharges(): HasMany
    {
        return $this->hasMany(ContractCharge::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Accessors
     */
    public function getTotalMonthlyRentAttribute(): float
    {
        return (float) $this->units->sum('pivot.monthly_rent');
    }

    public function getTotalAssociationDuesAttribute(): float
    {
        return (float) $this->units->sum('pivot.association_dues');
    }

    public function getTotalMonthlyChargesAttribute(): float
    {
        return $this->total_monthly_rent + $this->total_association_dues;
    }

    public function getDaysRemainingAttribute(): ?int
    {
        if (!$this->end_date || $this->end_date->isPast()) {
            return null;
        }

        return now()->diffInDays($this->end_date);
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->end_date && $this->end_date->isPast();
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === LeaseStatus::ACTIVE &&
               $this->start_date->isPast() &&
               (!$this->end_date || $this->end_date->isFuture());
    }

    /**
     * Scopes
     */
    public function scopeDraft($query)
    {
        return $query->where('status', LeaseStatus::DRAFT);
    }

    public function scopeActive($query)
    {
        return $query->where('status', LeaseStatus::ACTIVE);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', LeaseStatus::EXPIRED);
    }

    public function scopeTerminated($query)
    {
        return $query->where('status', LeaseStatus::TERMINATED);
    }

    public function scopeRenewed($query)
    {
        return $query->where('status', LeaseStatus::RENEWED);
    }

    public function scopeForProperty($query, int $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeForTenant($query, int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeExpiringWithin($query, int $days)
    {
        return $query->where('end_date', '<=', now()->addDays($days))
                     ->where('end_date', '>=', now())
                     ->where('status', LeaseStatus::ACTIVE);
    }

    public function scopeNeedingEscalation($query)
    {
        return $query->where('next_escalation_date', '<=', now())
                     ->where('status', LeaseStatus::ACTIVE)
                     ->whereNotNull('escalation_rate')
                     ->where('escalation_rate', '>', 0);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('contract_number', 'like', "%{$term}%")
              ->orWhereHas('tenant', function ($tq) use ($term) {
                  $tq->where('first_name', 'like', "%{$term}%")
                     ->orWhere('last_name', 'like', "%{$term}%");
              })
              ->orWhereHas('units', function ($uq) use ($term) {
                  $uq->where('unit_code', 'like', "%{$term}%")
                     ->orWhere('unit_number', 'like', "%{$term}%");
              });
        });
    }
}

<?php

namespace App\Models;

use App\Enums\TenantType;
use App\Enums\TenantStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Tenant extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'tenant_type',
        'first_name',
        'last_name',
        'company_id',
        'email',
        'phone',
        'mobile',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'government_id_type',
        'government_id_number',
        'date_of_birth',
        'nationality',
        'status',
        'notes',
    ];

    protected $casts = [
        'tenant_type' => TenantType::class,
        'status' => TenantStatus::class,
        'company_id' => 'integer',
        'date_of_birth' => 'date',
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
            ->logOnly(['tenant_type', 'first_name', 'last_name', 'company_id', 'email', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Relationships
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function leaseApplications(): HasMany
    {
        return $this->hasMany(LeaseApplication::class);
    }

    public function leaseContracts(): HasMany
    {
        return $this->hasMany(LeaseContract::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    /**
     * Accessors
     */
    public function getFullNameAttribute(): string
    {
        if ($this->tenant_type === TenantType::CORPORATE) {
            return $this->company?->display_name ?? 'Unknown Company';
        }

        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->full_name;
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address_line1,
            $this->address_line2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    public function getPrimaryContactAttribute(): ?string
    {
        return $this->mobile ?: $this->phone;
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', TenantStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', TenantStatus::INACTIVE);
    }

    public function scopeBlacklisted($query)
    {
        return $query->where('status', TenantStatus::BLACKLISTED);
    }

    public function scopeIndividual($query)
    {
        return $query->where('tenant_type', TenantType::INDIVIDUAL);
    }

    public function scopeCorporate($query)
    {
        return $query->where('tenant_type', TenantType::CORPORATE);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('first_name', 'like', "%{$term}%")
              ->orWhere('last_name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('mobile', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
              ->orWhereHas('company', function ($cq) use ($term) {
                  $cq->where('name', 'like', "%{$term}%")
                     ->orWhere('trade_name', 'like', "%{$term}%");
              });
        });
    }
}

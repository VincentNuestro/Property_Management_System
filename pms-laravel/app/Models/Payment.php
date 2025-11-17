<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Payment extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'payment_number',
        'payment_date',
        'payment_method',
        'amount',
        'reference_number',
        'check_number',
        'check_date',
        'bank_name',
        'status',
        'bounced_date',
        'bounced_reason',
        'notes',
    ];

    protected $casts = [
        'property_id' => 'integer',
        'tenant_id' => 'integer',
        'payment_method' => PaymentMethod::class,
        'status' => PaymentStatus::class,
        'payment_date' => 'date',
        'check_date' => 'date',
        'bounced_date' => 'date',
        'amount' => 'decimal:2',
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
            ->logOnly(['payment_number', 'tenant_id', 'amount', 'payment_method', 'status'])
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

    public function paymentApplications(): HasMany
    {
        return $this->hasMany(PaymentApplication::class);
    }

    public function receipt(): HasOne
    {
        return $this->hasOne(Receipt::class);
    }

    /**
     * Accessors
     */
    public function getAmountAppliedAttribute(): float
    {
        return (float) $this->paymentApplications()->sum('amount_applied');
    }

    public function getUnappliedAmountAttribute(): float
    {
        return (float) ($this->amount - $this->amount_applied);
    }

    public function getIsFullyAppliedAttribute(): bool
    {
        return $this->unapplied_amount <= 0.01; // Allow for rounding
    }

    public function getHasReceiptAttribute(): bool
    {
        return !is_null($this->receipt);
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', PaymentStatus::PENDING);
    }

    public function scopeCleared($query)
    {
        return $query->where('status', PaymentStatus::CLEARED);
    }

    public function scopeBounced($query)
    {
        return $query->where('status', PaymentStatus::BOUNCED);
    }

    public function scopeVoid($query)
    {
        return $query->where('status', PaymentStatus::VOID);
    }

    public function scopeForProperty($query, int $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeForTenant($query, int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeByMethod($query, PaymentMethod $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeForPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

    public function scopeUnapplied($query)
    {
        return $query->whereHas('paymentApplications', function ($q) {
            // Has unapplied amount
        }, '<', function ($q) {
            $q->selectRaw('SUM(amount)');
        });
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('payment_number', 'like', "%{$term}%")
              ->orWhere('reference_number', 'like', "%{$term}%")
              ->orWhere('check_number', 'like', "%{$term}%")
              ->orWhereHas('tenant', function ($tq) use ($term) {
                  $tq->where('first_name', 'like', "%{$term}%")
                     ->orWhere('last_name', 'like', "%{$term}%");
              });
        });
    }
}

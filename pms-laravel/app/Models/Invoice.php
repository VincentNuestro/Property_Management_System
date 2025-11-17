<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Invoice extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'lease_contract_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'period_start',
        'period_end',
        'subtotal',
        'tax_amount',
        'total_amount',
        'amount_paid',
        'status',
        'notes',
    ];

    protected $casts = [
        'property_id' => 'integer',
        'tenant_id' => 'integer',
        'lease_contract_id' => 'integer',
        'status' => InvoiceStatus::class,
        'invoice_date' => 'date',
        'due_date' => 'date',
        'period_start' => 'date',
        'period_end' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
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
            ->logOnly(['invoice_number', 'tenant_id', 'total_amount', 'amount_paid', 'status'])
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

    public function leaseContract(): BelongsTo
    {
        return $this->belongsTo(LeaseContract::class);
    }

    public function lineItems(): HasMany
    {
        return $this->hasMany(InvoiceLineItem::class);
    }

    public function penalties(): HasMany
    {
        return $this->hasMany(Penalty::class);
    }

    public function paymentApplications(): HasMany
    {
        return $this->hasMany(PaymentApplication::class);
    }

    /**
     * Accessors
     */
    public function getBalanceAttribute(): float
    {
        return (float) ($this->total_amount - $this->amount_paid);
    }

    public function getIsFullyPaidAttribute(): bool
    {
        return $this->balance <= 0.01; // Allow for rounding
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date->isPast() && !$this->is_fully_paid;
    }

    public function getDaysOverdueAttribute(): int
    {
        if (!$this->is_overdue) {
            return 0;
        }

        return now()->diffInDays($this->due_date);
    }

    public function getDaysUntilDueAttribute(): int
    {
        return now()->diffInDays($this->due_date, false);
    }

    public function getTotalPenaltiesAttribute(): float
    {
        return (float) $this->penalties()->sum('penalty_amount');
    }

    public function getTotalWithPenaltiesAttribute(): float
    {
        return $this->total_amount + $this->total_penalties;
    }

    /**
     * Scopes
     */
    public function scopeDraft($query)
    {
        return $query->where('status', InvoiceStatus::DRAFT);
    }

    public function scopeSent($query)
    {
        return $query->where('status', InvoiceStatus::SENT);
    }

    public function scopePartiallyPaid($query)
    {
        return $query->where('status', InvoiceStatus::PARTIALLY_PAID);
    }

    public function scopePaid($query)
    {
        return $query->where('status', InvoiceStatus::PAID);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', InvoiceStatus::OVERDUE);
    }

    public function scopeVoid($query)
    {
        return $query->where('status', InvoiceStatus::VOID);
    }

    public function scopeUnpaid($query)
    {
        return $query->whereIn('status', [
            InvoiceStatus::SENT,
            InvoiceStatus::OVERDUE,
            InvoiceStatus::PARTIALLY_PAID,
        ]);
    }

    public function scopeForProperty($query, int $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeForTenant($query, int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeForContract($query, int $contractId)
    {
        return $query->where('lease_contract_id', $contractId);
    }

    public function scopeDueWithin($query, int $days)
    {
        return $query->where('due_date', '<=', now()->addDays($days))
                     ->where('due_date', '>=', now())
                     ->unpaid();
    }

    public function scopeOverdueBy($query, int $days)
    {
        return $query->where('due_date', '<', now()->subDays($days))
                     ->unpaid();
    }

    public function scopeForPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('invoice_date', [$startDate, $endDate]);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('invoice_number', 'like', "%{$term}%")
              ->orWhereHas('tenant', function ($tq) use ($term) {
                  $tq->where('first_name', 'like', "%{$term}%")
                     ->orWhere('last_name', 'like', "%{$term}%");
              });
        });
    }
}

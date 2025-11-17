<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Penalty extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'invoice_id',
        'penalty_date',
        'days_overdue',
        'penalty_rate',
        'base_amount',
        'penalty_amount',
        'is_waived',
        'waived_by',
        'waived_at',
        'waiver_reason',
        'notes',
    ];

    protected $casts = [
        'invoice_id' => 'integer',
        'waived_by' => 'integer',
        'penalty_date' => 'date',
        'days_overdue' => 'integer',
        'penalty_rate' => 'decimal:2',
        'base_amount' => 'decimal:2',
        'penalty_amount' => 'decimal:2',
        'is_waived' => 'boolean',
        'waived_at' => 'datetime',
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
            ->logOnly(['invoice_id', 'penalty_amount', 'is_waived', 'waived_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Relationships
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function waivedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'waived_by');
    }

    /**
     * Accessors
     */
    public function getEffectiveAmountAttribute(): float
    {
        return $this->is_waived ? 0 : (float) $this->penalty_amount;
    }

    /**
     * Scopes
     */
    public function scopeForInvoice($query, int $invoiceId)
    {
        return $query->where('invoice_id', $invoiceId);
    }

    public function scopeWaived($query)
    {
        return $query->where('is_waived', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_waived', false);
    }

    public function scopeForPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('penalty_date', [$startDate, $endDate]);
    }
}

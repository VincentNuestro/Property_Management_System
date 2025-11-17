<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ContractCharge extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'lease_contract_id',
        'charge_type_id',
        'amount',
        'is_recurring',
        'notes',
    ];

    protected $casts = [
        'lease_contract_id' => 'integer',
        'charge_type_id' => 'integer',
        'amount' => 'decimal:2',
        'is_recurring' => 'boolean',
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
            ->logOnly(['lease_contract_id', 'charge_type_id', 'amount', 'is_recurring'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Relationships
     */
    public function leaseContract(): BelongsTo
    {
        return $this->belongsTo(LeaseContract::class);
    }

    public function chargeType(): BelongsTo
    {
        return $this->belongsTo(ChargeType::class);
    }

    /**
     * Scopes
     */
    public function scopeRecurring($query)
    {
        return $query->where('is_recurring', true);
    }

    public function scopeOneTime($query)
    {
        return $query->where('is_recurring', false);
    }

    public function scopeForContract($query, int $contractId)
    {
        return $query->where('lease_contract_id', $contractId);
    }
}

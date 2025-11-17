<?php

namespace App\Models;

use App\Enums\InquiryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'property_id',
        'inquiry_number',
        'inquirer_name',
        'inquirer_email',
        'inquirer_phone',
        'company_name',
        'space_type',
        'desired_area_sqm',
        'desired_move_in_date',
        'budget_min',
        'budget_max',
        'source',
        'status',
        'assigned_to',
        'notes',
    ];

    protected $casts = [
        'property_id' => 'integer',
        'assigned_to' => 'integer',
        'status' => InquiryStatus::class,
        'desired_area_sqm' => 'decimal:2',
        'desired_move_in_date' => 'date',
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
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
            ->logOnly(['inquiry_number', 'inquirer_name', 'status', 'assigned_to'])
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

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Accessors
     */
    public function getBudgetRangeAttribute(): ?string
    {
        if (!$this->budget_min && !$this->budget_max) {
            return null;
        }

        if ($this->budget_min && $this->budget_max) {
            return config('pms.currency.symbol') . number_format($this->budget_min, 2) . ' - ' .
                   config('pms.currency.symbol') . number_format($this->budget_max, 2);
        }

        if ($this->budget_min) {
            return 'Min: ' . config('pms.currency.symbol') . number_format($this->budget_min, 2);
        }

        return 'Max: ' . config('pms.currency.symbol') . number_format($this->budget_max, 2);
    }

    /**
     * Scopes
     */
    public function scopeNew($query)
    {
        return $query->where('status', InquiryStatus::NEW);
    }

    public function scopeContacted($query)
    {
        return $query->where('status', InquiryStatus::CONTACTED);
    }

    public function scopeQualified($query)
    {
        return $query->where('status', InquiryStatus::QUALIFIED);
    }

    public function scopeProposalSent($query)
    {
        return $query->where('status', InquiryStatus::PROPOSAL_SENT);
    }

    public function scopeWon($query)
    {
        return $query->where('status', InquiryStatus::WON);
    }

    public function scopeLost($query)
    {
        return $query->where('status', InquiryStatus::LOST);
    }

    public function scopeForProperty($query, int $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('inquiry_number', 'like', "%{$term}%")
              ->orWhere('inquirer_name', 'like', "%{$term}%")
              ->orWhere('inquirer_email', 'like', "%{$term}%")
              ->orWhere('inquirer_phone', 'like', "%{$term}%")
              ->orWhere('company_name', 'like', "%{$term}%");
        });
    }
}

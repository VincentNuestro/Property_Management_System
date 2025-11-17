<?php

namespace App\Models;

use App\Enums\LeaseApplicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LeaseApplication extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'application_number',
        'application_date',
        'desired_start_date',
        'desired_lease_term',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'notes',
    ];

    protected $casts = [
        'property_id' => 'integer',
        'tenant_id' => 'integer',
        'reviewed_by' => 'integer',
        'status' => LeaseApplicationStatus::class,
        'application_date' => 'date',
        'desired_start_date' => 'date',
        'desired_lease_term' => 'integer',
        'reviewed_at' => 'datetime',
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
            ->logOnly(['application_number', 'tenant_id', 'status', 'reviewed_by'])
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

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Accessors
     */
    public function getIsReviewedAttribute(): bool
    {
        return !is_null($this->reviewed_at);
    }

    public function getIsPendingAttribute(): bool
    {
        return in_array($this->status, [
            LeaseApplicationStatus::DRAFT,
            LeaseApplicationStatus::SUBMITTED,
            LeaseApplicationStatus::UNDER_REVIEW,
        ]);
    }

    /**
     * Scopes
     */
    public function scopeDraft($query)
    {
        return $query->where('status', LeaseApplicationStatus::DRAFT);
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', LeaseApplicationStatus::SUBMITTED);
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', LeaseApplicationStatus::UNDER_REVIEW);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', LeaseApplicationStatus::APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', LeaseApplicationStatus::REJECTED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', LeaseApplicationStatus::CANCELLED);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', [
            LeaseApplicationStatus::DRAFT,
            LeaseApplicationStatus::SUBMITTED,
            LeaseApplicationStatus::UNDER_REVIEW,
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

    public function scopeReviewedBy($query, int $userId)
    {
        return $query->where('reviewed_by', $userId);
    }

    public function scopeUnreviewed($query)
    {
        return $query->whereNull('reviewed_at');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('application_number', 'like', "%{$term}%")
              ->orWhereHas('tenant', function ($tq) use ($term) {
                  $tq->where('first_name', 'like', "%{$term}%")
                     ->orWhere('last_name', 'like', "%{$term}%");
              });
        });
    }
}

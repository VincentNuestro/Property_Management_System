<?php

namespace App\Models;

use App\Enums\MaintenancePriority;
use App\Enums\MaintenanceRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MaintenanceRequest extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'property_id',
        'unit_id',
        'tenant_id',
        'request_number',
        'request_date',
        'category',
        'title',
        'description',
        'priority',
        'status',
        'assigned_to',
        'scheduled_date',
        'completed_date',
        'notes',
    ];

    protected $casts = [
        'property_id' => 'integer',
        'unit_id' => 'integer',
        'tenant_id' => 'integer',
        'assigned_to' => 'integer',
        'priority' => MaintenancePriority::class,
        'status' => MaintenanceRequestStatus::class,
        'request_date' => 'date',
        'scheduled_date' => 'date',
        'completed_date' => 'date',
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
            ->logOnly(['request_number', 'title', 'priority', 'status', 'assigned_to'])
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

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }

    /**
     * Accessors
     */
    public function getDaysOpenAttribute(): int
    {
        $endDate = $this->completed_date ?? now();
        return $this->request_date->diffInDays($endDate);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->scheduled_date &&
               $this->scheduled_date->isPast() &&
               !$this->completed_date;
    }

    /**
     * Scopes
     */
    public function scopeOpen($query)
    {
        return $query->where('status', MaintenanceRequestStatus::OPEN);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', MaintenanceRequestStatus::IN_PROGRESS);
    }

    public function scopeOnHold($query)
    {
        return $query->where('status', MaintenanceRequestStatus::ON_HOLD);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', MaintenanceRequestStatus::COMPLETED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', MaintenanceRequestStatus::CANCELLED);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            MaintenanceRequestStatus::OPEN,
            MaintenanceRequestStatus::IN_PROGRESS,
            MaintenanceRequestStatus::ON_HOLD,
        ]);
    }

    public function scopeLow($query)
    {
        return $query->where('priority', MaintenancePriority::LOW);
    }

    public function scopeMedium($query)
    {
        return $query->where('priority', MaintenancePriority::MEDIUM);
    }

    public function scopeHigh($query)
    {
        return $query->where('priority', MaintenancePriority::HIGH);
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', MaintenancePriority::URGENT);
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

    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotNull('scheduled_date')
                     ->where('scheduled_date', '<', now())
                     ->whereNull('completed_date');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('request_number', 'like', "%{$term}%")
              ->orWhere('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('category', 'like', "%{$term}%");
        });
    }
}

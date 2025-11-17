<?php

namespace App\Models;

use App\Enums\WorkOrderStatus;
use App\Enums\WorkOrderType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'maintenance_request_id',
        'work_order_number',
        'type',
        'title',
        'description',
        'assigned_to',
        'vendor_name',
        'vendor_contact',
        'scheduled_date',
        'started_date',
        'completed_date',
        'estimated_cost',
        'actual_cost',
        'status',
        'completion_notes',
        'notes',
    ];

    protected $casts = [
        'maintenance_request_id' => 'integer',
        'assigned_to' => 'integer',
        'type' => WorkOrderType::class,
        'status' => WorkOrderStatus::class,
        'scheduled_date' => 'date',
        'started_date' => 'date',
        'completed_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
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
            ->logOnly(['work_order_number', 'type', 'status', 'assigned_to', 'actual_cost'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Relationships
     */
    public function maintenanceRequest(): BelongsTo
    {
        return $this->belongsTo(MaintenanceRequest::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Accessors
     */
    public function getCostVarianceAttribute(): ?float
    {
        if (!$this->estimated_cost || !$this->actual_cost) {
            return null;
        }

        return (float) ($this->actual_cost - $this->estimated_cost);
    }

    public function getCostVariancePercentageAttribute(): ?float
    {
        if (!$this->estimated_cost || !$this->actual_cost) {
            return null;
        }

        return (($this->actual_cost - $this->estimated_cost) / $this->estimated_cost) * 100;
    }

    public function getDurationDaysAttribute(): ?int
    {
        if (!$this->started_date || !$this->completed_date) {
            return null;
        }

        return $this->started_date->diffInDays($this->completed_date);
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
    public function scopePending($query)
    {
        return $query->where('status', WorkOrderStatus::PENDING);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', WorkOrderStatus::SCHEDULED);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', WorkOrderStatus::IN_PROGRESS);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', WorkOrderStatus::COMPLETED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', WorkOrderStatus::CANCELLED);
    }

    public function scopeOnHold($query)
    {
        return $query->where('status', WorkOrderStatus::ON_HOLD);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            WorkOrderStatus::PENDING,
            WorkOrderStatus::SCHEDULED,
            WorkOrderStatus::IN_PROGRESS,
            WorkOrderStatus::ON_HOLD,
        ]);
    }

    public function scopeInternal($query)
    {
        return $query->where('type', WorkOrderType::INTERNAL);
    }

    public function scopeExternal($query)
    {
        return $query->where('type', WorkOrderType::EXTERNAL);
    }

    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    public function scopeOverBudget($query)
    {
        return $query->whereNotNull('estimated_cost')
                     ->whereNotNull('actual_cost')
                     ->whereColumn('actual_cost', '>', 'estimated_cost');
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
            $q->where('work_order_number', 'like', "%{$term}%")
              ->orWhere('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('vendor_name', 'like', "%{$term}%");
        });
    }
}

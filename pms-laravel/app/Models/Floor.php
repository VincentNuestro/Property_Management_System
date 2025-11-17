<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Floor extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'building_id',
        'floor_number',
        'floor_name',
        'description',
    ];

    protected $casts = [
        'building_id' => 'integer',
        'floor_number' => 'integer',
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
            ->logOnly(['building_id', 'floor_number', 'floor_name'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Relationships
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Accessors
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->floor_name ?: "Floor {$this->floor_number}";
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->building->full_name} - {$this->display_name}";
    }

    /**
     * Scopes
     */
    public function scopeForBuilding($query, int $buildingId)
    {
        return $query->where('building_id', $buildingId);
    }

    public function scopeOrderByFloorNumber($query, string $direction = 'asc')
    {
        return $query->orderBy('floor_number', $direction);
    }
}

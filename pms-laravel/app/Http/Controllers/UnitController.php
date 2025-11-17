<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Property;
use App\Models\Building;
use App\Models\Floor;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Enums\UnitType;
use App\Enums\UnitStatus;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Unit::class, 'unit');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Unit::query()->with(['property', 'building', 'floor']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by property
        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'unit_code');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $units = $query->withCount('leaseContracts')->paginate(15);

        return view('units.index', [
            'units' => $units,
            'properties' => Property::orderBy('name')->get(),
            'unitTypes' => UnitType::options(),
            'unitStatuses' => UnitStatus::options(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('units.create', [
            'properties' => Property::orderBy('name')->get(),
            'buildings' => Building::orderBy('name')->get(),
            'floors' => Floor::orderBy('floor_number')->get(),
            'unitTypes' => UnitType::options(),
            'unitStatuses' => UnitStatus::options(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        $unit = Unit::create($request->validated());

        return redirect()
            ->route('units.show', $unit)
            ->with('success', 'Unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        $unit->load(['property', 'building', 'floor', 'leaseContracts.tenant']);

        // Get current lease contract if occupied
        $currentLease = null;
        $occupiedBy = null;
        if ($unit->status === UnitStatus::OCCUPIED) {
            $currentLease = $unit->leaseContracts()
                ->where('status', 'active')
                ->with('tenant')
                ->first();

            if ($currentLease) {
                $occupiedBy = $currentLease->tenant;
            }
        }

        // Get lease history
        $leaseHistory = $unit->leaseContracts()
            ->with('tenant')
            ->orderBy('start_date', 'desc')
            ->get();

        return view('units.show', [
            'unit' => $unit,
            'currentLease' => $currentLease,
            'occupiedBy' => $occupiedBy,
            'leaseHistory' => $leaseHistory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return view('units.edit', [
            'unit' => $unit,
            'properties' => Property::orderBy('name')->get(),
            'buildings' => Building::orderBy('name')->get(),
            'floors' => Floor::orderBy('floor_number')->get(),
            'unitTypes' => UnitType::options(),
            'unitStatuses' => UnitStatus::options(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());

        return redirect()
            ->route('units.show', $unit)
            ->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit deleted successfully.');
    }
}

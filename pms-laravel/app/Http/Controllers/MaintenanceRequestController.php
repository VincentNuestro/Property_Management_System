<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\User;
use App\Http\Requests\StoreMaintenanceRequestRequest;
use App\Http\Requests\UpdateMaintenanceRequestRequest;
use App\Enums\MaintenancePriority;
use App\Enums\MaintenanceRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MaintenanceRequest::class, 'maintenance_request');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['property', 'unit', 'tenant', 'assignedUser']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by property
        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        // Filter by unit
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        // Filter by assigned user
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'request_date');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $maintenanceRequests = $query->paginate(15);

        return view('maintenance-requests.index', [
            'maintenanceRequests' => $maintenanceRequests,
            'properties' => Property::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
            'statuses' => MaintenanceRequestStatus::options(),
            'priorities' => MaintenancePriority::options(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('maintenance-requests.create', [
            'properties' => Property::orderBy('name')->get(),
            'units' => Unit::orderBy('unit_number')->get(),
            'tenants' => Tenant::orderBy('first_name')->get(),
            'users' => User::orderBy('name')->get(),
            'priorities' => MaintenancePriority::options(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceRequestRequest $request)
    {
        $data = $request->validated();

        // Generate request number
        $data['request_number'] = $this->generateRequestNumber();
        $data['request_date'] = now();
        $data['status'] = MaintenanceRequestStatus::SUBMITTED;

        $maintenanceRequest = MaintenanceRequest::create($data);

        return redirect()
            ->route('maintenance-requests.show', $maintenanceRequest)
            ->with('success', 'Maintenance request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->load(['property', 'unit', 'tenant', 'assignedUser', 'workOrders']);

        return view('maintenance-requests.show', [
            'maintenanceRequest' => $maintenanceRequest,
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceRequest $maintenanceRequest)
    {
        // Only allow editing SUBMITTED, ACKNOWLEDGED, ASSIGNED, or IN_PROGRESS requests
        if (!in_array($maintenanceRequest->status, [
            MaintenanceRequestStatus::SUBMITTED,
            MaintenanceRequestStatus::ACKNOWLEDGED,
            MaintenanceRequestStatus::ASSIGNED,
            MaintenanceRequestStatus::IN_PROGRESS
        ])) {
            return redirect()
                ->route('maintenance-requests.show', $maintenanceRequest)
                ->with('error', 'Cannot edit a request with status: ' . $maintenanceRequest->status->label());
        }

        return view('maintenance-requests.edit', [
            'maintenanceRequest' => $maintenanceRequest,
            'properties' => Property::orderBy('name')->get(),
            'units' => Unit::orderBy('unit_number')->get(),
            'tenants' => Tenant::orderBy('first_name')->get(),
            'users' => User::orderBy('name')->get(),
            'priorities' => MaintenancePriority::options(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceRequestRequest $request, MaintenanceRequest $maintenanceRequest)
    {
        // Same edit restrictions as edit method
        if (!in_array($maintenanceRequest->status, [
            MaintenanceRequestStatus::SUBMITTED,
            MaintenanceRequestStatus::ACKNOWLEDGED,
            MaintenanceRequestStatus::ASSIGNED,
            MaintenanceRequestStatus::IN_PROGRESS
        ])) {
            return redirect()
                ->route('maintenance-requests.show', $maintenanceRequest)
                ->with('error', 'Cannot update a request with status: ' . $maintenanceRequest->status->label());
        }

        $maintenanceRequest->update($request->validated());

        return redirect()
            ->route('maintenance-requests.show', $maintenanceRequest)
            ->with('success', 'Maintenance request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        // Only allow deleting SUBMITTED requests
        if ($maintenanceRequest->status !== MaintenanceRequestStatus::SUBMITTED) {
            return redirect()
                ->route('maintenance-requests.index')
                ->with('error', 'Can only delete requests with SUBMITTED status.');
        }

        $maintenanceRequest->delete();

        return redirect()
            ->route('maintenance-requests.index')
            ->with('success', 'Maintenance request deleted successfully.');
    }

    /**
     * Assign maintenance request to a user
     */
    public function assign(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $this->authorize('assign', $maintenanceRequest);

        $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
        ]);

        $maintenanceRequest->update([
            'assigned_to' => $request->assigned_to,
            'status' => MaintenanceRequestStatus::ASSIGNED,
        ]);

        return redirect()
            ->route('maintenance-requests.show', $maintenanceRequest)
            ->with('success', 'Maintenance request assigned successfully.');
    }

    /**
     * Start working on maintenance request
     */
    public function start(MaintenanceRequest $maintenanceRequest)
    {
        $this->authorize('update', $maintenanceRequest);

        if (!in_array($maintenanceRequest->status, [
            MaintenanceRequestStatus::SUBMITTED,
            MaintenanceRequestStatus::ACKNOWLEDGED,
            MaintenanceRequestStatus::ASSIGNED
        ])) {
            return redirect()
                ->route('maintenance-requests.show', $maintenanceRequest)
                ->with('error', 'Cannot start this request. Current status: ' . $maintenanceRequest->status->label());
        }

        $maintenanceRequest->update([
            'status' => MaintenanceRequestStatus::IN_PROGRESS,
        ]);

        return redirect()
            ->route('maintenance-requests.show', $maintenanceRequest)
            ->with('success', 'Maintenance request started.');
    }

    /**
     * Complete maintenance request
     */
    public function complete(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $this->authorize('complete', $maintenanceRequest);

        $request->validate([
            'completion_notes' => ['nullable', 'string'],
        ]);

        $maintenanceRequest->update([
            'status' => MaintenanceRequestStatus::COMPLETED,
            'completed_date' => now(),
            'notes' => $request->completion_notes
                ? ($maintenanceRequest->notes ? $maintenanceRequest->notes . "\n\n" . $request->completion_notes : $request->completion_notes)
                : $maintenanceRequest->notes,
        ]);

        return redirect()
            ->route('maintenance-requests.show', $maintenanceRequest)
            ->with('success', 'Maintenance request marked as completed.');
    }

    /**
     * Cancel maintenance request
     */
    public function cancel(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $this->authorize('update', $maintenanceRequest);

        $request->validate([
            'cancellation_reason' => ['required', 'string'],
        ]);

        $maintenanceRequest->update([
            'status' => MaintenanceRequestStatus::CANCELLED,
            'notes' => $maintenanceRequest->notes
                ? $maintenanceRequest->notes . "\n\n[CANCELLED] " . $request->cancellation_reason
                : "[CANCELLED] " . $request->cancellation_reason,
        ]);

        return redirect()
            ->route('maintenance-requests.show', $maintenanceRequest)
            ->with('success', 'Maintenance request cancelled.');
    }

    /**
     * Redirect to work order create with pre-filled maintenance request
     */
    public function createWorkOrder(MaintenanceRequest $maintenanceRequest)
    {
        $this->authorize('view', $maintenanceRequest);

        return redirect()
            ->route('work-orders.create', ['maintenance_request_id' => $maintenanceRequest->id])
            ->with('info', 'Creating work order for maintenance request: ' . $maintenanceRequest->request_number);
    }

    /**
     * Generate unique request number
     */
    private function generateRequestNumber(): string
    {
        $prefix = config('pms.maintenance_request.request_prefix', 'MR');
        $date = now()->format('Ymd');

        // Get the last request number for today
        $lastRequest = MaintenanceRequest::where('request_number', 'like', "{$prefix}-{$date}-%")
            ->orderBy('request_number', 'desc')
            ->first();

        if ($lastRequest) {
            // Extract the sequence number and increment
            $lastNumber = (int) substr($lastRequest->request_number, -4);
            $sequence = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $sequence = '0001';
        }

        return "{$prefix}-{$date}-{$sequence}";
    }
}

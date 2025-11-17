<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\MaintenanceRequest;
use App\Models\User;
use App\Http\Requests\StoreWorkOrderRequest;
use App\Http\Requests\UpdateWorkOrderRequest;
use App\Enums\WorkOrderType;
use App\Enums\WorkOrderStatus;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(WorkOrder::class, 'work_order');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WorkOrder::with(['maintenanceRequest', 'assignedUser']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by assigned user
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by overdue
        if ($request->boolean('overdue')) {
            $query->overdue();
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $workOrders = $query->paginate(15);

        return view('work-orders.index', [
            'workOrders' => $workOrders,
            'statuses' => WorkOrderStatus::options(),
            'types' => WorkOrderType::options(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $maintenanceRequest = null;
        if ($request->filled('maintenance_request_id')) {
            $maintenanceRequest = MaintenanceRequest::with(['property', 'unit'])->find($request->maintenance_request_id);
        }

        return view('work-orders.create', [
            'types' => WorkOrderType::options(),
            'users' => User::orderBy('name')->get(),
            'maintenanceRequest' => $maintenanceRequest,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkOrderRequest $request)
    {
        $data = $request->validated();

        // Generate work order number
        $data['work_order_number'] = $this->generateWorkOrderNumber();
        $data['status'] = WorkOrderStatus::DRAFT;

        $workOrder = WorkOrder::create($data);

        return redirect()
            ->route('work-orders.show', $workOrder)
            ->with('success', 'Work order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkOrder $workOrder)
    {
        $workOrder->load(['maintenanceRequest.property', 'maintenanceRequest.unit', 'assignedUser']);

        return view('work-orders.show', [
            'workOrder' => $workOrder,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkOrder $workOrder)
    {
        // Only allow editing if status is DRAFT, SCHEDULED, or IN_PROGRESS
        if (!in_array($workOrder->status, [WorkOrderStatus::DRAFT, WorkOrderStatus::SCHEDULED, WorkOrderStatus::IN_PROGRESS])) {
            return redirect()
                ->route('work-orders.show', $workOrder)
                ->with('error', 'This work order cannot be edited in its current status.');
        }

        return view('work-orders.edit', [
            'workOrder' => $workOrder,
            'types' => WorkOrderType::options(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkOrderRequest $request, WorkOrder $workOrder)
    {
        // Only allow updating if status is DRAFT, SCHEDULED, or IN_PROGRESS
        if (!in_array($workOrder->status, [WorkOrderStatus::DRAFT, WorkOrderStatus::SCHEDULED, WorkOrderStatus::IN_PROGRESS])) {
            return redirect()
                ->route('work-orders.show', $workOrder)
                ->with('error', 'This work order cannot be updated in its current status.');
        }

        $workOrder->update($request->validated());

        return redirect()
            ->route('work-orders.show', $workOrder)
            ->with('success', 'Work order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkOrder $workOrder)
    {
        // Only allow deletion if status is DRAFT
        if ($workOrder->status !== WorkOrderStatus::DRAFT) {
            return redirect()
                ->route('work-orders.index')
                ->with('error', 'Only draft work orders can be deleted.');
        }

        $workOrder->delete();

        return redirect()
            ->route('work-orders.index')
            ->with('success', 'Work order deleted successfully.');
    }

    /**
     * Schedule the work order
     */
    public function schedule(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('schedule', $workOrder);

        $request->validate([
            'scheduled_date' => 'required|date',
        ]);

        $workOrder->update([
            'scheduled_date' => $request->scheduled_date,
            'status' => WorkOrderStatus::SCHEDULED,
        ]);

        return redirect()
            ->route('work-orders.show', $workOrder)
            ->with('success', 'Work order scheduled successfully.');
    }

    /**
     * Start the work order
     */
    public function start(WorkOrder $workOrder)
    {
        $this->authorize('start', $workOrder);

        if (!in_array($workOrder->status, [WorkOrderStatus::SCHEDULED, WorkOrderStatus::DRAFT])) {
            return redirect()
                ->route('work-orders.show', $workOrder)
                ->with('error', 'Work order cannot be started in its current status.');
        }

        $workOrder->update([
            'started_date' => now(),
            'status' => WorkOrderStatus::IN_PROGRESS,
        ]);

        return redirect()
            ->route('work-orders.show', $workOrder)
            ->with('success', 'Work order started successfully.');
    }

    /**
     * Complete the work order
     */
    public function complete(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('complete', $workOrder);

        $request->validate([
            'actual_cost' => 'nullable|numeric|min:0',
            'completion_notes' => 'nullable|string',
        ]);

        $workOrder->update([
            'completed_date' => now(),
            'actual_cost' => $request->actual_cost,
            'completion_notes' => $request->completion_notes,
            'status' => WorkOrderStatus::COMPLETED,
        ]);

        return redirect()
            ->route('work-orders.show', $workOrder)
            ->with('success', 'Work order completed successfully.');
    }

    /**
     * Cancel the work order
     */
    public function cancel(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('update', $workOrder);

        $request->validate([
            'cancellation_reason' => 'required|string|max:1000',
        ]);

        $currentNotes = $workOrder->notes ? $workOrder->notes . "\n\n" : '';

        $workOrder->update([
            'status' => WorkOrderStatus::CANCELLED,
            'notes' => $currentNotes . "Cancelled: " . $request->cancellation_reason,
        ]);

        return redirect()
            ->route('work-orders.show', $workOrder)
            ->with('success', 'Work order cancelled.');
    }

    /**
     * Put work order on hold
     */
    public function putOnHold(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('update', $workOrder);

        $request->validate([
            'hold_reason' => 'required|string|max:1000',
        ]);

        $currentNotes = $workOrder->notes ? $workOrder->notes . "\n\n" : '';

        $workOrder->update([
            'status' => WorkOrderStatus::ON_HOLD,
            'notes' => $currentNotes . "Put on hold: " . $request->hold_reason,
        ]);

        return redirect()
            ->route('work-orders.show', $workOrder)
            ->with('success', 'Work order put on hold.');
    }

    /**
     * Generate unique work order number
     */
    private function generateWorkOrderNumber(): string
    {
        $date = date('Ymd');

        $lastWorkOrder = WorkOrder::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastWorkOrder ? (int) substr($lastWorkOrder->work_order_number, -4) + 1 : 1;

        return sprintf('WO-%s-%04d', $date, $sequence);
    }
}

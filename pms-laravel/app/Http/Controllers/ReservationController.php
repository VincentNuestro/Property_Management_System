<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Tenant;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Enums\ReservationStatus;
use App\Enums\UnitStatus;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Reservation::class, 'reservation');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reservation::query()->with(['property', 'unit', 'tenant']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by property
        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        // Filter by unit
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $reservations = $query->paginate(15);

        return view('reservations.index', [
            'reservations' => $reservations,
            'reservationStatuses' => ReservationStatus::options(),
            'properties' => Property::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $properties = Property::where('status', 'active')->orderBy('name')->get();

        // Get available units if property is selected
        $units = collect();
        if ($request->filled('property_id')) {
            $units = Unit::where('property_id', $request->property_id)
                ->where('status', UnitStatus::VACANT)
                ->orderBy('unit_number')
                ->get();
        }

        $tenants = Tenant::where('status', 'active')->orderBy('first_name')->get();

        return view('reservations.create', [
            'properties' => $properties,
            'units' => $units,
            'tenants' => $tenants,
            'selectedPropertyId' => $request->property_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $data = $request->validated();

        // Generate reservation number if not provided
        if (!isset($data['reservation_number'])) {
            $data['reservation_number'] = $this->generateReservationNumber();
        }

        // Set default status
        if (!isset($data['status'])) {
            $data['status'] = ReservationStatus::ACTIVE;
        }

        // Initialize reservation_paid to 0 if not set
        if (!isset($data['reservation_paid'])) {
            $data['reservation_paid'] = 0;
        }

        $reservation = Reservation::create($data);

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('success', 'Reservation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['property', 'unit', 'tenant']);

        return view('reservations.show', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation, Request $request)
    {
        // Only allow editing if status is ACTIVE
        if ($reservation->status !== ReservationStatus::ACTIVE) {
            return redirect()
                ->route('reservations.show', $reservation)
                ->with('error', 'Only active reservations can be edited.');
        }

        $properties = Property::where('status', 'active')->orderBy('name')->get();

        // Get available units for the selected property
        $units = Unit::where('property_id', $reservation->property_id)
            ->where(function($query) use ($reservation) {
                $query->where('status', UnitStatus::VACANT)
                    ->orWhere('id', $reservation->unit_id);
            })
            ->orderBy('unit_number')
            ->get();

        $tenants = Tenant::where('status', 'active')->orderBy('first_name')->get();

        return view('reservations.edit', [
            'reservation' => $reservation,
            'properties' => $properties,
            'units' => $units,
            'tenants' => $tenants,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $reservation->update($request->validated());

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        // Only allow deletion if status is ACTIVE or EXPIRED
        if (!in_array($reservation->status, [ReservationStatus::ACTIVE, ReservationStatus::EXPIRED])) {
            return redirect()
                ->route('reservations.show', $reservation)
                ->with('error', 'Cannot delete reservations that have been converted or cancelled.');
        }

        $reservation->delete();

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }

    /**
     * Confirm a reservation
     */
    public function confirm(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        if ($reservation->status !== ReservationStatus::ACTIVE) {
            return redirect()
                ->route('reservations.show', $reservation)
                ->with('error', 'Only active reservations can be confirmed.');
        }

        // Confirmation logic can be added here if needed
        // For now, we'll just keep the status as ACTIVE since the enum doesn't have CONFIRMED

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('success', 'Reservation confirmed successfully.');
    }

    /**
     * Cancel a reservation
     */
    public function cancel(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        if ($reservation->status === ReservationStatus::CONVERTED) {
            return redirect()
                ->route('reservations.show', $reservation)
                ->with('error', 'Cannot cancel a reservation that has been converted to a lease.');
        }

        $reservation->update(['status' => ReservationStatus::CANCELLED]);

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('success', 'Reservation cancelled successfully.');
    }

    /**
     * Convert reservation to lease application
     */
    public function convertToApplication(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        if ($reservation->status !== ReservationStatus::ACTIVE) {
            return redirect()
                ->route('reservations.show', $reservation)
                ->with('error', 'Only active reservations can be converted to lease applications.');
        }

        // Mark reservation as converted
        $reservation->update(['status' => ReservationStatus::CONVERTED]);

        // Redirect to lease application creation with pre-filled data
        return redirect()
            ->route('lease-applications.create', [
                'reservation_id' => $reservation->id,
                'property_id' => $reservation->property_id,
                'unit_id' => $reservation->unit_id,
                'tenant_id' => $reservation->tenant_id,
            ])
            ->with('success', 'Reservation converted. Please complete the lease application.');
    }

    /**
     * Generate a unique reservation number
     */
    private function generateReservationNumber(): string
    {
        $prefix = 'RES';
        $date = now()->format('Ymd');

        // Get the last reservation number for today
        $lastReservation = Reservation::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastReservation && preg_match('/RES\d{8}-(\d{4})/', $lastReservation->reservation_number, $matches)) {
            $sequence = intval($matches[1]) + 1;
        } else {
            $sequence = 1;
        }

        return sprintf('%s%s-%04d', $prefix, $date, $sequence);
    }

    /**
     * Get units for a property (AJAX endpoint)
     */
    public function getUnits(Request $request)
    {
        $propertyId = $request->get('property_id');

        $units = Unit::where('property_id', $propertyId)
            ->where('status', UnitStatus::VACANT)
            ->orderBy('unit_number')
            ->get(['id', 'unit_number', 'unit_code', 'base_rent']);

        return response()->json($units);
    }
}

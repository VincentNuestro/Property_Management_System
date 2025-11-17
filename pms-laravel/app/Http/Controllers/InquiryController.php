<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Property;
use App\Models\User;
use App\Http\Requests\StoreInquiryRequest;
use App\Http\Requests\UpdateInquiryRequest;
use App\Enums\InquiryStatus;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Inquiry::class, 'inquiry');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inquiry::query()->with(['property', 'assignedUser']);

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

        // Filter by assigned user
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $inquiries = $query->paginate(15);

        return view('inquiries.index', [
            'inquiries' => $inquiries,
            'inquiryStatuses' => InquiryStatus::options(),
            'properties' => Property::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inquiries.create', [
            'properties' => Property::orderBy('name')->get(),
            'inquiryStatuses' => InquiryStatus::options(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInquiryRequest $request)
    {
        $data = $request->validated();

        // Generate inquiry number
        $data['inquiry_number'] = $this->generateInquiryNumber();

        $inquiry = Inquiry::create($data);

        return redirect()
            ->route('inquiries.show', $inquiry)
            ->with('success', 'Inquiry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['property', 'assignedUser']);

        return view('inquiries.show', [
            'inquiry' => $inquiry,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquiry $inquiry)
    {
        // Only allow editing if status is NEW or CONTACTED
        if (!in_array($inquiry->status, [InquiryStatus::NEW, InquiryStatus::CONTACTED])) {
            return redirect()
                ->route('inquiries.show', $inquiry)
                ->with('error', 'This inquiry cannot be edited in its current status.');
        }

        return view('inquiries.edit', [
            'inquiry' => $inquiry,
            'properties' => Property::orderBy('name')->get(),
            'inquiryStatuses' => InquiryStatus::options(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInquiryRequest $request, Inquiry $inquiry)
    {
        // Only allow updating if status is NEW or CONTACTED
        if (!in_array($inquiry->status, [InquiryStatus::NEW, InquiryStatus::CONTACTED])) {
            return redirect()
                ->route('inquiries.show', $inquiry)
                ->with('error', 'This inquiry cannot be updated in its current status.');
        }

        $inquiry->update($request->validated());

        return redirect()
            ->route('inquiries.show', $inquiry)
            ->with('success', 'Inquiry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        // Only allow deleting if status is NEW, LOST, or CANCELLED
        if (!in_array($inquiry->status, [InquiryStatus::NEW, InquiryStatus::LOST])) {
            return redirect()
                ->route('inquiries.show', $inquiry)
                ->with('error', 'This inquiry cannot be deleted in its current status.');
        }

        $inquiry->delete();

        return redirect()
            ->route('inquiries.index')
            ->with('success', 'Inquiry deleted successfully.');
    }

    /**
     * Convert inquiry to reservation
     */
    public function convertToReservation(Inquiry $inquiry)
    {
        $this->authorize('update', $inquiry);

        // Only allow converting if status is QUALIFIED or PROPOSAL_SENT
        if (!in_array($inquiry->status, [InquiryStatus::QUALIFIED, InquiryStatus::PROPOSAL_SENT])) {
            return redirect()
                ->route('inquiries.show', $inquiry)
                ->with('error', 'Only qualified or proposal sent inquiries can be converted to reservations.');
        }

        // TODO: Implement conversion to reservation
        // This would typically create a new Reservation record
        // For now, just update the status to WON
        $inquiry->update(['status' => InquiryStatus::WON]);

        return redirect()
            ->route('inquiries.show', $inquiry)
            ->with('success', 'Inquiry marked as won. Reservation conversion feature coming soon.');
    }

    /**
     * Generate a unique inquiry number
     */
    private function generateInquiryNumber(): string
    {
        $prefix = 'INQ';
        $year = date('Y');
        $month = date('m');

        // Get the last inquiry number for this month
        $lastInquiry = Inquiry::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('inquiry_number', 'desc')
            ->first();

        if ($lastInquiry && preg_match('/INQ-(\d{4})(\d{2})-(\d{4})/', $lastInquiry->inquiry_number, $matches)) {
            $sequence = intval($matches[3]) + 1;
        } else {
            $sequence = 1;
        }

        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }
}

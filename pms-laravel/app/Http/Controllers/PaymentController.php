<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Invoice;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Services\PaymentAllocationService;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentAllocationService $allocationService
    ) {
        $this->authorizeResource(Payment::class, 'payment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['tenant', 'property']);

        // Search by payment number or reference
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by property
        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        // Filter by tenant
        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('payment_date', '<=', $request->date_to);
        }

        // Filter unapplied only
        if ($request->boolean('unapplied_only')) {
            $query->whereRaw('amount > (SELECT COALESCE(SUM(amount_applied), 0) FROM payment_applications WHERE payment_id = payments.id)');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'payment_date');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $payments = $query->paginate(15);

        return view('payments.index', [
            'payments' => $payments,
            'properties' => Property::orderBy('name')->get(),
            'tenants' => Tenant::orderBy('first_name')->get(),
            'statuses' => PaymentStatus::options(),
            'methods' => PaymentMethod::options(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $preselectedInvoice = null;
        if ($request->filled('invoice_id')) {
            $preselectedInvoice = Invoice::find($request->invoice_id);
        }

        return view('payments.create', [
            'properties' => Property::orderBy('name')->get(),
            'tenants' => Tenant::orderBy('first_name')->get(),
            'paymentMethods' => PaymentMethod::options(),
            'preselectedInvoice' => $preselectedInvoice,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $validated = $request->validated();

        // Generate payment number
        $validated['payment_number'] = $this->generatePaymentNumber();

        // Set default status based on payment method
        $paymentMethod = PaymentMethod::from($validated['payment_method']);
        $validated['status'] = $paymentMethod->requiresClearance()
            ? PaymentStatus::PENDING
            : PaymentStatus::CLEARED;

        // Create payment
        $payment = Payment::create($validated);

        // Auto-allocate if requested and payment is cleared
        if ($request->boolean('auto_allocate') && $payment->status === PaymentStatus::CLEARED) {
            $this->allocationService->allocatePayment($payment);
        }

        // Manual allocation to specific invoice if provided
        if ($request->filled('invoice_id') && $payment->status === PaymentStatus::CLEARED) {
            $invoice = Invoice::find($request->invoice_id);
            if ($invoice) {
                $this->allocationService->allocatePayment($payment, collect([$invoice]));
            }
        }

        return redirect()
            ->route('payments.show', $payment)
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load([
            'tenant',
            'property',
            'paymentApplications.invoice',
            'receipt'
        ]);

        return view('payments.show', [
            'payment' => $payment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        // Only pending payments can be edited
        if ($payment->status !== PaymentStatus::PENDING) {
            return redirect()
                ->route('payments.show', $payment)
                ->with('error', 'Only pending payments can be edited.');
        }

        return view('payments.edit', [
            'payment' => $payment,
            'properties' => Property::orderBy('name')->get(),
            'tenants' => Tenant::orderBy('first_name')->get(),
            'paymentMethods' => PaymentMethod::options(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        // Only pending payments can be updated
        if ($payment->status !== PaymentStatus::PENDING) {
            return redirect()
                ->route('payments.show', $payment)
                ->with('error', 'Only pending payments can be updated.');
        }

        $validated = $request->validated();
        $payment->update($validated);

        return redirect()
            ->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage (void).
     */
    public function destroy(Payment $payment)
    {
        // Cannot void if already applied
        if ($payment->amount_applied > 0) {
            return redirect()
                ->route('payments.show', $payment)
                ->with('error', 'Cannot void a payment that has been applied to invoices. Unapply it first.');
        }

        $payment->update(['status' => PaymentStatus::CANCELLED]);
        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment voided successfully.');
    }

    /**
     * Show allocation form
     */
    public function allocate(Payment $payment)
    {
        $this->authorize('allocate', $payment);

        if ($payment->status !== PaymentStatus::CLEARED) {
            return redirect()
                ->route('payments.show', $payment)
                ->with('error', 'Only cleared payments can be allocated.');
        }

        $suggestions = $this->allocationService->getAllocationSuggestions($payment);

        return view('payments.allocate', [
            'payment' => $payment,
            'suggestions' => $suggestions,
        ]);
    }

    /**
     * Store allocation
     */
    public function storeAllocation(Request $request, Payment $payment)
    {
        $this->authorize('allocate', $payment);

        $request->validate([
            'invoices' => ['required', 'array', 'min:1'],
            'invoices.*' => ['required', 'exists:invoices,id'],
        ]);

        // Get selected invoices
        $invoices = Invoice::whereIn('id', $request->invoices)->get();

        // Reallocate payment
        $this->allocationService->reallocatePayment($payment, $invoices);

        return redirect()
            ->route('payments.show', $payment)
            ->with('success', 'Payment allocated successfully.');
    }

    /**
     * Download payment receipt
     */
    public function downloadReceipt(Payment $payment)
    {
        $payment->load([
            'tenant',
            'property',
            'paymentApplications.invoice',
        ]);

        $pdf = Pdf::loadView('payments.receipt', [
            'payment' => $payment,
        ]);

        return $pdf->download("receipt-{$payment->payment_number}.pdf");
    }

    /**
     * Generate unique payment number
     */
    protected function generatePaymentNumber(): string
    {
        $prefix = config('pms.numbering.payment_prefix', 'PAY');
        $year = now()->year;
        $month = now()->format('m');

        // Get last payment number for this month
        $lastPayment = Payment::whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month)
            ->orderBy('payment_number', 'desc')
            ->first();

        if ($lastPayment && preg_match("/{$prefix}-{$year}{$month}-(\\d+)/", $lastPayment->payment_number, $matches)) {
            $sequence = intval($matches[1]) + 1;
        } else {
            $sequence = 1;
        }

        return sprintf('%s-%s%s-%05d', $prefix, $year, $month, $sequence);
    }
}

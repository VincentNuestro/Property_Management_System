<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\LeaseContract;
use App\Models\ChargeType;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Services\BillingService;
use App\Enums\InvoiceStatus;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct(
        protected BillingService $billingService
    ) {
        $this->authorizeResource(Invoice::class, 'invoice');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['tenant', 'property', 'leaseContract']);

        // Search by invoice number or tenant name
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

        // Filter by tenant
        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('invoice_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('invoice_date', '<=', $request->date_to);
        }

        // Filter overdue invoices
        if ($request->boolean('overdue_only')) {
            $query->overdue();
        }

        // Sort
        $sortBy = $request->get('sort_by', 'invoice_date');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $invoices = $query->paginate(15);

        return view('invoices.index', [
            'invoices' => $invoices,
            'properties' => Property::orderBy('name')->get(),
            'tenants' => Tenant::orderBy('first_name')->get(),
            'statuses' => InvoiceStatus::options(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('invoices.create', [
            'properties' => Property::orderBy('name')->get(),
            'tenants' => Tenant::orderBy('first_name')->get(),
            'leaseContracts' => LeaseContract::active()->with(['tenant', 'property'])->get(),
            'chargeTypes' => ChargeType::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $validated = $request->validated();

        // Generate invoice number
        $validated['invoice_number'] = $this->generateInvoiceNumber();
        $validated['status'] = InvoiceStatus::DRAFT;
        $validated['amount_paid'] = 0;

        // Create invoice
        $invoice = Invoice::create($validated);

        // Add line items
        if ($request->has('line_items')) {
            $subtotal = 0;
            $taxAmount = 0;

            foreach ($request->line_items as $item) {
                $amount = $item['quantity'] * $item['unit_price'];
                $itemTaxAmount = 0;

                if ($item['is_taxable'] ?? false) {
                    $taxRate = $item['tax_rate'] ?? 0;
                    $itemTaxAmount = $amount * ($taxRate / 100);
                }

                $invoice->lineItems()->create([
                    'charge_type_id' => $item['charge_type_id'],
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'amount' => $amount,
                    'is_taxable' => $item['is_taxable'] ?? false,
                    'tax_rate' => $item['tax_rate'] ?? 0,
                    'tax_amount' => $itemTaxAmount,
                ]);

                $subtotal += $amount;
                $taxAmount += $itemTaxAmount;
            }

            // Update invoice totals
            $invoice->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $subtotal + $taxAmount,
            ]);
        }

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load([
            'tenant',
            'property',
            'leaseContract',
            'lineItems.chargeType',
            'penalties',
            'paymentApplications.payment'
        ]);

        return view('invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        // Only draft invoices can be edited
        if ($invoice->status !== InvoiceStatus::DRAFT) {
            return redirect()
                ->route('invoices.show', $invoice)
                ->with('error', 'Only draft invoices can be edited.');
        }

        $invoice->load('lineItems');

        return view('invoices.edit', [
            'invoice' => $invoice,
            'properties' => Property::orderBy('name')->get(),
            'tenants' => Tenant::orderBy('first_name')->get(),
            'leaseContracts' => LeaseContract::active()->with(['tenant', 'property'])->get(),
            'chargeTypes' => ChargeType::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        // Only draft invoices can be updated
        if ($invoice->status !== InvoiceStatus::DRAFT) {
            return redirect()
                ->route('invoices.show', $invoice)
                ->with('error', 'Only draft invoices can be updated.');
        }

        $validated = $request->validated();
        $invoice->update($validated);

        // Update line items
        if ($request->has('line_items')) {
            // Delete existing line items
            $invoice->lineItems()->delete();

            $subtotal = 0;
            $taxAmount = 0;

            foreach ($request->line_items as $item) {
                $amount = $item['quantity'] * $item['unit_price'];
                $itemTaxAmount = 0;

                if ($item['is_taxable'] ?? false) {
                    $taxRate = $item['tax_rate'] ?? 0;
                    $itemTaxAmount = $amount * ($taxRate / 100);
                }

                $invoice->lineItems()->create([
                    'charge_type_id' => $item['charge_type_id'],
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'amount' => $amount,
                    'is_taxable' => $item['is_taxable'] ?? false,
                    'tax_rate' => $item['tax_rate'] ?? 0,
                    'tax_amount' => $itemTaxAmount,
                ]);

                $subtotal += $amount;
                $taxAmount += $itemTaxAmount;
            }

            // Update invoice totals
            $invoice->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $subtotal + $taxAmount,
            ]);
        }

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage (void).
     */
    public function destroy(Invoice $invoice)
    {
        // Void the invoice instead of deleting
        if ($invoice->amount_paid > 0) {
            return redirect()
                ->route('invoices.show', $invoice)
                ->with('error', 'Cannot void an invoice that has payments applied.');
        }

        $invoice->update(['status' => InvoiceStatus::CANCELLED]);
        $invoice->delete();

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice voided successfully.');
    }

    /**
     * Mark invoice as sent
     */
    public function send(Invoice $invoice)
    {
        $this->authorize('send', $invoice);

        if ($invoice->status !== InvoiceStatus::DRAFT) {
            return redirect()
                ->route('invoices.show', $invoice)
                ->with('error', 'Only draft invoices can be sent.');
        }

        $invoice->update(['status' => InvoiceStatus::ISSUED]);

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Invoice sent successfully.');
    }

    /**
     * Void an invoice
     */
    public function void(Invoice $invoice)
    {
        $this->authorize('void', $invoice);

        if ($invoice->amount_paid > 0) {
            return redirect()
                ->route('invoices.show', $invoice)
                ->with('error', 'Cannot void an invoice that has payments applied.');
        }

        $invoice->update(['status' => InvoiceStatus::CANCELLED]);

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Invoice voided successfully.');
    }

    /**
     * Download invoice as PDF
     */
    public function downloadPDF(Invoice $invoice)
    {
        $invoice->load([
            'tenant',
            'property',
            'leaseContract',
            'lineItems.chargeType',
            'penalties',
        ]);

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
        ]);

        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }

    /**
     * Generate unique invoice number
     */
    protected function generateInvoiceNumber(): string
    {
        $prefix = config('pms.numbering.invoice_prefix', 'INV');
        $year = now()->year;
        $month = now()->format('m');

        // Get last invoice number for this month
        $lastInvoice = Invoice::whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $month)
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice && preg_match("/{$prefix}-{$year}{$month}-(\\d+)/", $lastInvoice->invoice_number, $matches)) {
            $sequence = intval($matches[1]) + 1;
        } else {
            $sequence = 1;
        }

        return sprintf('%s-%s%s-%05d', $prefix, $year, $month, $sequence);
    }
}

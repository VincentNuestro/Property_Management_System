<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice') }} - {{ $invoice->invoice_number }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $invoice)
                    <a href="{{ route('invoices.edit', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('invoices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Back to Invoices
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Invoice Header -->
            <x-card>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Information</h3>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Invoice Number:</dt>
                                    <dd class="text-sm text-gray-900">{{ $invoice->invoice_number }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Status:</dt>
                                    <dd>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $invoice->status->color() }}-100 text-{{ $invoice->status->color() }}-800">
                                            {{ $invoice->status->label() }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Invoice Date:</dt>
                                    <dd class="text-sm text-gray-900">{{ $invoice->invoice_date->format('M d, Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Due Date:</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $invoice->due_date->format('M d, Y') }}
                                        @if($invoice->is_overdue)
                                            <span class="ml-1 text-red-600 font-semibold">({{ $invoice->days_overdue }} days overdue)</span>
                                        @endif
                                    </dd>
                                </div>
                                @if($invoice->period_start && $invoice->period_end)
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Billing Period:</dt>
                                        <dd class="text-sm text-gray-900">
                                            {{ $invoice->period_start->format('M d, Y') }} - {{ $invoice->period_end->format('M d, Y') }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        @if($invoice->notes)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Notes:</h4>
                                <p class="text-sm text-gray-900">{{ $invoice->notes }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tenant & Property</h3>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Tenant:</dt>
                                    <dd class="text-sm text-gray-900">{{ $invoice->tenant->first_name }} {{ $invoice->tenant->last_name }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Property:</dt>
                                    <dd class="text-sm text-gray-900">{{ $invoice->property->name }}</dd>
                                </div>
                                @if($invoice->leaseContract)
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Contract:</dt>
                                        <dd class="text-sm text-gray-900">{{ $invoice->leaseContract->contract_number }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Amounts</h3>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Subtotal:</dt>
                                    <dd class="text-sm text-gray-900">${{ number_format($invoice->subtotal, 2) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Tax:</dt>
                                    <dd class="text-sm text-gray-900">${{ number_format($invoice->tax_amount, 2) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Total Amount:</dt>
                                    <dd class="text-sm font-bold text-gray-900">${{ number_format($invoice->total_amount, 2) }}</dd>
                                </div>
                                @if($invoice->total_penalties > 0)
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Penalties:</dt>
                                        <dd class="text-sm font-semibold text-red-600">${{ number_format($invoice->total_penalties, 2) }}</dd>
                                    </div>
                                    <div class="flex justify-between border-t pt-2">
                                        <dt class="text-sm font-medium text-gray-500">Total with Penalties:</dt>
                                        <dd class="text-sm font-bold text-gray-900">${{ number_format($invoice->total_with_penalties, 2) }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between border-t pt-2">
                                    <dt class="text-sm font-medium text-gray-500">Amount Paid:</dt>
                                    <dd class="text-sm font-semibold text-green-600">${{ number_format($invoice->amount_paid, 2) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-lg font-bold text-gray-900">Balance Due:</dt>
                                    <dd class="text-lg font-bold {{ $invoice->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                        ${{ number_format($invoice->balance, 2) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Line Items -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Line Items</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Charge Type</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Tax</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($invoice->lineItems as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item->description }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->chargeType->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-right">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-right">${{ number_format($item->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-right">
                                        @if($item->is_taxable)
                                            ${{ number_format($item->tax_amount, 2) }} ({{ $item->tax_rate }}%)
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                        ${{ number_format($item->amount + $item->tax_amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            <!-- Penalties -->
            @if($invoice->penalties->count() > 0)
                <x-card>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Penalties</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Waived</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($invoice->penalties as $penalty)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $penalty->penalty_type }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $penalty->description }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $penalty->applied_date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-red-600 text-right">
                                            ${{ number_format($penalty->penalty_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($penalty->is_waived)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Waived
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Active
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @endif

            <!-- Payments Applied -->
            @if($invoice->paymentApplications->count() > 0)
                <x-card>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payments Applied</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Applied</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($invoice->paymentApplications as $application)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <a href="{{ route('payments.show', $application->payment) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ $application->payment->payment_number }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $application->payment->payment_date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $application->payment->payment_method->label() }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $application->applied_date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-green-600 text-right">
                                            ${{ number_format($application->amount_applied, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @endif

            <!-- Actions -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="flex flex-wrap gap-3">
                    @can('send', $invoice)
                        <form method="POST" action="{{ route('invoices.send', $invoice) }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Send Invoice
                            </button>
                        </form>
                    @endcan

                    @can('void', $invoice)
                        <form method="POST" action="{{ route('invoices.void', $invoice) }}" class="inline" onsubmit="return confirm('Are you sure you want to void this invoice?');">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Void Invoice
                            </button>
                        </form>
                    @endcan

                    @if($invoice->balance > 0)
                        <a href="{{ route('payments.create', ['invoice_id' => $invoice->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            Add Payment
                        </a>
                    @endif

                    <a href="{{ route('invoices.pdf', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Download PDF
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>

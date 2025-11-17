<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payment') }} - {{ $payment->payment_number }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $payment)
                    <a href="{{ route('payments.edit', $payment) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Back to Payments
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Payment Header -->
            <x-card>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Payment Number:</dt>
                                    <dd class="text-sm text-gray-900">{{ $payment->payment_number }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Status:</dt>
                                    <dd>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $payment->status->color() }}-100 text-{{ $payment->status->color() }}-800">
                                            {{ $payment->status->label() }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Payment Date:</dt>
                                    <dd class="text-sm text-gray-900">{{ $payment->payment_date->format('M d, Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Payment Method:</dt>
                                    <dd class="text-sm text-gray-900">{{ $payment->payment_method->label() }}</dd>
                                </div>
                                @if($payment->reference_number)
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Reference Number:</dt>
                                        <dd class="text-sm text-gray-900">{{ $payment->reference_number }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        @if($payment->check_number || $payment->bank_name)
                            <div class="border-t pt-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Payment Details:</h4>
                                <dl class="space-y-1">
                                    @if($payment->check_number)
                                        <div class="flex justify-between">
                                            <dt class="text-sm font-medium text-gray-500">Check Number:</dt>
                                            <dd class="text-sm text-gray-900">{{ $payment->check_number }}</dd>
                                        </div>
                                    @endif
                                    @if($payment->check_date)
                                        <div class="flex justify-between">
                                            <dt class="text-sm font-medium text-gray-500">Check Date:</dt>
                                            <dd class="text-sm text-gray-900">{{ $payment->check_date->format('M d, Y') }}</dd>
                                        </div>
                                    @endif
                                    @if($payment->bank_name)
                                        <div class="flex justify-between">
                                            <dt class="text-sm font-medium text-gray-500">Bank Name:</dt>
                                            <dd class="text-sm text-gray-900">{{ $payment->bank_name }}</dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>
                        @endif

                        @if($payment->notes)
                            <div class="border-t pt-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Notes:</h4>
                                <p class="text-sm text-gray-900">{{ $payment->notes }}</p>
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
                                    <dd class="text-sm text-gray-900">{{ $payment->tenant->first_name }} {{ $payment->tenant->last_name }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Property:</dt>
                                    <dd class="text-sm text-gray-900">{{ $payment->property->name }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Amounts</h3>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Payment Amount:</dt>
                                    <dd class="text-sm font-bold text-gray-900">${{ number_format($payment->amount, 2) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Amount Applied:</dt>
                                    <dd class="text-sm font-semibold text-green-600">${{ number_format($payment->amount_applied, 2) }}</dd>
                                </div>
                                <div class="flex justify-between border-t pt-2">
                                    <dt class="text-lg font-bold text-gray-900">Unapplied Amount:</dt>
                                    <dd class="text-lg font-bold {{ $payment->unapplied_amount > 0 ? 'text-orange-600' : 'text-green-600' }}">
                                        ${{ number_format($payment->unapplied_amount, 2) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Allocations -->
            @if($payment->paymentApplications->count() > 0)
                <x-card>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Allocations to Invoices</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice Total</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Applied</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($payment->paymentApplications as $application)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <a href="{{ route('invoices.show', $application->invoice) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ $application->invoice->invoice_number }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $application->invoice->invoice_date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $application->invoice->due_date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $application->applied_date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 text-right">${{ number_format($application->invoice->total_amount, 2) }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-green-600 text-right">
                                            ${{ number_format($application->amount_applied, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $application->invoice->status->color() }}-100 text-{{ $application->invoice->status->color() }}-800">
                                                {{ $application->invoice->status->label() }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @else
                <x-card>
                    <div class="text-center py-6">
                        <p class="text-gray-500">No allocations yet. This payment has not been applied to any invoices.</p>
                        @can('allocate', $payment)
                            @if($payment->unapplied_amount > 0)
                                <a href="{{ route('payments.allocate', $payment) }}" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Allocate Payment
                                </a>
                            @endif
                        @endcan
                    </div>
                </x-card>
            @endif

            <!-- Actions -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="flex flex-wrap gap-3">
                    @can('allocate', $payment)
                        @if($payment->unapplied_amount > 0)
                            <a href="{{ route('payments.allocate', $payment) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                {{ $payment->paymentApplications->count() > 0 ? 'Reallocate Payment' : 'Allocate Payment' }}
                            </a>
                        @endif
                    @endcan

                    <a href="{{ route('payments.receipt', $payment) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Download Receipt
                    </a>

                    @can('void', $payment)
                        <form method="POST" action="{{ route('payments.destroy', $payment) }}" class="inline" onsubmit="return confirm('Are you sure you want to void this payment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Void Payment
                            </button>
                        </form>
                    @endcan
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>

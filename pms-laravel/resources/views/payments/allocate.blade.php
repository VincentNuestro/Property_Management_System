<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Allocate Payment') }} - {{ $payment->payment_number }}
            </h2>
            <a href="{{ route('payments.show', $payment) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Back to Payment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Payment Summary -->
            <x-card>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Payment Amount</h3>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($payment->amount, 2) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Already Applied</h3>
                        <p class="text-2xl font-bold text-green-600">${{ number_format($payment->amount_applied, 2) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Available to Allocate</h3>
                        <p class="text-2xl font-bold text-orange-600">${{ number_format($payment->unapplied_amount, 2) }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Allocation Form -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Invoices to Apply Payment</h3>

                @if($suggestions->count() > 0)
                    <form method="POST" action="{{ route('payments.store-allocation', $payment) }}" id="allocationForm">
                        @csrf

                        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <strong>Suggested Allocation (FIFO - Oldest First):</strong> The system has automatically suggested invoices based on due date. You can modify the selection below.
                            </p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left">
                                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600" onchange="toggleAllInvoices()">
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Suggested Amount</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($suggestions as $suggestion)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input
                                                    type="checkbox"
                                                    name="invoices[]"
                                                    value="{{ $suggestion['invoice']->id }}"
                                                    class="invoice-checkbox rounded border-gray-300 text-indigo-600"
                                                    {{ $suggestion['suggested_amount'] > 0 ? 'checked' : '' }}
                                                >
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <a href="{{ route('invoices.show', $suggestion['invoice']) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $suggestion['invoice']->invoice_number }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $suggestion['invoice']->invoice_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $suggestion['invoice']->due_date->format('M d, Y') }}
                                                @if($suggestion['invoice']->is_overdue)
                                                    <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                        {{ $suggestion['invoice']->days_overdue }}d overdue
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                                ${{ number_format($suggestion['invoice']->total_amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600 text-right">
                                                ${{ number_format($suggestion['invoice']->balance, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 text-right">
                                                ${{ number_format($suggestion['suggested_amount'], 2) }}
                                                @if($suggestion['will_pay_in_full'])
                                                    <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                        Full
                                                    </span>
                                                @else
                                                    <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Partial
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $suggestion['invoice']->status->color() }}-100 text-{{ $suggestion['invoice']->status->color() }}-800">
                                                    {{ $suggestion['invoice']->status->label() }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-between items-center">
                            <div class="text-sm text-gray-600">
                                <p><strong>Note:</strong> Payment will be allocated to selected invoices in FIFO (First In, First Out) order based on due date.</p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('payments.show', $payment) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                    Cancel
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Allocate Payment
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">No unpaid invoices found for this tenant.</p>
                        <a href="{{ route('payments.show', $payment) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Back to Payment
                        </a>
                    </div>
                @endif
            </x-card>
        </div>
    </div>

    @if($suggestions->count() > 0)
        @push('scripts')
        <script>
            function toggleAllInvoices() {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.invoice-checkbox');

                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
            }
        </script>
        @endpush
    @endif
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lease Contract') }} - {{ $leaseContract->contract_number }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    <x-badge :color="$leaseContract->status->color()">
                        {{ $leaseContract->status->label() }}
                    </x-badge>
                </p>
            </div>
            <div class="flex space-x-2">
                @can('lease_contracts.edit')
                    @if($leaseContract->status === App\Enums\LeaseStatus::DRAFT)
                        <a href="{{ route('lease-contracts.edit', $leaseContract) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Edit
                        </a>
                        <form action="{{ route('lease-contracts.activate', $leaseContract) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700" onclick="return confirm('Are you sure you want to activate this contract?')">
                                Activate Contract
                            </button>
                        </form>
                    @endif

                    @if($leaseContract->status === App\Enums\LeaseStatus::ACTIVE)
                        <button type="button" onclick="document.getElementById('terminateModal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                            Terminate Contract
                        </button>
                    @endif

                    @if(in_array($leaseContract->status, [App\Enums\LeaseStatus::ACTIVE, App\Enums\LeaseStatus::EXPIRED]))
                        <button type="button" onclick="document.getElementById('renewModal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Renew Contract
                        </button>
                    @endif
                @endcan

                <a href="{{ route('lease-contracts.download', $leaseContract) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Download PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Contract Details -->
            <x-card title="Contract Details">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Contract Number</h4>
                        <p class="mt-1 text-sm text-gray-900 font-medium">{{ $leaseContract->contract_number }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Contract Date</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseContract->contract_date?->format('M d, Y') ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Billing Cycle</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseContract->billing_cycle->label() }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Start Date</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseContract->start_date->format('M d, Y') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">End Date</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseContract->end_date->format('M d, Y') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Days Remaining</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($leaseContract->days_remaining !== null)
                                <span class="{{ $leaseContract->days_remaining <= 30 ? 'text-red-600 font-medium' : '' }}">
                                    {{ $leaseContract->days_remaining }} days
                                </span>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    @if($leaseContract->terminated_date)
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-medium text-gray-500">Terminated Date</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $leaseContract->terminated_date->format('M d, Y') }}</p>
                        </div>

                        <div class="md:col-span-3">
                            <h4 class="text-sm font-medium text-gray-500">Termination Reason</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $leaseContract->termination_reason }}</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Tenant Information -->
            <x-card title="Tenant Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Tenant Name</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="{{ route('tenants.show', $leaseContract->tenant) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                {{ $leaseContract->tenant->first_name }} {{ $leaseContract->tenant->last_name }}
                            </a>
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Email</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseContract->tenant->email }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseContract->tenant->phone ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Type</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseContract->tenant->type->label() }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Property and Units -->
            <x-card title="Property and Units">
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-500">Property</h4>
                    <p class="mt-1 text-sm text-gray-900">
                        <a href="{{ route('properties.show', $leaseContract->property) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                            {{ $leaseContract->property->name }}
                        </a>
                    </p>
                </div>

                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Leased Units</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Number</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Monthly Rent</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Association Dues</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($leaseContract->units as $unit)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $unit->unit_code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $unit->unit_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            ₱{{ number_format($unit->pivot->monthly_rent, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            ₱{{ number_format($unit->pivot->association_dues, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                            ₱{{ number_format($unit->pivot->monthly_rent + $unit->pivot->association_dues, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-card>

            <!-- Financial Summary -->
            <x-card title="Financial Summary">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-indigo-600">₱{{ number_format($financialSummary['total_monthly_rent'], 2) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Monthly Rent</p>
                    </div>

                    <div class="text-center">
                        <p class="text-2xl font-bold text-blue-600">₱{{ number_format($financialSummary['total_association_dues'], 2) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Association Dues</p>
                    </div>

                    <div class="text-center">
                        <p class="text-2xl font-bold text-green-600">₱{{ number_format($financialSummary['total_monthly_charges'], 2) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Total Monthly</p>
                    </div>

                    <div class="text-center">
                        <p class="text-2xl font-bold text-purple-600">₱{{ number_format($financialSummary['security_deposit'], 2) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Security Deposit</p>
                    </div>

                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-600">{{ $leaseContract->advance_rent_months ?? 0 }}</p>
                        <p class="mt-1 text-sm text-gray-500">Advance Months</p>
                    </div>

                    @if($leaseContract->escalation_rate)
                        <div class="text-center">
                            <p class="text-2xl font-bold text-yellow-600">{{ $leaseContract->escalation_rate }}%</p>
                            <p class="mt-1 text-sm text-gray-500">Escalation Rate</p>
                        </div>
                    @endif

                    <div class="text-center">
                        <p class="text-2xl font-bold text-red-600">₱{{ number_format($financialSummary['total_balance'], 2) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Outstanding Balance</p>
                    </div>

                    <div class="text-center">
                        <p class="text-2xl font-bold text-teal-600">₱{{ number_format($financialSummary['total_paid'], 2) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Total Paid</p>
                    </div>
                </div>
            </x-card>

            <!-- Contract Charges -->
            @if($leaseContract->contractCharges->count() > 0)
                <x-card title="Contract Charges">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Charge Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Recurring</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Effective Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($leaseContract->contractCharges as $charge)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $charge->chargeType->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $charge->description ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            ₱{{ number_format($charge->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($charge->is_recurring)
                                                <x-badge color="blue">Yes</x-badge>
                                            @else
                                                <x-badge color="gray">No</x-badge>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $charge->effective_date->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @endif

            <!-- Invoices and Payments -->
            @if($leaseContract->invoices->count() > 0)
                <x-card title="Invoices and Payments">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Paid</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Balance</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($leaseContract->invoices as $invoice)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $invoice->invoice_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $invoice->due_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            ₱{{ number_format($invoice->total_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            ₱{{ number_format($invoice->paid_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            ₱{{ number_format($invoice->balance_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <x-badge :color="$invoice->status->color()">
                                                {{ $invoice->status->label() }}
                                            </x-badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @endif

            <!-- Notes -->
            @if($leaseContract->notes)
                <x-card title="Notes">
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $leaseContract->notes }}</p>
                </x-card>
            @endif
        </div>
    </div>

    <!-- Terminate Contract Modal -->
    <div id="terminateModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Terminate Contract</h3>
            <form action="{{ route('lease-contracts.terminate', $leaseContract) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="terminated_date" class="block text-sm font-medium text-gray-700 mb-1">Termination Date</label>
                        <input type="date" name="terminated_date" id="terminated_date" value="{{ date('Y-m-d') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="termination_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                        <textarea name="termination_reason" id="termination_reason" rows="3" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter reason for termination..."></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('terminateModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700">
                        Terminate Contract
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Renew Contract Modal -->
    <div id="renewModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Renew Contract</h3>
            <form action="{{ route('lease-contracts.renew', $leaseContract) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">New Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $leaseContract->end_date->addDay()->format('Y-m-d') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">New End Date</label>
                        <input type="date" name="end_date" id="end_date" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="escalation_rate" class="block text-sm font-medium text-gray-700 mb-1">Escalation Rate (%)</label>
                        <input type="number" name="escalation_rate" id="escalation_rate" step="0.01" min="0" max="100" value="{{ $leaseContract->escalation_rate }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Leave blank for no escalation</p>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('renewModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                        Create Renewal
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

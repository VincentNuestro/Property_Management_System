<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $tenant->full_name }}
            </h2>
            @can('tenants.edit')
                <a href="{{ route('tenants.edit', $tenant) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Tenant
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Tenant Details -->
            <x-card title="Tenant Details">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Type</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $tenant->tenant_type->label() }}</p>
                    </div>

                    @if($tenant->tenant_type === \App\Enums\TenantType::INDIVIDUAL)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Full Name</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $tenant->full_name }}</p>
                        </div>

                        @if($tenant->date_of_birth)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Date of Birth</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $tenant->date_of_birth->format('F d, Y') }}</p>
                            </div>
                        @endif

                        @if($tenant->nationality)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Nationality</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $tenant->nationality }}</p>
                            </div>
                        @endif

                        @if($tenant->government_id_type)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">ID Type</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $tenant->government_id_type }}</p>
                            </div>
                        @endif

                        @if($tenant->government_id_number)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">ID Number</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $tenant->government_id_number }}</p>
                            </div>
                        @endif
                    @else
                        @if($tenant->company)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Company</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    <a href="{{ route('companies.show', $tenant->company) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $tenant->company->display_name }}
                                    </a>
                                </p>
                            </div>
                        @endif
                    @endif

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-1">
                            <x-badge :color="$tenant->status->color()">
                                {{ $tenant->status->label() }}
                            </x-badge>
                        </p>
                    </div>
                </div>
            </x-card>

            <!-- Contact Information -->
            <x-card title="Contact Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($tenant->email)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Email</h4>
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $tenant->email }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $tenant->email }}
                                </a>
                            </p>
                        </div>
                    @endif

                    @if($tenant->phone)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $tenant->phone }}</p>
                        </div>
                    @endif

                    @if($tenant->mobile)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Mobile</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $tenant->mobile }}</p>
                        </div>
                    @endif

                    @if($tenant->full_address)
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-medium text-gray-500">Address</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $tenant->full_address }}</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Notes -->
            @if($tenant->notes)
                <x-card title="Notes">
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $tenant->notes }}</p>
                </x-card>
            @endif

            <!-- Current Active Leases -->
            @if($activeLeases->count() > 0)
                <x-card title="Current Active Leases">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Property
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Start Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        End Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Monthly Rent
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($activeLeases as $lease)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lease->unit?->property?->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lease->unit?->unit_number ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lease->start_date?->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lease->end_date?->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ money($lease->monthly_rent, 'PHP') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @endif

            <!-- Lease History -->
            @if($leaseHistory->count() > 0)
                <x-card title="Lease History">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Property
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Period
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($leaseHistory as $lease)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lease->unit?->property?->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lease->unit?->unit_number ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lease->start_date?->format('M d, Y') }} - {{ $lease->end_date?->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-badge :color="$lease->status->color()">
                                                {{ $lease->status->label() }}
                                            </x-badge>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @endif

            <!-- Recent Invoices -->
            @if($recentInvoices->count() > 0)
                <x-card title="Recent Invoices">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Invoice #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentInvoices as $invoice)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $invoice->invoice_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $invoice->leaseContract?->unit?->unit_number ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $invoice->invoice_date?->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ money($invoice->total_amount, 'PHP') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-badge :color="$invoice->status->color()">
                                                {{ $invoice->status->label() }}
                                            </x-badge>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @endif

            <!-- Recent Payments -->
            @if($recentPayments->count() > 0)
                <x-card title="Recent Payments">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reference #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Method
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentPayments as $payment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $payment->reference_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $payment->payment_date?->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $payment->payment_method->label() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ money($payment->amount, 'PHP') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-badge :color="$payment->status->color()">
                                                {{ $payment->status->label() }}
                                            </x-badge>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @endif
        </div>
    </div>
</x-app-layout>

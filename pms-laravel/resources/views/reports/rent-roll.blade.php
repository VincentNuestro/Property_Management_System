<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rent Roll Report') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Reports
                </a>
                <a href="{{ route('reports.rent-roll.export', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Export to Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <x-card class="mb-6">
                <form method="GET" action="{{ route('reports.rent-roll') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Property Filter -->
                        <div>
                            <label for="property_id" class="block text-sm font-medium text-gray-700 mb-1">Property</label>
                            <select name="property_id" id="property_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Properties</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}" {{ $selectedProperty == $property->id ? 'selected' : '' }}>
                                        {{ $property->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="active" {{ $selectedStatus === 'active' ? 'selected' : '' }}>Active Only</option>
                                <option value="all" {{ $selectedStatus === 'all' ? 'selected' : '' }}>All Leases</option>
                            </select>
                        </div>

                        <!-- As of Date -->
                        <div>
                            <label for="as_of_date" class="block text-sm font-medium text-gray-700 mb-1">As of Date</label>
                            <input
                                type="date"
                                name="as_of_date"
                                id="as_of_date"
                                value="{{ $asOfDate->format('Y-m-d') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <!-- Submit -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Apply Filters
                            </button>
                        </div>
                    </div>

                    @if(request()->hasAny(['property_id', 'status', 'as_of_date']))
                        <div>
                            <a href="{{ route('reports.rent-roll') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </x-card>

            <!-- Rent Roll Table -->
            <x-card>
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Rent Roll as of {{ $asOfDate->format('F d, Y') }}</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Property
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contract #
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tenant
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unit(s)
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Start Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    End Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Monthly Rent
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dues
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $currentProperty = null;
                                $propertyTotal = 0;
                            @endphp

                            @forelse($rentRollData as $index => $data)
                                @if($currentProperty !== $data['lease']->property_id)
                                    @if($currentProperty !== null)
                                        <tr class="bg-gray-100 font-semibold">
                                            <td colspan="8" class="px-6 py-3 text-right text-sm">
                                                Property Subtotal:
                                            </td>
                                            <td class="px-6 py-3 text-right text-sm">
                                                {{ config('pms.currency.symbol') }}{{ number_format($propertyTotal, 2) }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    @php
                                        $currentProperty = $data['lease']->property_id;
                                        $propertyTotal = 0;
                                    @endphp
                                @endif

                                @php
                                    $propertyTotal += $data['total_charges'];
                                @endphp

                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $data['lease']->property->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $data['lease']->contract_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($data['lease']->tenant->company)
                                            {{ $data['lease']->tenant->company->name }}
                                        @else
                                            {{ $data['lease']->tenant->first_name }} {{ $data['lease']->tenant->last_name }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $data['lease']->units->pluck('unit_number')->implode(', ') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $data['lease']->start_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $data['lease']->end_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        {{ config('pms.currency.symbol') }}{{ number_format($data['monthly_rent'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        {{ config('pms.currency.symbol') }}{{ number_format($data['association_dues'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                        {{ config('pms.currency.symbol') }}{{ number_format($data['total_charges'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge :color="$data['lease']->status->value === 'active' ? 'green' : 'gray'">
                                            {{ $data['lease']->status->label() }}
                                        </x-badge>
                                    </td>
                                </tr>

                                @if($loop->last)
                                    <tr class="bg-gray-100 font-semibold">
                                        <td colspan="8" class="px-6 py-3 text-right text-sm">
                                            Property Subtotal:
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm">
                                            {{ config('pms.currency.symbol') }}{{ number_format($propertyTotal, 2) }}
                                        </td>
                                        <td></td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No lease contracts found with the selected filters.
                                    </td>
                                </tr>
                            @endforelse

                            @if(count($rentRollData) > 0)
                                <tr class="bg-indigo-50 font-bold">
                                    <td colspan="8" class="px-6 py-4 text-right text-sm">
                                        Grand Total:
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        {{ config('pms.currency.symbol') }}{{ number_format($grandTotal, 2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>

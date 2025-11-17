<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Accounts Receivable Aging Report') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Reports
                </a>
                <a href="{{ route('reports.aging.export', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Export to Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <x-card class="mb-6">
                <form method="GET" action="{{ route('reports.aging') }}" class="space-y-4">
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

                        <!-- Tenant Filter (optional - can be left empty) -->
                        <div>
                            <label for="tenant_id" class="block text-sm font-medium text-gray-700 mb-1">Tenant (Optional)</label>
                            <input
                                type="number"
                                name="tenant_id"
                                id="tenant_id"
                                value="{{ $selectedTenant }}"
                                placeholder="Tenant ID"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
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

                    @if(request()->hasAny(['property_id', 'tenant_id', 'as_of_date']))
                        <div>
                            <a href="{{ route('reports.aging') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </x-card>

            <!-- Aging Report Table -->
            <x-card>
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Aging Report as of {{ $asOfDate->format('F d, Y') }}</h3>
                    <p class="text-sm text-gray-500">Outstanding receivables grouped by aging buckets</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tenant
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Current
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    1-30 Days
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    31-60 Days
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    61-90 Days
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    90+ Days
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($agingData as $data)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        @if($data['tenant']->company)
                                            {{ $data['tenant']->company->name }}
                                        @else
                                            {{ $data['tenant']->first_name }} {{ $data['tenant']->last_name }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        {{ config('pms.currency.symbol') }}{{ number_format($data['buckets']['current'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $data['buckets']['1-30'] > 0 ? 'text-yellow-600 font-semibold' : 'text-gray-900' }}">
                                        {{ config('pms.currency.symbol') }}{{ number_format($data['buckets']['1-30'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $data['buckets']['31-60'] > 0 ? 'text-orange-600 font-semibold' : 'text-gray-900' }}">
                                        {{ config('pms.currency.symbol') }}{{ number_format($data['buckets']['31-60'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $data['buckets']['61-90'] > 0 ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                        {{ config('pms.currency.symbol') }}{{ number_format($data['buckets']['61-90'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $data['buckets']['90+'] > 0 ? 'text-red-700 font-bold' : 'text-gray-900' }}">
                                        {{ config('pms.currency.symbol') }}{{ number_format($data['buckets']['90+'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">
                                        {{ config('pms.currency.symbol') }}{{ number_format($data['total'], 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No outstanding receivables found with the selected filters.
                                    </td>
                                </tr>
                            @endforelse

                            @if(count($agingData) > 0)
                                <tr class="bg-indigo-50 font-bold">
                                    <td class="px-6 py-4 text-sm">
                                        Total:
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        {{ config('pms.currency.symbol') }}{{ number_format($totals['current'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $totals['1-30'] > 0 ? 'text-yellow-700' : '' }}">
                                        {{ config('pms.currency.symbol') }}{{ number_format($totals['1-30'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $totals['31-60'] > 0 ? 'text-orange-700' : '' }}">
                                        {{ config('pms.currency.symbol') }}{{ number_format($totals['31-60'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $totals['61-90'] > 0 ? 'text-red-700' : '' }}">
                                        {{ config('pms.currency.symbol') }}{{ number_format($totals['61-90'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $totals['90+'] > 0 ? 'text-red-800' : '' }}">
                                        {{ config('pms.currency.symbol') }}{{ number_format($totals['90+'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        {{ config('pms.currency.symbol') }}{{ number_format($grandTotal, 2) }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if(count($agingData) > 0)
                    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <span class="font-medium">Note:</span> Overdue amounts are highlighted in color. The darker the color, the more overdue the receivable.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>

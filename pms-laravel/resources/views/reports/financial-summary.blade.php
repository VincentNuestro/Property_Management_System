<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Financial Summary Report') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Reports
                </a>
                <a href="{{ route('reports.financial-summary.export', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Export to Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <x-card class="mb-6">
                <form method="GET" action="{{ route('reports.financial-summary') }}" class="space-y-4">
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

                        <!-- Date From -->
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                            <input
                                type="date"
                                name="date_from"
                                id="date_from"
                                value="{{ $dateFrom->format('Y-m-d') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <!-- Date To -->
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                            <input
                                type="date"
                                name="date_to"
                                id="date_to"
                                value="{{ $dateTo->format('Y-m-d') }}"
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

                    @if(request()->hasAny(['property_id', 'date_from', 'date_to']))
                        <div>
                            <a href="{{ route('reports.financial-summary') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </x-card>

            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900">Period: {{ $dateFrom->format('F d, Y') }} to {{ $dateTo->format('F d, Y') }}</h3>
                <p class="text-sm text-gray-500">Comparison with previous period ({{ $prevDateFrom->format('F d, Y') }} to {{ $prevDateTo->format('F d, Y') }})</p>
            </div>

            <!-- Revenue Section -->
            <x-card class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Revenue</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Invoiced</p>
                                <p class="text-2xl font-semibold text-gray-900 mt-1">{{ config('pms.currency.symbol') }}{{ number_format($totalInvoiced, 2) }}</p>
                            </div>
                            @if($invoicedChange != 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invoicedChange > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $invoicedChange > 0 ? '+' : '' }}{{ number_format($invoicedChange, 2) }}%
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Previous: {{ config('pms.currency.symbol') }}{{ number_format($prevTotalInvoiced, 2) }}</p>
                    </div>

                    <div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Collected</p>
                                <p class="text-2xl font-semibold text-green-600 mt-1">{{ config('pms.currency.symbol') }}{{ number_format($totalCollected, 2) }}</p>
                            </div>
                            @if($collectedChange != 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $collectedChange > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $collectedChange > 0 ? '+' : '' }}{{ number_format($collectedChange, 2) }}%
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Previous: {{ config('pms.currency.symbol') }}{{ number_format($prevTotalCollected, 2) }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Outstanding Balance</p>
                        <p class="text-2xl font-semibold text-yellow-600 mt-1">{{ config('pms.currency.symbol') }}{{ number_format($outstandingBalance, 2) }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Expenses Section -->
            <x-card class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Expenses</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Maintenance Costs</p>
                                <p class="text-2xl font-semibold text-red-600 mt-1">{{ config('pms.currency.symbol') }}{{ number_format($maintenanceCosts, 2) }}</p>
                            </div>
                            @if($expensesChange != 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $expensesChange > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $expensesChange > 0 ? '+' : '' }}{{ number_format($expensesChange, 2) }}%
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Previous: {{ config('pms.currency.symbol') }}{{ number_format($prevMaintenanceCosts, 2) }}</p>
                        <p class="text-xs text-gray-500 mt-1">From completed work orders</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-medium text-gray-500 mb-2">Expense Breakdown</p>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Maintenance & Repairs</span>
                                <span class="font-medium text-gray-900">{{ config('pms.currency.symbol') }}{{ number_format($maintenanceCosts, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Net Operating Income -->
            <x-card class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Net Operating Income (NOI)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="bg-indigo-50 p-6 rounded-lg border-2 border-indigo-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-indigo-600">Current Period NOI</p>
                                    <p class="text-3xl font-bold text-indigo-900 mt-2">{{ config('pms.currency.symbol') }}{{ number_format($netOperatingIncome, 2) }}</p>
                                </div>
                                @if($noiChange != 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $noiChange > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $noiChange > 0 ? '+' : '' }}{{ number_format($noiChange, 2) }}%
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-indigo-700 mt-3">Revenue - Expenses</p>
                        </div>
                    </div>

                    <div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">Previous Period NOI</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-2">{{ config('pms.currency.symbol') }}{{ number_format($prevNetOperatingIncome, 2) }}</p>
                            <p class="text-xs text-gray-500 mt-3">{{ $prevDateFrom->format('M d') }} - {{ $prevDateTo->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Summary Breakdown -->
            <x-card>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Summary Breakdown</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Current Period
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Previous Period
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Change
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Total Invoiced
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    {{ config('pms.currency.symbol') }}{{ number_format($totalInvoiced, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                    {{ config('pms.currency.symbol') }}{{ number_format($prevTotalInvoiced, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    <span class="font-medium {{ $invoicedChange > 0 ? 'text-green-600' : ($invoicedChange < 0 ? 'text-red-600' : 'text-gray-600') }}">
                                        {{ $invoicedChange > 0 ? '+' : '' }}{{ number_format($invoicedChange, 2) }}%
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Total Collected
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    {{ config('pms.currency.symbol') }}{{ number_format($totalCollected, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                    {{ config('pms.currency.symbol') }}{{ number_format($prevTotalCollected, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    <span class="font-medium {{ $collectedChange > 0 ? 'text-green-600' : ($collectedChange < 0 ? 'text-red-600' : 'text-gray-600') }}">
                                        {{ $collectedChange > 0 ? '+' : '' }}{{ number_format($collectedChange, 2) }}%
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Maintenance Costs
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    {{ config('pms.currency.symbol') }}{{ number_format($maintenanceCosts, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                    {{ config('pms.currency.symbol') }}{{ number_format($prevMaintenanceCosts, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    <span class="font-medium {{ $expensesChange > 0 ? 'text-red-600' : ($expensesChange < 0 ? 'text-green-600' : 'text-gray-600') }}">
                                        {{ $expensesChange > 0 ? '+' : '' }}{{ number_format($expensesChange, 2) }}%
                                    </span>
                                </td>
                            </tr>
                            <tr class="bg-indigo-50 font-bold">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    Net Operating Income
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    {{ config('pms.currency.symbol') }}{{ number_format($netOperatingIncome, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    {{ config('pms.currency.symbol') }}{{ number_format($prevNetOperatingIncome, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    <span class="font-bold {{ $noiChange > 0 ? 'text-green-600' : ($noiChange < 0 ? 'text-red-600' : 'text-gray-600') }}">
                                        {{ $noiChange > 0 ? '+' : '' }}{{ number_format($noiChange, 2) }}%
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>

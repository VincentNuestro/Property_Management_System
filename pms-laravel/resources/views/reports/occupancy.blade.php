<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Occupancy Report') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Reports
                </a>
                <a href="{{ route('reports.occupancy.export', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Export to Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <x-card class="mb-6">
                <form method="GET" action="{{ route('reports.occupancy') }}" class="space-y-4">
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
                            <a href="{{ route('reports.occupancy') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </x-card>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <x-card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Units</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalUnits) }}</p>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Occupied</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalOccupied) }}</p>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Vacant</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalVacant) }}</p>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Occupancy Rate</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($occupancyPercentage, 2) }}%</p>
                        </div>
                    </div>
                </x-card>
            </div>

            <!-- Occupancy Data by Property -->
            @forelse($occupancyData as $data)
                <x-card class="mb-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $data['property']->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $data['property']->code }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Total Units</p>
                            <p class="text-xl font-semibold text-gray-900">{{ number_format($data['total_units']) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Occupied</p>
                            <p class="text-xl font-semibold text-green-600">{{ number_format($data['occupied_units']) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Vacant</p>
                            <p class="text-xl font-semibold text-yellow-600">{{ number_format($data['vacant_units']) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Occupancy Rate</p>
                            <p class="text-xl font-semibold text-indigo-600">{{ number_format($data['occupancy_percentage'], 2) }}%</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit Code
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit Number
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($data['units'] as $unit)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $unit->unit_code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $unit->unit_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $unit->type->label() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-badge :color="$unit->status->value === 'occupied' ? 'green' : ($unit->status->value === 'vacant' ? 'yellow' : 'gray')">
                                                {{ $unit->status->label() }}
                                            </x-badge>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @empty
                <x-card>
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No data available</h3>
                        <p class="mt-1 text-sm text-gray-500">No properties found with the selected filters.</p>
                    </div>
                </x-card>
            @endforelse
        </div>
    </div>
</x-app-layout>

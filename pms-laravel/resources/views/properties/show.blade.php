<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $property->name }}
            </h2>
            @can('properties.edit')
                <a href="{{ route('properties.edit', $property) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Property
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Property Details -->
            <x-card title="Property Details">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Property Code</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $property->code }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Property Name</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $property->name }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Type</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $property->type->label() }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-1">
                            <x-badge :color="$property->status === 'active' ? 'green' : 'gray'">
                                {{ ucfirst($property->status) }}
                            </x-badge>
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Full Address</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $property->full_address ?: 'N/A' }}</p>
                    </div>

                    @if($property->phone)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $property->phone }}</p>
                        </div>
                    @endif

                    @if($property->email)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Email</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $property->email }}</p>
                        </div>
                    @endif

                    @if($property->tax_id)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Tax ID</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $property->tax_id }}</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Statistics -->
            <x-card title="Statistics">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_units'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Total Units</p>
                    </div>

                    <div class="text-center">
                        <p class="text-3xl font-bold text-green-600">{{ $stats['occupied_units'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Occupied Units</p>
                    </div>

                    <div class="text-center">
                        <p class="text-3xl font-bold text-gray-600">{{ $stats['vacant_units'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Vacant Units</p>
                    </div>

                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_buildings'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Total Buildings</p>
                    </div>

                    <div class="text-center">
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['active_leases'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Active Leases</p>
                    </div>
                </div>
            </x-card>

            <!-- Buildings -->
            @if($property->buildings->count() > 0)
                <x-card title="Buildings">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($property->buildings as $building)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <h4 class="font-medium text-gray-900">{{ $building->name }}</h4>
                                <p class="text-sm text-gray-500 mt-1">Code: {{ $building->code }}</p>
                                <p class="text-sm text-gray-500">Floors: {{ $building->floors->count() }}</p>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            @endif

            <!-- Units -->
            @if($property->units->count() > 0)
                <x-card title="Units">
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
                                @foreach($property->units as $unit)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $unit->unit_code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $unit->unit_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $unit->type->label() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-badge :color="$unit->status === 'available' ? 'green' : ($unit->status === 'occupied' ? 'blue' : 'gray')">
                                                {{ ucfirst($unit->status) }}
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

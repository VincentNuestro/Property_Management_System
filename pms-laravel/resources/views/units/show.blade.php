<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $unit->unit_code }} - {{ $unit->unit_number }}
            </h2>
            @can('units.edit')
                <a href="{{ route('units.edit', $unit) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Unit
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Unit Details -->
            <x-card title="Unit Details">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Unit Code</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $unit->unit_code }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Unit Number</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $unit->unit_number }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Property</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="{{ route('properties.show', $unit->property) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ $unit->property->name }}
                            </a>
                        </p>
                    </div>

                    @if($unit->building)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Building</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $unit->building->name }}</p>
                        </div>
                    @endif

                    @if($unit->floor)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Floor</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $unit->floor->display_name }}</p>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Type</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $unit->type->label() }}</p>
                    </div>

                    @if($unit->classification)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Classification</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $unit->classification }}</p>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-1">
                            <x-badge :color="$unit->status->color()">
                                {{ $unit->status->label() }}
                            </x-badge>
                        </p>
                    </div>

                    @if($unit->area_sqm)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Area</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ number_format($unit->area_sqm, 2) }} sqm</p>
                        </div>
                    @endif

                    @if($unit->bedrooms)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Bedrooms</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $unit->bedrooms }}</p>
                        </div>
                    @endif

                    @if($unit->bathrooms)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Bathrooms</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $unit->bathrooms }}</p>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Base Rent</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $unit->base_rent ? '₱' . number_format($unit->base_rent, 2) : 'N/A' }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Association Dues</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $unit->association_dues ? '₱' . number_format($unit->association_dues, 2) : 'N/A' }}</p>
                    </div>

                    @if($unit->base_rent && $unit->association_dues)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Total Monthly Charge</h4>
                            <p class="mt-1 text-sm font-semibold text-gray-900">₱{{ number_format($unit->total_monthly_charge, 2) }}</p>
                        </div>
                    @endif

                    @if($unit->description)
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-medium text-gray-500">Description</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $unit->description }}</p>
                        </div>
                    @endif

                    @if($unit->notes)
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-medium text-gray-500">Notes</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $unit->notes }}</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Current Occupancy -->
            @if($occupiedBy)
                <x-card title="Current Occupancy">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Occupied By</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $occupiedBy->full_name }}</p>
                        </div>

                        @if($currentLease)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Lease Start Date</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $currentLease->start_date->format('M d, Y') }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Lease End Date</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $currentLease->end_date->format('M d, Y') }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Monthly Rent</h4>
                                <p class="mt-1 text-sm text-gray-900">₱{{ number_format($currentLease->pivot->monthly_rent, 2) }}</p>
                            </div>
                        @endif
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
                                        Tenant
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($leaseHistory as $lease)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lease->tenant->full_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lease->start_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lease->end_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ₱{{ number_format($lease->pivot->monthly_rent, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-badge :color="$lease->status === 'active' ? 'green' : 'gray'">
                                                {{ ucfirst($lease->status) }}
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

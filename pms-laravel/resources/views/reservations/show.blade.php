<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reservation: {{ $reservation->reservation_number }}
            </h2>
            <div class="flex space-x-2">
                @can('reservations.edit')
                    @if($reservation->status === \App\Enums\ReservationStatus::ACTIVE)
                        <a href="{{ route('reservations.edit', $reservation) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Reservation
                        </a>
                    @endif
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Action Buttons -->
            @if($reservation->status === \App\Enums\ReservationStatus::ACTIVE)
                <x-card>
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                        <div class="flex space-x-2">
                            @can('reservations.convert')
                                <form method="POST" action="{{ route('reservations.convert', $reservation) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Convert to Application
                                    </button>
                                </form>
                            @endcan

                            @can('reservations.edit')
                                <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" class="inline" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Cancel Reservation
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </x-card>
            @endif

            <!-- Reservation Details -->
            <x-card title="Reservation Details">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Reservation Number</h4>
                        <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $reservation->reservation_number }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-1">
                            <x-badge :color="$reservation->status->color()">
                                {{ $reservation->status->label() }}
                            </x-badge>
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Reservation Date</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $reservation->reservation_date?->format('F d, Y') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Expiry Date</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $reservation->expiry_date?->format('F d, Y') }}
                            @if($reservation->is_expired)
                                <span class="text-red-600 text-xs">(Expired)</span>
                            @elseif($reservation->days_until_expiry !== null && $reservation->days_until_expiry <= 3)
                                <span class="text-yellow-600 text-xs">(Expires in {{ $reservation->days_until_expiry }} days)</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Created At</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $reservation->created_at?->format('F d, Y g:i A') }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Property & Unit Information -->
            <x-card title="Property & Unit Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Property</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($reservation->property)
                                <a href="{{ route('properties.show', $reservation->property) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $reservation->property->name }}
                                </a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Unit</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($reservation->unit)
                                <a href="{{ route('units.show', $reservation->unit) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $reservation->unit->unit_number }}
                                </a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    @if($reservation->unit)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Unit Type</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->unit->type?->label() ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Base Rent</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ money($reservation->unit->base_rent, 'PHP') }}/month</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Tenant Information -->
            <x-card title="Tenant Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Name</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($reservation->tenant)
                                <a href="{{ route('tenants.show', $reservation->tenant) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $reservation->tenant->full_name }}
                                </a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    @if($reservation->tenant)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Type</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->tenant->tenant_type?->label() ?? 'N/A' }}</p>
                        </div>

                        @if($reservation->tenant->email)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Email</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:{{ $reservation->tenant->email }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $reservation->tenant->email }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if($reservation->tenant->primary_contact)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Contact</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $reservation->tenant->primary_contact }}</p>
                            </div>
                        @endif
                    @endif
                </div>
            </x-card>

            <!-- Financial Information -->
            <x-card title="Financial Information">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Reservation Fee</h4>
                        <p class="mt-1 text-sm text-gray-900 font-semibold">{{ money($reservation->reservation_fee, 'PHP') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Amount Paid</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ money($reservation->reservation_paid, 'PHP') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Balance</h4>
                        <p class="mt-1 text-sm font-semibold {{ $reservation->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ money($reservation->balance, 'PHP') }}
                            @if($reservation->is_fully_paid)
                                <span class="text-xs text-green-600">(Fully Paid)</span>
                            @endif
                        </p>
                    </div>
                </div>
            </x-card>

            <!-- Notes -->
            @if($reservation->notes)
                <x-card title="Notes">
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $reservation->notes }}</p>
                </x-card>
            @endif

            <!-- Activity Timeline -->
            <x-card title="Activity Timeline">
                <div class="flow-root">
                    <ul class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Reservation created</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ $reservation->created_at?->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        @if($reservation->status === \App\Enums\ReservationStatus::CONVERTED)
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Converted to lease application</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $reservation->updated_at?->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @elseif($reservation->status === \App\Enums\ReservationStatus::CANCELLED)
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Reservation cancelled</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $reservation->updated_at?->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>

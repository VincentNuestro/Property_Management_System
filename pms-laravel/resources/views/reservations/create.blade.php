<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Reservation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('reservations.store') }}" id="reservationForm">
                    @csrf

                    <!-- Property and Unit Selection -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Property & Unit Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Property -->
                            <div>
                                <label for="property_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Property <span class="text-red-600">*</span>
                                </label>
                                <select
                                    name="property_id"
                                    id="property_id"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    onchange="loadUnits()"
                                >
                                    <option value="">Select Property</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}" {{ old('property_id', $selectedPropertyId) == $property->id ? 'selected' : '' }}>
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('property_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Unit -->
                            <div>
                                <label for="unit_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Unit <span class="text-red-600">*</span>
                                </label>
                                <select
                                    name="unit_id"
                                    id="unit_id"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Select Unit</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->unit_number }} - {{ money($unit->base_rent, 'PHP') }}/month
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Tenant Selection -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tenant Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Tenant -->
                            <div>
                                <label for="tenant_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tenant <span class="text-red-600">*</span>
                                </label>
                                <select
                                    name="tenant_id"
                                    id="tenant_id"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Select Tenant</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                            {{ $tenant->full_name }} - {{ $tenant->email ?? 'No email' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tenant_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Reservation Details -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Reservation Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Reservation Date -->
                            <x-form.input
                                label="Reservation Date"
                                name="reservation_date"
                                type="date"
                                :required="true"
                                :value="old('reservation_date', now()->format('Y-m-d'))"
                            />

                            <!-- Expiry Date -->
                            <x-form.input
                                label="Expiry Date"
                                name="expiry_date"
                                type="date"
                                :required="true"
                                :value="old('expiry_date', now()->addDays(7)->format('Y-m-d'))"
                                help="Default is 7 days from reservation date"
                            />

                            <!-- Reservation Fee -->
                            <x-form.input
                                label="Reservation Fee"
                                name="reservation_fee"
                                type="number"
                                step="0.01"
                                min="0"
                                :required="true"
                                :value="old('reservation_fee')"
                                help="Amount required to reserve the unit"
                            />

                            <!-- Reservation Paid -->
                            <x-form.input
                                label="Amount Paid"
                                name="reservation_paid"
                                type="number"
                                step="0.01"
                                min="0"
                                :value="old('reservation_paid', '0')"
                                help="Amount already paid by tenant"
                            />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            rows="4"
                            help="Any additional notes about this reservation"
                        />
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('reservations.index') }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Create Reservation
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    @push('scripts')
    <script>
        async function loadUnits() {
            const propertyId = document.getElementById('property_id').value;
            const unitSelect = document.getElementById('unit_id');

            // Clear current options
            unitSelect.innerHTML = '<option value="">Select Unit</option>';

            if (!propertyId) {
                return;
            }

            try {
                const response = await fetch(`{{ route('reservations.index') }}/../get-units?property_id=${propertyId}`);
                const units = await response.json();

                units.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit.id;
                    option.textContent = `${unit.unit_number} - PHP ${parseFloat(unit.base_rent).toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2})}/month`;
                    unitSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading units:', error);
            }
        }

        // Load units on page load if property is already selected
        document.addEventListener('DOMContentLoaded', function() {
            const propertyId = document.getElementById('property_id').value;
            if (propertyId) {
                loadUnits();
            }
        });
    </script>
    @endpush
</x-app-layout>

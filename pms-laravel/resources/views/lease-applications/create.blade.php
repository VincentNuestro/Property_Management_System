<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Lease Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('lease-applications.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Property -->
                        <div class="md:col-span-2">
                            <label for="property_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Property <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="property_id"
                                id="property_id"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('property_id') border-red-300 @enderror"
                            >
                                <option value="">Select Property</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                        {{ $property->name }} ({{ $property->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('property_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tenant -->
                        <div class="md:col-span-2">
                            <label for="tenant_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Tenant <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="tenant_id"
                                id="tenant_id"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tenant_id') border-red-300 @enderror"
                            >
                                <option value="">Select Tenant</option>
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                        {{ $tenant->full_name }}
                                        @if($tenant->email)
                                            ({{ $tenant->email }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('tenant_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Application Date -->
                        <x-form.input
                            label="Application Date"
                            name="application_date"
                            type="date"
                            :value="old('application_date', date('Y-m-d'))"
                            :required="true"
                        />

                        <!-- Desired Start Date -->
                        <x-form.input
                            label="Desired Start Date"
                            name="desired_start_date"
                            type="date"
                            :value="old('desired_start_date')"
                            :required="true"
                            help="Preferred lease commencement date"
                        />

                        <!-- Desired Lease Term -->
                        <x-form.input
                            label="Desired Lease Term (Months)"
                            name="desired_lease_term"
                            type="number"
                            :value="old('desired_lease_term', 12)"
                            :required="true"
                            min="1"
                            max="120"
                            help="Preferred lease duration in months"
                        />
                    </div>

                    <!-- Notes -->
                    <div class="mt-6">
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            :value="old('notes')"
                            rows="4"
                            help="Additional notes or special requirements"
                        />
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('lease-applications.index') }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Create Application
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>

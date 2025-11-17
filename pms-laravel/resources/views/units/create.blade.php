<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Unit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('units.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Unit Code -->
                        <x-form.input
                            label="Unit Code"
                            name="unit_code"
                            type="text"
                            :required="true"
                            help="Unique identifier for the unit"
                        />

                        <!-- Unit Number -->
                        <x-form.input
                            label="Unit Number"
                            name="unit_number"
                            type="text"
                            :required="true"
                        />

                        <!-- Property -->
                        <x-form.select
                            label="Property"
                            name="property_id"
                            :options="$properties->pluck('name', 'id')->toArray()"
                            :required="true"
                        />

                        <!-- Building -->
                        <x-form.select
                            label="Building"
                            name="building_id"
                            :options="$buildings->pluck('name', 'id')->toArray()"
                            placeholder="Select a building (optional)"
                        />

                        <!-- Floor -->
                        <x-form.select
                            label="Floor"
                            name="floor_id"
                            :options="$floors->pluck('display_name', 'id')->toArray()"
                            placeholder="Select a floor (optional)"
                        />

                        <!-- Type -->
                        <x-form.select
                            label="Unit Type"
                            name="type"
                            :options="$unitTypes"
                            :required="true"
                        />

                        <!-- Classification -->
                        <x-form.input
                            label="Classification"
                            name="classification"
                            type="text"
                            help="e.g., Studio, 1BR, 2BR, etc."
                        />

                        <!-- Status -->
                        <x-form.select
                            label="Status"
                            name="status"
                            :options="$unitStatuses"
                            value="vacant"
                            :required="true"
                        />
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Unit Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Area -->
                            <x-form.input
                                label="Area (sqm)"
                                name="area_sqm"
                                type="number"
                                step="0.01"
                            />

                            <!-- Bedrooms -->
                            <x-form.input
                                label="Bedrooms"
                                name="bedrooms"
                                type="number"
                                min="0"
                            />

                            <!-- Bathrooms -->
                            <x-form.input
                                label="Bathrooms"
                                name="bathrooms"
                                type="number"
                                min="0"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Base Rent -->
                            <x-form.input
                                label="Base Rent"
                                name="base_rent"
                                type="number"
                                step="0.01"
                                help="Monthly base rent amount"
                            />

                            <!-- Association Dues -->
                            <x-form.input
                                label="Association Dues"
                                name="association_dues"
                                type="number"
                                step="0.01"
                                help="Monthly association dues"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea
                                    name="description"
                                    id="description"
                                    rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                <textarea
                                    name="notes"
                                    id="notes"
                                    rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('units.index') }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Create Unit
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>

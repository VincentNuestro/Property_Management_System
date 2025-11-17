<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Property: ') . $property->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('properties.update', $property) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Code -->
                        <x-form.input
                            label="Property Code"
                            name="code"
                            type="text"
                            :value="$property->code"
                            :required="true"
                            help="Unique identifier for the property"
                        />

                        <!-- Name -->
                        <x-form.input
                            label="Property Name"
                            name="name"
                            type="text"
                            :value="$property->name"
                            :required="true"
                        />

                        <!-- Type -->
                        <x-form.select
                            label="Property Type"
                            name="type"
                            :options="$propertyTypes"
                            :value="$property->type->value"
                            :required="true"
                        />

                        <!-- Status -->
                        <x-form.select
                            label="Status"
                            name="status"
                            :options="['active' => 'Active', 'inactive' => 'Inactive']"
                            :value="$property->status"
                            :required="true"
                        />
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Address Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Address Line 1 -->
                            <x-form.input
                                label="Address Line 1"
                                name="address_line1"
                                type="text"
                                :value="$property->address_line1"
                                class="md:col-span-2"
                            />

                            <!-- Address Line 2 -->
                            <x-form.input
                                label="Address Line 2"
                                name="address_line2"
                                type="text"
                                :value="$property->address_line2"
                                class="md:col-span-2"
                            />

                            <!-- City -->
                            <x-form.input
                                label="City"
                                name="city"
                                type="text"
                                :value="$property->city"
                            />

                            <!-- State -->
                            <x-form.input
                                label="State/Province"
                                name="state"
                                type="text"
                                :value="$property->state"
                            />

                            <!-- Postal Code -->
                            <x-form.input
                                label="Postal Code"
                                name="postal_code"
                                type="text"
                                :value="$property->postal_code"
                            />

                            <!-- Country -->
                            <x-form.input
                                label="Country"
                                name="country"
                                type="text"
                                :value="$property->country"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Phone -->
                            <x-form.input
                                label="Phone"
                                name="phone"
                                type="text"
                                :value="$property->phone"
                            />

                            <!-- Email -->
                            <x-form.input
                                label="Email"
                                name="email"
                                type="email"
                                :value="$property->email"
                            />

                            <!-- Tax ID -->
                            <x-form.input
                                label="Tax ID"
                                name="tax_id"
                                type="text"
                                :value="$property->tax_id"
                                help="Business tax identification number"
                            />
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('properties.show', $property) }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Update Property
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>

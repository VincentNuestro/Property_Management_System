<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('companies.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <x-form.input
                            label="Company Name"
                            name="name"
                            type="text"
                            :required="true"
                        />

                        <!-- Trade Name -->
                        <x-form.input
                            label="Trade Name"
                            name="trade_name"
                            type="text"
                            help="DBA or trading name"
                        />

                        <!-- Business Type -->
                        <x-form.input
                            label="Business Type"
                            name="business_type"
                            type="text"
                            help="e.g., Corporation, LLC, Partnership"
                        />

                        <!-- Industry -->
                        <x-form.input
                            label="Industry"
                            name="industry"
                            type="text"
                            help="e.g., Retail, Technology, Healthcare"
                        />

                        <!-- Tax ID -->
                        <x-form.input
                            label="Tax ID"
                            name="tax_id"
                            type="text"
                            help="Tax identification number"
                        />

                        <!-- Status -->
                        <x-form.select
                            label="Status"
                            name="status"
                            :options="['active' => 'Active', 'inactive' => 'Inactive']"
                            value="active"
                            :required="true"
                        />
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <x-form.input
                                label="Email"
                                name="email"
                                type="email"
                            />

                            <!-- Phone -->
                            <x-form.input
                                label="Phone"
                                name="phone"
                                type="text"
                            />

                            <!-- Website -->
                            <x-form.input
                                label="Website"
                                name="website"
                                type="url"
                                class="md:col-span-2"
                                help="e.g., https://www.example.com"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Address Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Address Line 1 -->
                            <x-form.input
                                label="Address Line 1"
                                name="address_line1"
                                type="text"
                                class="md:col-span-2"
                            />

                            <!-- Address Line 2 -->
                            <x-form.input
                                label="Address Line 2"
                                name="address_line2"
                                type="text"
                                class="md:col-span-2"
                            />

                            <!-- City -->
                            <x-form.input
                                label="City"
                                name="city"
                                type="text"
                            />

                            <!-- State -->
                            <x-form.input
                                label="State/Province"
                                name="state"
                                type="text"
                            />

                            <!-- Postal Code -->
                            <x-form.input
                                label="Postal Code"
                                name="postal_code"
                                type="text"
                            />

                            <!-- Country -->
                            <x-form.input
                                label="Country"
                                name="country"
                                type="text"
                                value="Philippines"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            rows="4"
                            help="Any additional notes about this company"
                        />
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('companies.index') }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Create Company
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>

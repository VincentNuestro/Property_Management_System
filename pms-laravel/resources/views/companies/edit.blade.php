<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') }}: {{ $company->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('companies.update', $company) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <x-form.input
                            label="Company Name"
                            name="name"
                            type="text"
                            :value="$company->name"
                            :required="true"
                        />

                        <!-- Trade Name -->
                        <x-form.input
                            label="Trade Name"
                            name="trade_name"
                            type="text"
                            :value="$company->trade_name"
                            help="DBA or trading name"
                        />

                        <!-- Business Type -->
                        <x-form.input
                            label="Business Type"
                            name="business_type"
                            type="text"
                            :value="$company->business_type"
                            help="e.g., Corporation, LLC, Partnership"
                        />

                        <!-- Industry -->
                        <x-form.input
                            label="Industry"
                            name="industry"
                            type="text"
                            :value="$company->industry"
                            help="e.g., Retail, Technology, Healthcare"
                        />

                        <!-- Tax ID -->
                        <x-form.input
                            label="Tax ID"
                            name="tax_id"
                            type="text"
                            :value="$company->tax_id"
                            help="Tax identification number"
                        />

                        <!-- Status -->
                        <x-form.select
                            label="Status"
                            name="status"
                            :options="['active' => 'Active', 'inactive' => 'Inactive']"
                            :value="$company->status"
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
                                :value="$company->email"
                            />

                            <!-- Phone -->
                            <x-form.input
                                label="Phone"
                                name="phone"
                                type="text"
                                :value="$company->phone"
                            />

                            <!-- Website -->
                            <x-form.input
                                label="Website"
                                name="website"
                                type="url"
                                :value="$company->website"
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
                                :value="$company->address_line1"
                                class="md:col-span-2"
                            />

                            <!-- Address Line 2 -->
                            <x-form.input
                                label="Address Line 2"
                                name="address_line2"
                                type="text"
                                :value="$company->address_line2"
                                class="md:col-span-2"
                            />

                            <!-- City -->
                            <x-form.input
                                label="City"
                                name="city"
                                type="text"
                                :value="$company->city"
                            />

                            <!-- State -->
                            <x-form.input
                                label="State/Province"
                                name="state"
                                type="text"
                                :value="$company->state"
                            />

                            <!-- Postal Code -->
                            <x-form.input
                                label="Postal Code"
                                name="postal_code"
                                type="text"
                                :value="$company->postal_code"
                            />

                            <!-- Country -->
                            <x-form.input
                                label="Country"
                                name="country"
                                type="text"
                                :value="$company->country"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            rows="4"
                            :value="$company->notes"
                            help="Any additional notes about this company"
                        />
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('companies.show', $company) }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Update Company
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>

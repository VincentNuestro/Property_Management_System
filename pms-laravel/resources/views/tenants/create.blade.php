<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Tenant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('tenants.store') }}" id="tenantForm">
                    @csrf

                    <!-- Tenant Type Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tenant Type <span class="text-red-600">*</span></label>
                        <div class="flex space-x-4">
                            @foreach($tenantTypes as $type)
                                <label class="flex items-center">
                                    <input
                                        type="radio"
                                        name="tenant_type"
                                        value="{{ $type['value'] }}"
                                        {{ old('tenant_type', 'individual') == $type['value'] ? 'checked' : '' }}
                                        class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                        onchange="toggleTenantFields()"
                                    >
                                    <span class="ml-2">{{ $type['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('tenant_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Individual Fields -->
                    <div id="individualFields" class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- First Name -->
                            <x-form.input
                                label="First Name"
                                name="first_name"
                                type="text"
                                :required="true"
                            />

                            <!-- Last Name -->
                            <x-form.input
                                label="Last Name"
                                name="last_name"
                                type="text"
                                :required="true"
                            />

                            <!-- Date of Birth -->
                            <x-form.input
                                label="Date of Birth"
                                name="date_of_birth"
                                type="date"
                            />

                            <!-- Nationality -->
                            <x-form.input
                                label="Nationality"
                                name="nationality"
                                type="text"
                            />

                            <!-- Government ID Type -->
                            <x-form.input
                                label="ID Type"
                                name="government_id_type"
                                type="text"
                                help="e.g., Passport, Driver's License, SSS"
                            />

                            <!-- Government ID Number -->
                            <x-form.input
                                label="ID Number"
                                name="government_id_number"
                                type="text"
                            />
                        </div>
                    </div>

                    <!-- Corporate Fields -->
                    <div id="corporateFields" class="mb-6 hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Company Information</h3>
                        <x-form.select
                            label="Company"
                            name="company_id"
                            :options="$companies->pluck('display_name', 'id')->toArray()"
                            :required="true"
                            help="Select the company this tenant represents"
                        />
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-6">
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

                            <!-- Mobile -->
                            <x-form.input
                                label="Mobile"
                                name="mobile"
                                type="text"
                                class="md:col-span-2"
                            />
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="mb-6">
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

                    <!-- Status and Notes -->
                    <div class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Status -->
                            <x-form.select
                                label="Status"
                                name="status"
                                :options="collect($tenantStatuses)->pluck('label', 'value')->toArray()"
                                value="active"
                                :required="true"
                            />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            rows="4"
                            help="Any additional notes about this tenant"
                        />
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('tenants.index') }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Create Tenant
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleTenantFields() {
            const tenantType = document.querySelector('input[name="tenant_type"]:checked').value;
            const individualFields = document.getElementById('individualFields');
            const corporateFields = document.getElementById('corporateFields');

            if (tenantType === 'individual') {
                individualFields.classList.remove('hidden');
                corporateFields.classList.add('hidden');

                // Enable individual fields
                individualFields.querySelectorAll('input').forEach(input => {
                    input.disabled = false;
                });

                // Disable corporate fields
                corporateFields.querySelectorAll('select').forEach(select => {
                    select.disabled = true;
                });
            } else {
                individualFields.classList.add('hidden');
                corporateFields.classList.remove('hidden');

                // Disable individual fields
                individualFields.querySelectorAll('input').forEach(input => {
                    input.disabled = true;
                });

                // Enable corporate fields
                corporateFields.querySelectorAll('select').forEach(select => {
                    select.disabled = false;
                });
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', toggleTenantFields);
    </script>
    @endpush
</x-app-layout>

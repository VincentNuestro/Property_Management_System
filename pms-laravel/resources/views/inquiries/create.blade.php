<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Inquiry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('inquiries.store') }}">
                    @csrf

                    <!-- Property and Basic Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Property Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Property -->
                            <x-form.select
                                label="Property"
                                name="property_id"
                                :options="$properties->pluck('name', 'id')->toArray()"
                                :required="true"
                                help="Select the property the inquirer is interested in"
                            />

                            <!-- Space Type -->
                            <x-form.input
                                label="Space Type"
                                name="space_type"
                                type="text"
                                help="e.g., Office, Retail, Warehouse"
                            />

                            <!-- Desired Area -->
                            <x-form.input
                                label="Desired Area (sqm)"
                                name="desired_area_sqm"
                                type="number"
                                step="0.01"
                            />

                            <!-- Desired Move-in Date -->
                            <x-form.input
                                label="Desired Move-in Date"
                                name="desired_move_in_date"
                                type="date"
                            />
                        </div>
                    </div>

                    <!-- Inquirer Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Inquirer Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Inquirer Name -->
                            <x-form.input
                                label="Inquirer Name"
                                name="inquirer_name"
                                type="text"
                                :required="true"
                            />

                            <!-- Company Name -->
                            <x-form.input
                                label="Company Name"
                                name="company_name"
                                type="text"
                            />

                            <!-- Email -->
                            <x-form.input
                                label="Email"
                                name="inquirer_email"
                                type="email"
                                :required="true"
                            />

                            <!-- Phone -->
                            <x-form.input
                                label="Phone"
                                name="inquirer_phone"
                                type="text"
                            />
                        </div>
                    </div>

                    <!-- Budget Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Budget Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Minimum Budget -->
                            <x-form.input
                                label="Minimum Budget"
                                name="budget_min"
                                type="number"
                                step="0.01"
                                help="Monthly rental budget (minimum)"
                            />

                            <!-- Maximum Budget -->
                            <x-form.input
                                label="Maximum Budget"
                                name="budget_max"
                                type="number"
                                step="0.01"
                                help="Monthly rental budget (maximum)"
                            />
                        </div>
                    </div>

                    <!-- Inquiry Details -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Inquiry Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Source -->
                            <x-form.input
                                label="Source"
                                name="source"
                                type="text"
                                help="e.g., Website, Referral, Walk-in, Phone Call"
                            />

                            <!-- Status -->
                            <x-form.select
                                label="Status"
                                name="status"
                                :options="collect($inquiryStatuses)->pluck('label', 'value')->toArray()"
                                value="new"
                                :required="true"
                            />

                            <!-- Assigned To -->
                            <x-form.select
                                label="Assigned To"
                                name="assigned_to"
                                :options="['' => 'Unassigned'] + $users->pluck('name', 'id')->toArray()"
                                help="Assign this inquiry to a user"
                            />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            rows="4"
                            help="Any additional notes or requirements from the inquirer"
                        />
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('inquiries.index') }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Create Inquiry
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>

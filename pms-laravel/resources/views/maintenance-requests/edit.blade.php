<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Maintenance Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('maintenance-requests.update', $maintenanceRequest) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Property -->
                        <x-form.select
                            label="Property"
                            name="property_id"
                            :options="$properties->pluck('name', 'id')"
                            :value="old('property_id', $maintenanceRequest->property_id)"
                            :required="true"
                            help="Select the property for this maintenance request"
                        />

                        <!-- Unit -->
                        <x-form.select
                            label="Unit"
                            name="unit_id"
                            :options="$units->pluck('unit_number', 'id')"
                            :value="old('unit_id', $maintenanceRequest->unit_id)"
                            help="Select the specific unit (optional)"
                        />

                        <!-- Tenant -->
                        <x-form.select
                            label="Tenant"
                            name="tenant_id"
                            :options="$tenants->mapWithKeys(fn($tenant) => [$tenant->id => $tenant->full_name])"
                            :value="old('tenant_id', $maintenanceRequest->tenant_id)"
                            help="Select the tenant who reported this issue (optional)"
                        />

                        <!-- Category -->
                        <x-form.input
                            label="Category"
                            name="category"
                            type="text"
                            :value="old('category', $maintenanceRequest->category)"
                            :required="true"
                            placeholder="e.g., Plumbing, Electrical, HVAC"
                            help="Type of maintenance issue"
                        />

                        <!-- Title -->
                        <x-form.input
                            label="Title"
                            name="title"
                            type="text"
                            :value="old('title', $maintenanceRequest->title)"
                            :required="true"
                            class="md:col-span-2"
                            placeholder="Brief description of the issue"
                        />

                        <!-- Priority -->
                        <x-form.select
                            label="Priority"
                            name="priority"
                            :options="collect($priorities)->pluck('label', 'value')"
                            :value="old('priority', $maintenanceRequest->priority->value)"
                            :required="true"
                            help="Set the priority level"
                        />

                        <!-- Scheduled Date -->
                        <x-form.input
                            label="Scheduled Date"
                            name="scheduled_date"
                            type="date"
                            :value="old('scheduled_date', $maintenanceRequest->scheduled_date?->format('Y-m-d'))"
                            help="When should this be addressed?"
                        />

                        <!-- Assigned To -->
                        <x-form.select
                            label="Assign To"
                            name="assigned_to"
                            :options="$users->pluck('name', 'id')"
                            :value="old('assigned_to', $maintenanceRequest->assigned_to)"
                            help="Assign to a user (optional)"
                        />
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <x-form.textarea
                            label="Description"
                            name="description"
                            :value="old('description', $maintenanceRequest->description)"
                            :required="true"
                            rows="4"
                            placeholder="Detailed description of the maintenance issue"
                        />
                    </div>

                    <!-- Notes -->
                    <div class="mt-4">
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            :value="old('notes', $maintenanceRequest->notes)"
                            rows="3"
                            placeholder="Additional notes or special instructions"
                        />
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('maintenance-requests.show', $maintenanceRequest) }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Update Maintenance Request
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    @push('scripts')
    <script>
        // Load units based on selected property
        document.getElementById('property_id').addEventListener('change', function() {
            const propertyId = this.value;
            const unitSelect = document.getElementById('unit_id');

            if (!propertyId) {
                unitSelect.innerHTML = '<option value="">Select Unit</option>';
                return;
            }

            // Fetch units for the selected property
            fetch(`/api/properties/${propertyId}/units`)
                .then(response => response.json())
                .then(data => {
                    unitSelect.innerHTML = '<option value="">Select Unit</option>';
                    data.forEach(unit => {
                        const option = document.createElement('option');
                        option.value = unit.id;
                        option.textContent = unit.unit_number;
                        unitSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading units:', error);
                });
        });
    </script>
    @endpush
</x-app-layout>

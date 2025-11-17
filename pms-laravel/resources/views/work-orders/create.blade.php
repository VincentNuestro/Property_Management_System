<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Work Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($maintenanceRequest)
                <!-- Linked Maintenance Request Info -->
                <x-card class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Linked Maintenance Request</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                <strong>{{ $maintenanceRequest->request_number }}</strong> - {{ $maintenanceRequest->title }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Property: {{ $maintenanceRequest->property->name }}
                                @if($maintenanceRequest->unit)
                                    | Unit: {{ $maintenanceRequest->unit->unit_number }}
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('maintenance-requests.show', $maintenanceRequest) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                            View Request
                        </a>
                    </div>
                </x-card>
            @endif

            <x-card>
                <form method="POST" action="{{ route('work-orders.store') }}">
                    @csrf

                    @if($maintenanceRequest)
                        <input type="hidden" name="maintenance_request_id" value="{{ $maintenanceRequest->id }}">
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Type -->
                        <x-form.select
                            label="Work Order Type"
                            name="type"
                            :options="$types"
                            :required="true"
                            help="Select the type of work order"
                        />

                        <!-- Title -->
                        <x-form.input
                            label="Title"
                            name="title"
                            type="text"
                            :required="true"
                            :value="$maintenanceRequest ? $maintenanceRequest->title : ''"
                        />

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <x-form.textarea
                                label="Description"
                                name="description"
                                :required="true"
                                :value="$maintenanceRequest ? $maintenanceRequest->description : ''"
                                help="Detailed description of the work to be performed"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Assignment</h3>

                        <!-- Assignment Type -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assignment Type <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        name="assignment_type"
                                        value="internal"
                                        {{ old('assignment_type', 'internal') === 'internal' ? 'checked' : '' }}
                                        class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        onchange="toggleAssignmentFields()"
                                    >
                                    <span class="ml-2 text-sm text-gray-700">Internal Staff</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        name="assignment_type"
                                        value="external"
                                        {{ old('assignment_type') === 'external' ? 'checked' : '' }}
                                        class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        onchange="toggleAssignmentFields()"
                                    >
                                    <span class="ml-2 text-sm text-gray-700">External Vendor</span>
                                </label>
                            </div>
                            @error('assignment_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Internal Assignment -->
                            <div id="internal-fields" class="md:col-span-2">
                                <x-form.select
                                    label="Assigned To"
                                    name="assigned_to"
                                    :options="$users->pluck('name', 'id')->toArray()"
                                    help="Select user to assign this work order"
                                />
                            </div>

                            <!-- External Assignment -->
                            <div id="external-fields" class="md:col-span-2 hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-form.input
                                        label="Vendor Name"
                                        name="vendor_name"
                                        type="text"
                                    />

                                    <x-form.input
                                        label="Vendor Contact"
                                        name="vendor_contact"
                                        type="text"
                                        help="Phone number or email"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Schedule & Cost</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Scheduled Date -->
                            <x-form.input
                                label="Scheduled Date"
                                name="scheduled_date"
                                type="date"
                            />

                            <!-- Estimated Cost -->
                            <x-form.input
                                label="Estimated Cost"
                                name="estimated_cost"
                                type="number"
                                step="0.01"
                                min="0"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <!-- Notes -->
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            help="Additional notes or instructions"
                        />
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('work-orders.index') }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Create Work Order
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    <script>
        function toggleAssignmentFields() {
            const assignmentType = document.querySelector('input[name="assignment_type"]:checked').value;
            const internalFields = document.getElementById('internal-fields');
            const externalFields = document.getElementById('external-fields');

            if (assignmentType === 'internal') {
                internalFields.classList.remove('hidden');
                externalFields.classList.add('hidden');
            } else {
                internalFields.classList.add('hidden');
                externalFields.classList.remove('hidden');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleAssignmentFields();
        });
    </script>
</x-app-layout>

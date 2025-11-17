<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Work Order') }} - {{ $workOrder->work_order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('work-orders.update', $workOrder) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Type -->
                        <x-form.select
                            label="Work Order Type"
                            name="type"
                            :options="$types"
                            :value="$workOrder->type->value"
                            :required="true"
                        />

                        <!-- Title -->
                        <x-form.input
                            label="Title"
                            name="title"
                            type="text"
                            :value="$workOrder->title"
                            :required="true"
                        />

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <x-form.textarea
                                label="Description"
                                name="description"
                                :value="$workOrder->description"
                                :required="true"
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
                                        {{ old('assignment_type', $workOrder->assigned_to ? 'internal' : 'external') === 'internal' ? 'checked' : '' }}
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
                                        {{ old('assignment_type', $workOrder->assigned_to ? 'internal' : 'external') === 'external' ? 'checked' : '' }}
                                        class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        onchange="toggleAssignmentFields()"
                                    >
                                    <span class="ml-2 text-sm text-gray-700">External Vendor</span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Internal Assignment -->
                            <div id="internal-fields" class="md:col-span-2">
                                <x-form.select
                                    label="Assigned To"
                                    name="assigned_to"
                                    :options="$users->pluck('name', 'id')->toArray()"
                                    :value="$workOrder->assigned_to"
                                />
                            </div>

                            <!-- External Assignment -->
                            <div id="external-fields" class="md:col-span-2 hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-form.input
                                        label="Vendor Name"
                                        name="vendor_name"
                                        type="text"
                                        :value="$workOrder->vendor_name"
                                    />

                                    <x-form.input
                                        label="Vendor Contact"
                                        name="vendor_contact"
                                        type="text"
                                        :value="$workOrder->vendor_contact"
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
                                :value="$workOrder->scheduled_date ? $workOrder->scheduled_date->format('Y-m-d') : ''"
                            />

                            <!-- Estimated Cost -->
                            <x-form.input
                                label="Estimated Cost"
                                name="estimated_cost"
                                type="number"
                                step="0.01"
                                min="0"
                                :value="$workOrder->estimated_cost"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <!-- Notes -->
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            :value="$workOrder->notes"
                        />
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('work-orders.show', $workOrder) }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Update Work Order
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

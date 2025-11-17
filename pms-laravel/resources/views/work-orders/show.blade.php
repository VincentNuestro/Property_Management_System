<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Work Order: {{ $workOrder->work_order_number }}
            </h2>
            <div class="flex space-x-2">
                @can('work_orders.edit')
                    @if(in_array($workOrder->status->value, ['draft', 'scheduled', 'in_progress']))
                        <a href="{{ route('work-orders.edit', $workOrder) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Work Order
                        </a>
                    @endif
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Work Order Details -->
            <x-card title="Work Order Details">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Work Order Number</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $workOrder->work_order_number }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-1">
                            <x-badge :color="$workOrder->status->color()">
                                {{ $workOrder->status->label() }}
                            </x-badge>
                            @if($workOrder->is_overdue)
                                <x-badge color="red" class="ml-2">Overdue</x-badge>
                            @endif
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Type</h4>
                        <p class="mt-1">
                            <x-badge color="purple">{{ $workOrder->type->label() }}</x-badge>
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Assignment Type</h4>
                        <p class="mt-1">
                            @if($workOrder->assigned_to)
                                <x-badge color="blue">Internal</x-badge>
                            @elseif($workOrder->vendor_name)
                                <x-badge color="green">External</x-badge>
                            @else
                                <x-badge color="gray">Unassigned</x-badge>
                            @endif
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Title</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $workOrder->title }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Description</h4>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $workOrder->description }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Linked Maintenance Request -->
            @if($workOrder->maintenanceRequest)
                <x-card title="Linked Maintenance Request">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Request Number</h4>
                            <p class="mt-1 text-sm">
                                <a href="{{ route('maintenance-requests.show', $workOrder->maintenanceRequest) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $workOrder->maintenanceRequest->request_number }}
                                </a>
                            </p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Property</h4>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $workOrder->maintenanceRequest->property->name }}
                                @if($workOrder->maintenanceRequest->unit)
                                    - Unit {{ $workOrder->maintenanceRequest->unit->unit_number }}
                                @endif
                            </p>
                        </div>
                    </div>
                </x-card>
            @endif

            <!-- Assignment Information -->
            <x-card title="Assignment Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($workOrder->assignedUser)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Assigned To</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $workOrder->assignedUser->name }}</p>
                        </div>
                    @elseif($workOrder->vendor_name)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Vendor Name</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $workOrder->vendor_name }}</p>
                        </div>

                        @if($workOrder->vendor_contact)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Vendor Contact</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $workOrder->vendor_contact }}</p>
                            </div>
                        @endif
                    @else
                        <div>
                            <p class="text-sm text-gray-500 italic">Not yet assigned</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Timeline -->
            <x-card title="Timeline">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Created</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $workOrder->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Scheduled</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $workOrder->scheduled_date ? $workOrder->scheduled_date->format('M d, Y') : '-' }}
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Started</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $workOrder->started_date ? $workOrder->started_date->format('M d, Y') : '-' }}
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Completed</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $workOrder->completed_date ? $workOrder->completed_date->format('M d, Y') : '-' }}
                        </p>
                    </div>

                    @if($workOrder->duration_days !== null)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Duration</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $workOrder->duration_days }} day(s)</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Cost Information -->
            <x-card title="Cost Information">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Estimated Cost</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $workOrder->estimated_cost ? '$' . number_format($workOrder->estimated_cost, 2) : '-' }}
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Actual Cost</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $workOrder->actual_cost ? '$' . number_format($workOrder->actual_cost, 2) : '-' }}
                        </p>
                    </div>

                    @if($workOrder->cost_variance !== null)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Variance</h4>
                            <p class="mt-1 text-sm {{ $workOrder->cost_variance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $workOrder->cost_variance > 0 ? '+' : '' }}${{ number_format($workOrder->cost_variance, 2) }}
                                ({{ $workOrder->cost_variance > 0 ? '+' : '' }}{{ number_format($workOrder->cost_variance_percentage, 1) }}%)
                            </p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Completion Notes -->
            @if($workOrder->completion_notes)
                <x-card title="Completion Notes">
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $workOrder->completion_notes }}</p>
                </x-card>
            @endif

            <!-- Notes -->
            @if($workOrder->notes)
                <x-card title="Notes">
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $workOrder->notes }}</p>
                </x-card>
            @endif

            <!-- Action Buttons -->
            <x-card title="Actions">
                <div class="flex flex-wrap gap-3">
                    @can('schedule', $workOrder)
                        @if(in_array($workOrder->status->value, ['draft']))
                            <button onclick="showScheduleModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Schedule
                            </button>
                        @endif
                    @endcan

                    @can('start', $workOrder)
                        @if(in_array($workOrder->status->value, ['draft', 'scheduled']))
                            <form action="{{ route('work-orders.start', $workOrder) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Start this work order?')">
                                    Start Work
                                </button>
                            </form>
                        @endif
                    @endcan

                    @can('complete', $workOrder)
                        @if(in_array($workOrder->status->value, ['in_progress']))
                            <button onclick="showCompleteModal()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Complete
                            </button>
                        @endif
                    @endcan

                    @can('update', $workOrder)
                        @if(in_array($workOrder->status->value, ['draft', 'scheduled', 'in_progress']))
                            <button onclick="showCancelModal()" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </button>

                            <button onclick="showHoldModal()" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Put on Hold
                            </button>
                        @endif
                    @endcan
                </div>
            </x-card>
        </div>
    </div>

    <!-- Schedule Modal -->
    <div id="scheduleModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Schedule Work Order</h3>
            <form action="{{ route('work-orders.schedule', $workOrder) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="scheduled_date" class="block text-sm font-medium text-gray-700 mb-2">Scheduled Date <span class="text-red-500">*</span></label>
                    <input type="date" name="scheduled_date" id="scheduled_date" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideScheduleModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Complete Modal -->
    <div id="completeModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Complete Work Order</h3>
            <form action="{{ route('work-orders.complete', $workOrder) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="actual_cost" class="block text-sm font-medium text-gray-700 mb-2">Actual Cost</label>
                    <input type="number" name="actual_cost" id="actual_cost" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="mb-4">
                    <label for="completion_notes" class="block text-sm font-medium text-gray-700 mb-2">Completion Notes</label>
                    <textarea name="completion_notes" id="completion_notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideCompleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Complete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancelModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Cancel Work Order</h3>
            <form action="{{ route('work-orders.cancel', $workOrder) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-2">Cancellation Reason <span class="text-red-500">*</span></label>
                    <textarea name="cancellation_reason" id="cancellation_reason" rows="3" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideCancelModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Confirm Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hold Modal -->
    <div id="holdModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Put Work Order on Hold</h3>
            <form action="{{ route('work-orders.put-on-hold', $workOrder) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="hold_reason" class="block text-sm font-medium text-gray-700 mb-2">Hold Reason <span class="text-red-500">*</span></label>
                    <textarea name="hold_reason" id="hold_reason" rows="3" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideHoldModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">
                        Put on Hold
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showScheduleModal() {
            document.getElementById('scheduleModal').classList.remove('hidden');
        }
        function hideScheduleModal() {
            document.getElementById('scheduleModal').classList.add('hidden');
        }

        function showCompleteModal() {
            document.getElementById('completeModal').classList.remove('hidden');
        }
        function hideCompleteModal() {
            document.getElementById('completeModal').classList.add('hidden');
        }

        function showCancelModal() {
            document.getElementById('cancelModal').classList.remove('hidden');
        }
        function hideCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
        }

        function showHoldModal() {
            document.getElementById('holdModal').classList.remove('hidden');
        }
        function hideHoldModal() {
            document.getElementById('holdModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = ['scheduleModal', 'completeModal', 'cancelModal', 'holdModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }
    </script>
</x-app-layout>

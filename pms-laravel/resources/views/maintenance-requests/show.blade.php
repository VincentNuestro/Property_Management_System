<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Maintenance Request: {{ $maintenanceRequest->request_number }}
            </h2>
            @can('maintenance_requests.edit')
                @if(in_array($maintenanceRequest->status->value, ['submitted', 'acknowledged', 'assigned', 'in_progress']))
                    <a href="{{ route('maintenance-requests.edit', $maintenanceRequest) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Edit Request
                    </a>
                @endif
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif

            <!-- Request Details -->
            <x-card title="Request Details">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Request Number</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $maintenanceRequest->request_number }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Category</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $maintenanceRequest->category }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Title</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $maintenanceRequest->title }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Description</h4>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $maintenanceRequest->description }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Priority</h4>
                        <p class="mt-1">
                            <x-badge :color="$maintenanceRequest->priority->color()">
                                {{ $maintenanceRequest->priority->label() }}
                            </x-badge>
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-1">
                            <x-badge :color="$maintenanceRequest->status->color()">
                                {{ $maintenanceRequest->status->label() }}
                            </x-badge>
                        </p>
                    </div>
                </div>
            </x-card>

            <!-- Property & Unit Information -->
            <x-card title="Location">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Property</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($maintenanceRequest->property)
                                <a href="{{ route('properties.show', $maintenanceRequest->property) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $maintenanceRequest->property->name }}
                                </a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Unit</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $maintenanceRequest->unit?->unit_number ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Reported By</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($maintenanceRequest->tenant)
                                <a href="{{ route('tenants.show', $maintenanceRequest->tenant) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $maintenanceRequest->tenant->full_name }}
                                </a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </x-card>

            <!-- Timeline -->
            <x-card title="Timeline">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Request Date</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $maintenanceRequest->request_date->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $maintenanceRequest->request_date->diffForHumans() }}</p>
                    </div>

                    @if($maintenanceRequest->scheduled_date)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Scheduled Date</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $maintenanceRequest->scheduled_date->format('M d, Y') }}</p>
                            @if($maintenanceRequest->is_overdue)
                                <p class="text-xs text-red-600 font-semibold">Overdue!</p>
                            @endif
                        </div>
                    @endif

                    @if($maintenanceRequest->completed_date)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Completed Date</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $maintenanceRequest->completed_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $maintenanceRequest->completed_date->diffForHumans() }}</p>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Days Open</h4>
                        <p class="mt-1 text-2xl font-bold text-gray-900">{{ $maintenanceRequest->days_open }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Assignment -->
            <x-card title="Assignment">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Assigned To</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $maintenanceRequest->assignedUser?->name ?? 'Unassigned' }}
                        </p>
                    </div>

                    @can('maintenance_requests.assign')
                        @if(!in_array($maintenanceRequest->status->value, ['completed', 'cancelled']))
                            <button
                                onclick="document.getElementById('assignModal').classList.remove('hidden')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                {{ $maintenanceRequest->assigned_to ? 'Reassign' : 'Assign' }}
                            </button>
                        @endif
                    @endcan
                </div>
            </x-card>

            <!-- Action Buttons -->
            <x-card title="Actions">
                <div class="flex flex-wrap gap-3">
                    @can('maintenance_requests.edit')
                        @if(in_array($maintenanceRequest->status->value, ['submitted', 'acknowledged', 'assigned']))
                            <form action="{{ route('maintenance-requests.start', $maintenanceRequest) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Start Work
                                </button>
                            </form>
                        @endif
                    @endcan

                    @can('maintenance_requests.complete')
                        @if(!in_array($maintenanceRequest->status->value, ['completed', 'cancelled']))
                            <button
                                onclick="document.getElementById('completeModal').classList.remove('hidden')"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Mark as Completed
                            </button>
                        @endif
                    @endcan

                    @can('maintenance_requests.edit')
                        @if(!in_array($maintenanceRequest->status->value, ['completed', 'cancelled']))
                            <button
                                onclick="document.getElementById('cancelModal').classList.remove('hidden')"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Cancel Request
                            </button>
                        @endif
                    @endcan

                    @can('work_orders.create')
                        <form action="{{ route('maintenance-requests.create-work-order', $maintenanceRequest) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Create Work Order
                            </button>
                        </form>
                    @endcan
                </div>
            </x-card>

            <!-- Work Orders -->
            @if($maintenanceRequest->workOrders->count() > 0)
                <x-card title="Related Work Orders">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Work Order #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Assigned To
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Scheduled
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($maintenanceRequest->workOrders as $workOrder)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $workOrder->work_order_number }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $workOrder->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $workOrder->assignedUser?->name ?? 'Unassigned' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-badge :color="$workOrder->status->color()">
                                                {{ $workOrder->status->label() }}
                                            </x-badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $workOrder->scheduled_start_date?->format('M d, Y') ?? 'Not scheduled' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @endif

            <!-- Notes -->
            @if($maintenanceRequest->notes)
                <x-card title="Notes">
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $maintenanceRequest->notes }}</p>
                </x-card>
            @endif
        </div>
    </div>

    <!-- Assign Modal -->
    <div id="assignModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Assign Maintenance Request</h3>
                <form action="{{ route('maintenance-requests.assign', $maintenanceRequest) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-2">Assign To</label>
                        <select name="assigned_to" id="assigned_to" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $maintenanceRequest->assigned_to == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('assignModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Assign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Complete Modal -->
    <div id="completeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Complete Maintenance Request</h3>
                <form action="{{ route('maintenance-requests.complete', $maintenanceRequest) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="completion_notes" class="block text-sm font-medium text-gray-700 mb-2">Completion Notes (Optional)</label>
                        <textarea name="completion_notes" id="completion_notes" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Add any completion notes..."></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('completeModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Mark as Completed
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancelModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Cancel Maintenance Request</h3>
                <form action="{{ route('maintenance-requests.cancel', $maintenanceRequest) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-2">Cancellation Reason</label>
                        <textarea name="cancellation_reason" id="cancellation_reason" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Please provide a reason for cancellation..."></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Cancel Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

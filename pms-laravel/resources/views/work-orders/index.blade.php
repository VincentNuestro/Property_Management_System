<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Work Orders') }}
            </h2>
            @can('work_orders.create')
                <a href="{{ route('work-orders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Create Work Order
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <x-card class="mb-6">
                <form method="GET" action="{{ route('work-orders.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ request('search') }}"
                                placeholder="Search work orders..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Statuses</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status['value'] }}" {{ request('status') == $status['value'] ? 'selected' : '' }}>
                                        {{ $status['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type Filter -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="type" id="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type['value'] }}" {{ request('type') == $type['value'] ? 'selected' : '' }}>
                                        {{ $type['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Assigned User Filter -->
                        <div>
                            <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-1">Assigned To</label>
                            <select name="assigned_to" id="assigned_to" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Filter
                            </button>
                        </div>
                    </div>

                    <!-- Overdue Checkbox -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                name="overdue"
                                id="overdue"
                                value="1"
                                {{ request('overdue') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            <label for="overdue" class="ml-2 text-sm text-gray-700">Show only overdue work orders</label>
                        </div>

                        @if(request()->hasAny(['search', 'status', 'type', 'assigned_to', 'overdue']))
                            <a href="{{ route('work-orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </form>
            </x-card>

            <!-- Work Orders Table -->
            <x-card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    WO Number
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Maintenance Request
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Assigned To
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Scheduled Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Est. Cost
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($workOrders as $workOrder)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $workOrder->work_order_number }}
                                        @if($workOrder->is_overdue)
                                            <span class="ml-1 text-red-500" title="Overdue">
                                                <svg class="inline-block w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($workOrder->maintenanceRequest)
                                            <a href="{{ route('maintenance-requests.show', $workOrder->maintenanceRequest) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ $workOrder->maintenanceRequest->request_number }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <x-badge color="purple">
                                            {{ $workOrder->type->label() }}
                                        </x-badge>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <a href="{{ route('work-orders.show', $workOrder) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                            {{ $workOrder->title }}
                                        </a>
                                        <div class="text-xs text-gray-500 mt-1">
                                            @if($workOrder->assigned_to)
                                                <x-badge color="blue" class="text-xs">Internal</x-badge>
                                            @elseif($workOrder->vendor_name)
                                                <x-badge color="green" class="text-xs">External</x-badge>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($workOrder->assignedUser)
                                            {{ $workOrder->assignedUser->name }}
                                        @elseif($workOrder->vendor_name)
                                            {{ $workOrder->vendor_name }}
                                        @else
                                            <span class="text-gray-400">Unassigned</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $workOrder->scheduled_date ? $workOrder->scheduled_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $workOrder->estimated_cost ? '$' . number_format($workOrder->estimated_cost, 2) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge :color="$workOrder->status->color()">
                                            {{ $workOrder->status->label() }}
                                        </x-badge>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('work-orders.show', $workOrder) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        @can('work_orders.edit')
                                            @if(in_array($workOrder->status->value, ['draft', 'scheduled', 'in_progress']))
                                                <a href="{{ route('work-orders.edit', $workOrder) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            @endif
                                        @endcan
                                        @can('work_orders.delete')
                                            @if($workOrder->status->value === 'draft')
                                                <form action="{{ route('work-orders.destroy', $workOrder) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this work order?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No work orders found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($workOrders->hasPages())
                    <div class="mt-4">
                        {{ $workOrders->links() }}
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>

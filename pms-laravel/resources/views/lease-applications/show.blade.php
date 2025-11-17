<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lease Application - {{ $leaseApplication->application_number }}
            </h2>
            <div class="flex items-center space-x-2">
                @can('lease_applications.edit')
                    @if(in_array($leaseApplication->status, [App\Enums\LeaseApplicationStatus::DRAFT, App\Enums\LeaseApplicationStatus::SUBMITTED]))
                        <a href="{{ route('lease-applications.edit', $leaseApplication) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Application
                        </a>
                    @endif
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Workflow Actions -->
            @if($leaseApplication->is_pending)
                <x-card>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Workflow Actions</h3>
                    <div class="flex flex-wrap gap-3">
                        <!-- Submit (DRAFT → SUBMITTED) -->
                        @if($leaseApplication->status === App\Enums\LeaseApplicationStatus::DRAFT)
                            @can('lease_applications.edit')
                                <form action="{{ route('lease-applications.submit', $leaseApplication) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Submit this application for review?')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Submit for Review
                                    </button>
                                </form>
                            @endcan
                        @endif

                        <!-- Review (SUBMITTED → UNDER_REVIEW) -->
                        @if($leaseApplication->status === App\Enums\LeaseApplicationStatus::SUBMITTED)
                            @can('lease_applications.review')
                                <form action="{{ route('lease-applications.review', $leaseApplication) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Start reviewing this application?')" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Start Review
                                    </button>
                                </form>
                            @endcan
                        @endif

                        <!-- Approve (UNDER_REVIEW → APPROVED) -->
                        @if($leaseApplication->status === App\Enums\LeaseApplicationStatus::UNDER_REVIEW)
                            @can('lease_applications.approve')
                                <form action="{{ route('lease-applications.approve', $leaseApplication) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Approve this application?')" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Approve Application
                                    </button>
                                </form>
                            @endcan
                        @endif

                        <!-- Reject (any → REJECTED) -->
                        @if($leaseApplication->status !== App\Enums\LeaseApplicationStatus::REJECTED && $leaseApplication->status !== App\Enums\LeaseApplicationStatus::CANCELLED)
                            @can('lease_applications.approve')
                                <button onclick="showRejectModal()" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Reject Application
                                </button>
                            @endcan
                        @endif
                    </div>
                </x-card>
            @endif

            <!-- Convert to Contract -->
            @if($leaseApplication->status === App\Enums\LeaseApplicationStatus::APPROVED)
                @can('lease_contracts.create')
                    <x-card>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Next Steps</h3>
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">This application has been approved and is ready to be converted to a lease contract.</p>
                            <form action="{{ route('lease-applications.convert-to-contract', $leaseApplication) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Convert this application to a lease contract?')" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Convert to Contract
                                </button>
                            </form>
                        </div>
                    </x-card>
                @endcan
            @endif

            <!-- Application Details -->
            <x-card title="Application Details">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Application Number</h4>
                        <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $leaseApplication->application_number }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-1">
                            <x-badge :color="$leaseApplication->status->color()">
                                {{ $leaseApplication->status->label() }}
                            </x-badge>
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Application Date</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseApplication->application_date->format('F d, Y') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Desired Start Date</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseApplication->desired_start_date->format('F d, Y') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Desired Lease Term</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseApplication->desired_lease_term }} {{ $leaseApplication->desired_lease_term == 1 ? 'month' : 'months' }}</p>
                    </div>

                    @if($leaseApplication->reviewed_by)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Reviewed By</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $leaseApplication->reviewedBy->name }}</p>
                        </div>
                    @endif

                    @if($leaseApplication->reviewed_at)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Reviewed At</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $leaseApplication->reviewed_at->format('F d, Y h:i A') }}</p>
                        </div>
                    @endif
                </div>

                @if($leaseApplication->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Notes</h4>
                        <p class="text-sm text-gray-900 whitespace-pre-line">{{ $leaseApplication->notes }}</p>
                    </div>
                @endif

                @if($leaseApplication->rejection_reason)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-red-500 mb-2">Rejection Reason</h4>
                        <p class="text-sm text-gray-900 whitespace-pre-line">{{ $leaseApplication->rejection_reason }}</p>
                    </div>
                @endif
            </x-card>

            <!-- Property Information -->
            <x-card title="Property Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Property Name</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="{{ route('properties.show', $leaseApplication->property) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ $leaseApplication->property->name }}
                            </a>
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Property Code</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseApplication->property->code }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Property Address</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseApplication->property->full_address ?: 'N/A' }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Tenant Information -->
            <x-card title="Tenant Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Tenant Name</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="{{ route('tenants.show', $leaseApplication->tenant) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ $leaseApplication->tenant->full_name }}
                            </a>
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Tenant Type</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaseApplication->tenant->tenant_type->label() }}</p>
                    </div>

                    @if($leaseApplication->tenant->email)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Email</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $leaseApplication->tenant->email }}</p>
                        </div>
                    @endif

                    @if($leaseApplication->tenant->primary_contact)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Contact Number</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $leaseApplication->tenant->primary_contact }}</p>
                        </div>
                    @endif
                </div>
            </x-card>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hideRejectModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('lease-applications.reject', $leaseApplication) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Reject Application
                                </h3>
                                <div class="mt-4">
                                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                        Rejection Reason <span class="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        name="rejection_reason"
                                        id="rejection_reason"
                                        rows="4"
                                        required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Please provide a reason for rejecting this application..."
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Reject Application
                        </button>
                        <button type="button" onclick="hideRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejection_reason').value = '';
        }
    </script>
</x-app-layout>

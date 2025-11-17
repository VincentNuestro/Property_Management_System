<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inquiry Details') }} - {{ $inquiry->inquiry_number }}
            </h2>
            <div class="flex space-x-2">
                @can('inquiries.edit')
                    @if(in_array($inquiry->status, [\App\Enums\InquiryStatus::NEW, \App\Enums\InquiryStatus::CONTACTED]))
                        <a href="{{ route('inquiries.edit', $inquiry) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Inquiry
                        </a>
                    @endif
                @endcan

                @if(in_array($inquiry->status, [\App\Enums\InquiryStatus::QUALIFIED, \App\Enums\InquiryStatus::PROPOSAL_SENT]))
                    <form action="{{ route('inquiries.convert', $inquiry) }}" method="POST" onsubmit="return confirm('Are you sure you want to convert this inquiry to a reservation?');">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Convert to Reservation
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Inquiry Overview -->
            <x-card title="Inquiry Overview">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Inquiry Number</h4>
                        <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $inquiry->inquiry_number }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-1">
                            <x-badge :color="$inquiry->status->color()">
                                {{ $inquiry->status->label() }}
                            </x-badge>
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Date Created</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $inquiry->created_at->format('F d, Y g:i A') }}</p>
                    </div>

                    @if($inquiry->source)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Source</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $inquiry->source }}</p>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Assigned To</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $inquiry->assignedUser?->name ?: 'Unassigned' }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Property Information -->
            <x-card title="Property Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Property</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($inquiry->property)
                                <a href="{{ route('properties.show', $inquiry->property) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $inquiry->property->name }}
                                </a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    @if($inquiry->space_type)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Space Type</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $inquiry->space_type }}</p>
                        </div>
                    @endif

                    @if($inquiry->desired_area_sqm)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Desired Area</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ number_format($inquiry->desired_area_sqm, 2) }} sqm</p>
                        </div>
                    @endif

                    @if($inquiry->desired_move_in_date)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Desired Move-in Date</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $inquiry->desired_move_in_date->format('F d, Y') }}</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Inquirer Information -->
            <x-card title="Inquirer Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Name</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $inquiry->inquirer_name }}</p>
                    </div>

                    @if($inquiry->company_name)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Company</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $inquiry->company_name }}</p>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Email</h4>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="mailto:{{ $inquiry->inquirer_email }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ $inquiry->inquirer_email }}
                            </a>
                        </p>
                    </div>

                    @if($inquiry->inquirer_phone)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $inquiry->inquirer_phone }}</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Budget Information -->
            @if($inquiry->budget_min || $inquiry->budget_max)
                <x-card title="Budget Information">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($inquiry->budget_min)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Minimum Budget</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ config('pms.currency.symbol') }}{{ number_format($inquiry->budget_min, 2) }}</p>
                            </div>
                        @endif

                        @if($inquiry->budget_max)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Maximum Budget</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ config('pms.currency.symbol') }}{{ number_format($inquiry->budget_max, 2) }}</p>
                            </div>
                        @endif

                        @if($inquiry->budget_range)
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-500">Budget Range</h4>
                                <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $inquiry->budget_range }}</p>
                            </div>
                        @endif
                    </div>
                </x-card>
            @endif

            <!-- Notes -->
            @if($inquiry->notes)
                <x-card title="Notes">
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $inquiry->notes }}</p>
                </x-card>
            @endif

            <!-- Actions -->
            <x-card title="Actions">
                <div class="flex flex-wrap gap-2">
                    @can('inquiries.edit')
                        @if(in_array($inquiry->status, [\App\Enums\InquiryStatus::NEW, \App\Enums\InquiryStatus::CONTACTED]))
                            <a href="{{ route('inquiries.edit', $inquiry) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Edit Inquiry
                            </a>
                        @endif
                    @endcan

                    @if(in_array($inquiry->status, [\App\Enums\InquiryStatus::QUALIFIED, \App\Enums\InquiryStatus::PROPOSAL_SENT]))
                        <form action="{{ route('inquiries.convert', $inquiry) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to convert this inquiry to a reservation?');">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Convert to Reservation
                            </button>
                        </form>
                    @endif

                    @can('inquiries.delete')
                        @if(in_array($inquiry->status, [\App\Enums\InquiryStatus::NEW, \App\Enums\InquiryStatus::LOST]))
                            <form action="{{ route('inquiries.destroy', $inquiry) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Delete Inquiry
                                </button>
                            </form>
                        @endif
                    @endcan

                    <a href="{{ route('inquiries.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Back to List
                    </a>
                </div>
            </x-card>

            <!-- Activity Log (if applicable) -->
            @if($inquiry->activities()->exists())
                <x-card title="Activity Log">
                    <div class="space-y-4">
                        @foreach($inquiry->activities()->latest()->limit(10)->get() as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        {{ $activity->description }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $activity->created_at->diffForHumans() }}
                                        @if($activity->causer)
                                            by {{ $activity->causer->name }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            @endif
        </div>
    </div>
</x-app-layout>

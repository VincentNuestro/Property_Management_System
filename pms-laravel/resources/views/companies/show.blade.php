<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $company->display_name }}
            </h2>
            @can('companies.edit')
                <a href="{{ route('companies.edit', $company) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Company
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Company Details -->
            <x-card title="Company Details">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Company Name</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $company->name }}</p>
                    </div>

                    @if($company->trade_name)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Trade Name</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $company->trade_name }}</p>
                        </div>
                    @endif

                    @if($company->business_type)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Business Type</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $company->business_type }}</p>
                        </div>
                    @endif

                    @if($company->industry)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Industry</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $company->industry }}</p>
                        </div>
                    @endif

                    @if($company->tax_id)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Tax ID</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $company->tax_id }}</p>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-1">
                            <x-badge :color="$company->status === 'active' ? 'green' : 'gray'">
                                {{ ucfirst($company->status) }}
                            </x-badge>
                        </p>
                    </div>
                </div>
            </x-card>

            <!-- Contact Information -->
            <x-card title="Contact Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($company->email)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Email</h4>
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $company->email }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $company->email }}
                                </a>
                            </p>
                        </div>
                    @endif

                    @if($company->phone)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $company->phone }}</p>
                        </div>
                    @endif

                    @if($company->website)
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-medium text-gray-500">Website</h4>
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="{{ $company->website }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $company->website }}
                                </a>
                            </p>
                        </div>
                    @endif

                    @if($company->full_address)
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-medium text-gray-500">Address</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $company->full_address }}</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Notes -->
            @if($company->notes)
                <x-card title="Notes">
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $company->notes }}</p>
                </x-card>
            @endif

            <!-- Tenants -->
            <x-card title="Tenants">
                @if($tenants->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contact
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
                                @foreach($tenants as $tenant)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('tenants.show', $tenant) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                                {{ $tenant->full_name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $tenant->email ?: 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $tenant->primary_contact ?: 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-badge :color="$tenant->status->color()">
                                                {{ $tenant->status->label() }}
                                            </x-badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('tenants.show', $tenant) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($tenants->hasPages())
                        <div class="mt-4">
                            {{ $tenants->links() }}
                        </div>
                    @endif
                @else
                    <p class="text-sm text-gray-500">No tenants associated with this company.</p>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>

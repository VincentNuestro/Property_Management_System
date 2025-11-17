<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lease Contract') }} - {{ $leaseContract->contract_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('lease-contracts.update', $leaseContract) }}" id="leaseContractForm">
                    @csrf
                    @method('PUT')

                    <!-- Contract Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contract Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Property -->
                            <x-form.select
                                label="Property"
                                name="property_id"
                                :options="$properties->mapWithKeys(fn($p) => [$p->id => $p->name])->toArray()"
                                :required="true"
                                :value="$leaseContract->property_id"
                                help="Select the property for this lease"
                            />

                            <!-- Tenant -->
                            <x-form.select
                                label="Tenant"
                                name="tenant_id"
                                :options="$tenants->mapWithKeys(fn($t) => [$t->id => $t->last_name . ', ' . $t->first_name])->toArray()"
                                :required="true"
                                :value="$leaseContract->tenant_id"
                                help="Select the tenant for this lease"
                            />

                            <!-- Contract Number -->
                            <x-form.input
                                label="Contract Number"
                                name="contract_number"
                                type="text"
                                :value="$leaseContract->contract_number"
                            />

                            <!-- Contract Date -->
                            <x-form.input
                                label="Contract Date"
                                name="contract_date"
                                type="date"
                                :value="$leaseContract->contract_date?->format('Y-m-d')"
                            />

                            <!-- Start Date -->
                            <x-form.input
                                label="Start Date"
                                name="start_date"
                                type="date"
                                :required="true"
                                :value="$leaseContract->start_date->format('Y-m-d')"
                            />

                            <!-- End Date -->
                            <x-form.input
                                label="End Date"
                                name="end_date"
                                type="date"
                                :required="true"
                                :value="$leaseContract->end_date->format('Y-m-d')"
                            />

                            <!-- Billing Cycle -->
                            <x-form.select
                                label="Billing Cycle"
                                name="billing_cycle"
                                :options="collect($billingCycles)->mapWithKeys(fn($c) => [$c['value'] => $c['label']])->toArray()"
                                :required="true"
                                :value="$leaseContract->billing_cycle->value"
                            />

                            <!-- Billing Day -->
                            <x-form.input
                                label="Billing Day"
                                name="billing_day"
                                type="number"
                                min="1"
                                max="31"
                                :value="$leaseContract->billing_day"
                                help="Day of month for billing (1-31)"
                            />
                        </div>
                    </div>

                    <!-- Financial Terms -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Terms</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Security Deposit -->
                            <x-form.input
                                label="Security Deposit"
                                name="security_deposit"
                                type="number"
                                step="0.01"
                                min="0"
                                :value="$leaseContract->security_deposit"
                                help="Amount held as security"
                            />

                            <!-- Advance Rent Months -->
                            <x-form.input
                                label="Advance Rent (Months)"
                                name="advance_rent_months"
                                type="number"
                                min="0"
                                max="12"
                                :value="$leaseContract->advance_rent_months"
                                help="Number of months rent paid in advance"
                            />

                            <!-- Escalation Rate -->
                            <x-form.input
                                label="Escalation Rate (%)"
                                name="escalation_rate"
                                type="number"
                                step="0.01"
                                min="0"
                                max="100"
                                :value="$leaseContract->escalation_rate"
                                help="Annual rent increase percentage"
                            />

                            <!-- Escalation Frequency -->
                            <x-form.input
                                label="Escalation Frequency (Months)"
                                name="escalation_frequency_months"
                                type="number"
                                min="1"
                                :value="$leaseContract->escalation_frequency_months"
                                help="How often escalation is applied"
                            />

                            <!-- Payment Terms Days -->
                            <x-form.input
                                label="Payment Terms (Days)"
                                name="payment_terms_days"
                                type="number"
                                min="0"
                                max="90"
                                :value="$leaseContract->payment_terms_days"
                                help="Days before payment is due"
                            />
                        </div>
                    </div>

                    <!-- Units and Charges -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Units and Charges</h3>

                        <div id="unitsContainer" class="space-y-4">
                            @foreach($leaseContract->units as $index => $unit)
                                <div class="unit-row border border-gray-200 rounded-lg p-4 bg-gray-50">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                                            <select name="units[{{ $index }}][unit_id]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                <option value="{{ $unit->id }}">{{ $unit->unit_code }} - {{ $unit->unit_number }}</option>
                                                @foreach($availableUnits as $availUnit)
                                                    @if($availUnit->id !== $unit->id)
                                                        <option value="{{ $availUnit->id }}">{{ $availUnit->unit_code }} - {{ $availUnit->unit_number }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Rent</label>
                                            <input type="number" name="units[{{ $index }}][monthly_rent]" step="0.01" min="0" value="{{ $unit->pivot->monthly_rent }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Association Dues</label>
                                            <input type="number" name="units[{{ $index }}][association_dues]" step="0.01" min="0" value="{{ $unit->pivot->association_dues }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" class="remove-unit w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="addUnitBtn" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Add Unit
                        </button>
                    </div>

                    <!-- Notes -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            rows="4"
                            :value="$leaseContract->notes"
                            help="Additional terms, conditions, or notes"
                        />
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('lease-contracts.show', $leaseContract) }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Update Lease Contract
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    @push('scripts')
    <script>
        let unitIndex = {{ $leaseContract->units->count() }};
        let availableUnits = @json($availableUnits);

        // Load units when property changes
        document.querySelector('select[name="property_id"]').addEventListener('change', function() {
            const propertyId = this.value;

            if (!propertyId) {
                availableUnits = [];
                return;
            }

            fetch(`/api/lease-contracts/available-units?property_id=${propertyId}`)
                .then(response => response.json())
                .then(data => {
                    availableUnits = data;
                })
                .catch(error => console.error('Error loading units:', error));
        });

        // Add unit row
        document.getElementById('addUnitBtn').addEventListener('click', function() {
            if (availableUnits.length === 0) {
                alert('No available units for the selected property');
                return;
            }

            const container = document.getElementById('unitsContainer');
            const unitRow = document.createElement('div');
            unitRow.className = 'unit-row border border-gray-200 rounded-lg p-4 bg-gray-50';

            let unitOptions = availableUnits.map(unit =>
                `<option value="${unit.id}">${unit.unit_code} - ${unit.unit_number}</option>`
            ).join('');

            unitRow.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                        <select name="units[${unitIndex}][unit_id]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Unit</option>
                            ${unitOptions}
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Rent</label>
                        <input type="number" name="units[${unitIndex}][monthly_rent]" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Association Dues</label>
                        <input type="number" name="units[${unitIndex}][association_dues]" step="0.01" min="0" value="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex items-end">
                        <button type="button" class="remove-unit w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Remove</button>
                    </div>
                </div>
            `;

            container.appendChild(unitRow);
            unitIndex++;
        });

        // Remove unit row (event delegation)
        document.getElementById('unitsContainer').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-unit')) {
                const container = document.getElementById('unitsContainer');
                if (container.querySelectorAll('.unit-row').length > 1) {
                    e.target.closest('.unit-row').remove();
                } else {
                    alert('At least one unit is required');
                }
            }
        });
    </script>
    @endpush
</x-app-layout>

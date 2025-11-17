<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Lease Contract') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('lease-contracts.store') }}" id="leaseContractForm">
                    @csrf

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
                                :value="$selectedPropertyId"
                                help="Select the property for this lease"
                            />

                            <!-- Tenant -->
                            <x-form.select
                                label="Tenant"
                                name="tenant_id"
                                :options="$tenants->mapWithKeys(fn($t) => [$t->id => $t->last_name . ', ' . $t->first_name])->toArray()"
                                :required="true"
                                help="Select the tenant for this lease"
                            />

                            <!-- Contract Number -->
                            <x-form.input
                                label="Contract Number"
                                name="contract_number"
                                type="text"
                                help="Leave blank to auto-generate"
                            />

                            <!-- Contract Date -->
                            <x-form.input
                                label="Contract Date"
                                name="contract_date"
                                type="date"
                                :value="date('Y-m-d')"
                            />

                            <!-- Start Date -->
                            <x-form.input
                                label="Start Date"
                                name="start_date"
                                type="date"
                                :required="true"
                            />

                            <!-- End Date -->
                            <x-form.input
                                label="End Date"
                                name="end_date"
                                type="date"
                                :required="true"
                            />

                            <!-- Billing Cycle -->
                            <x-form.select
                                label="Billing Cycle"
                                name="billing_cycle"
                                :options="collect($billingCycles)->mapWithKeys(fn($c) => [$c['value'] => $c['label']])->toArray()"
                                :required="true"
                                value="monthly"
                            />

                            <!-- Billing Day -->
                            <x-form.input
                                label="Billing Day"
                                name="billing_day"
                                type="number"
                                min="1"
                                max="31"
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
                                help="Amount held as security"
                            />

                            <!-- Advance Rent Months -->
                            <x-form.input
                                label="Advance Rent (Months)"
                                name="advance_rent_months"
                                type="number"
                                min="0"
                                max="12"
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
                                help="Annual rent increase percentage"
                            />

                            <!-- Escalation Frequency -->
                            <x-form.input
                                label="Escalation Frequency (Months)"
                                name="escalation_frequency_months"
                                type="number"
                                min="1"
                                help="How often escalation is applied"
                            />

                            <!-- Payment Terms Days -->
                            <x-form.input
                                label="Payment Terms (Days)"
                                name="payment_terms_days"
                                type="number"
                                min="0"
                                max="90"
                                help="Days before payment is due"
                            />
                        </div>
                    </div>

                    <!-- Units and Charges -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Units and Charges</h3>

                        <div id="unitsContainer" class="space-y-4">
                            @if($selectedUnits->count() > 0)
                                @foreach($selectedUnits as $index => $unit)
                                    <div class="unit-row border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                                                <select name="units[{{ $index }}][unit_id]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                    <option value="{{ $unit->id }}">{{ $unit->unit_code }} - {{ $unit->unit_number }}</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Rent</label>
                                                <input type="number" name="units[{{ $index }}][monthly_rent]" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Association Dues</label>
                                                <input type="number" name="units[{{ $index }}][association_dues]" step="0.01" min="0" value="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div class="flex items-end">
                                                <button type="button" class="remove-unit w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button type="button" id="addUnitBtn" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Add Unit
                        </button>

                        <p class="mt-2 text-sm text-gray-500">Select property first to see available units</p>
                    </div>

                    <!-- Notes -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                        <x-form.textarea
                            label="Notes"
                            name="notes"
                            rows="4"
                            help="Additional terms, conditions, or notes"
                        />
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('lease-contracts.index') }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            Create Lease Contract
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    @push('scripts')
    <script>
        let unitIndex = {{ $selectedUnits->count() }};
        let availableUnits = [];

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
                alert('Please select a property first');
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
                e.target.closest('.unit-row').remove();
            }
        });

        // Auto-populate unit rent when unit is selected
        document.getElementById('unitsContainer').addEventListener('change', function(e) {
            if (e.target.name && e.target.name.includes('[unit_id]')) {
                const unitId = e.target.value;
                const unit = availableUnits.find(u => u.id == unitId);

                if (unit && unit.monthly_rent_amount) {
                    const row = e.target.closest('.unit-row');
                    const rentInput = row.querySelector('input[name*="[monthly_rent]"]');
                    if (rentInput && !rentInput.value) {
                        rentInput.value = unit.monthly_rent_amount;
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>

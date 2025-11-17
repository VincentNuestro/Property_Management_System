<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Invoice') }} - {{ $invoice->invoice_number }}
            </h2>
            <a href="{{ route('invoices.show', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to Invoice
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('invoices.update', $invoice) }}" id="invoiceForm">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Invoice Header -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Property -->
                            <div>
                                <label for="property_id" class="block text-sm font-medium text-gray-700">Property *</label>
                                <select name="property_id" id="property_id" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Property</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}" {{ (old('property_id', $invoice->property_id) == $property->id) ? 'selected' : '' }}>
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('property_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tenant -->
                            <div>
                                <label for="tenant_id" class="block text-sm font-medium text-gray-700">Tenant *</label>
                                <select name="tenant_id" id="tenant_id" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Tenant</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->id }}" {{ (old('tenant_id', $invoice->tenant_id) == $tenant->id) ? 'selected' : '' }}>
                                            {{ $tenant->first_name }} {{ $tenant->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tenant_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lease Contract -->
                            <div>
                                <label for="lease_contract_id" class="block text-sm font-medium text-gray-700">Lease Contract</label>
                                <select name="lease_contract_id" id="lease_contract_id" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Lease Contract (Optional)</option>
                                    @foreach($leaseContracts as $contract)
                                        <option value="{{ $contract->id }}" {{ (old('lease_contract_id', $invoice->lease_contract_id) == $contract->id) ? 'selected' : '' }}>
                                            {{ $contract->contract_number }} - {{ $contract->tenant->first_name }} {{ $contract->tenant->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lease_contract_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <!-- Invoice Date -->
                            <div>
                                <label for="invoice_date" class="block text-sm font-medium text-gray-700">Invoice Date *</label>
                                <input type="date" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('invoice_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Due Date -->
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date *</label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Period Start -->
                            <div>
                                <label for="period_start" class="block text-sm font-medium text-gray-700">Period Start</label>
                                <input type="date" name="period_start" id="period_start" value="{{ old('period_start', $invoice->period_start?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('period_start')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Period End -->
                            <div>
                                <label for="period_end" class="block text-sm font-medium text-gray-700">Period End</label>
                                <input type="date" name="period_end" id="period_end" value="{{ old('period_end', $invoice->period_end?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('period_end')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Line Items -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-sm font-medium text-gray-700">Line Items *</label>
                                <button type="button" onclick="addLineItem()" class="inline-flex items-center px-3 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Add Line Item
                                </button>
                            </div>

                            <div id="lineItemsContainer" class="space-y-4">
                                <!-- Existing line items will be loaded here -->
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $invoice->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Totals Display -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-end">
                                <div class="w-64 space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="font-medium">Subtotal:</span>
                                        <span id="subtotalDisplay">$0.00</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="font-medium">Tax:</span>
                                        <span id="taxDisplay">$0.00</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                                        <span>Total:</span>
                                        <span id="totalDisplay">$0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('invoices.show', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Invoice
                            </button>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    @push('scripts')
    <script>
        let lineItemIndex = 0;
        const chargeTypes = @json($chargeTypes);
        const existingLineItems = @json($invoice->lineItems);

        function addLineItem(existingItem = null) {
            const container = document.getElementById('lineItemsContainer');
            const template = `
                <div class="line-item p-4 border border-gray-300 rounded-lg" data-index="${lineItemIndex}">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Charge Type</label>
                            <select name="line_items[${lineItemIndex}][charge_type_id]" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Select Charge</option>
                                ${chargeTypes.map(ct => `<option value="${ct.id}" ${existingItem && existingItem.charge_type_id === ct.id ? 'selected' : ''}>${ct.name}</option>`).join('')}
                            </select>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input type="text" name="line_items[${lineItemIndex}][description]" value="${existingItem ? existingItem.description : ''}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Description">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input type="number" name="line_items[${lineItemIndex}][quantity]" value="${existingItem ? existingItem.quantity : 1}" step="0.01" min="0.01" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm line-quantity" onchange="calculateTotals()">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price</label>
                            <input type="number" name="line_items[${lineItemIndex}][unit_price]" value="${existingItem ? existingItem.unit_price : 0}" step="0.01" min="0" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm line-price" onchange="calculateTotals()">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Taxable</label>
                            <input type="checkbox" name="line_items[${lineItemIndex}][is_taxable]" value="1" ${existingItem && existingItem.is_taxable ? 'checked' : ''} class="mt-2 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 line-taxable" onchange="calculateTotals()">
                            <input type="hidden" name="line_items[${lineItemIndex}][tax_rate]" value="${existingItem ? existingItem.tax_rate : 0}" class="line-tax-rate">
                        </div>
                        <div class="col-span-1 flex items-end">
                            <button type="button" onclick="removeLineItem(${lineItemIndex})" class="w-full px-2 py-2 bg-red-600 text-white rounded-md text-xs hover:bg-red-700">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            lineItemIndex++;
            calculateTotals();
        }

        function removeLineItem(index) {
            const item = document.querySelector(`.line-item[data-index="${index}"]`);
            if (item) {
                item.remove();
                calculateTotals();
            }
        }

        function calculateTotals() {
            let subtotal = 0;
            let tax = 0;

            document.querySelectorAll('.line-item').forEach(item => {
                const quantity = parseFloat(item.querySelector('.line-quantity').value) || 0;
                const price = parseFloat(item.querySelector('.line-price').value) || 0;
                const isTaxable = item.querySelector('.line-taxable').checked;
                const taxRate = parseFloat(item.querySelector('.line-tax-rate').value) || 0;

                const amount = quantity * price;
                subtotal += amount;

                if (isTaxable) {
                    tax += amount * (taxRate / 100);
                }
            });

            document.getElementById('subtotalDisplay').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('taxDisplay').textContent = '$' + tax.toFixed(2);
            document.getElementById('totalDisplay').textContent = '$' + (subtotal + tax).toFixed(2);
        }

        // Load existing line items on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (existingLineItems.length > 0) {
                existingLineItems.forEach(item => addLineItem(item));
            } else {
                addLineItem();
            }
        });
    </script>
    @endpush
</x-app-layout>

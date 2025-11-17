<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Payment') }} - {{ $payment->payment_number }}
            </h2>
            <a href="{{ route('payments.show', $payment) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to Payment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('payments.update', $payment) }}" id="paymentForm">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Payment Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Property -->
                            <div>
                                <label for="property_id" class="block text-sm font-medium text-gray-700">Property *</label>
                                <select name="property_id" id="property_id" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Property</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}" {{ old('property_id', $payment->property_id) == $property->id ? 'selected' : '' }}>
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
                                        <option value="{{ $tenant->id }}" {{ old('tenant_id', $payment->tenant_id) == $tenant->id ? 'selected' : '' }}>
                                            {{ $tenant->first_name }} {{ $tenant->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tenant_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Date -->
                            <div>
                                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date *</label>
                                <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('payment_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount *</label>
                                <input type="number" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}" step="0.01" min="0.01" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($paymentMethods as $method)
                                    <div>
                                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                            <input
                                                type="radio"
                                                name="payment_method"
                                                value="{{ $method['value'] }}"
                                                {{ old('payment_method', $payment->payment_method->value) == $method['value'] ? 'checked' : '' }}
                                                required
                                                class="payment-method-radio"
                                                onchange="togglePaymentFields()"
                                            >
                                            <span class="ml-2 text-sm text-gray-700">{{ $method['label'] }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Conditional Fields for Check/PDC -->
                        <div id="checkFields" class="hidden grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Check Number -->
                            <div>
                                <label for="check_number" class="block text-sm font-medium text-gray-700">Check Number</label>
                                <input type="text" name="check_number" id="check_number" value="{{ old('check_number', $payment->check_number) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('check_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Check Date -->
                            <div>
                                <label for="check_date" class="block text-sm font-medium text-gray-700">Check Date</label>
                                <input type="date" name="check_date" id="check_date" value="{{ old('check_date', $payment->check_date?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('check_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bank Name -->
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $payment->bank_name) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('bank_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Conditional Fields for Bank Transfer -->
                        <div id="bankTransferFields" class="hidden">
                            <!-- Bank Name -->
                            <div>
                                <label for="bank_name_transfer" class="block text-sm font-medium text-gray-700">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name_transfer" value="{{ old('bank_name', $payment->bank_name) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Reference Number -->
                        <div>
                            <label for="reference_number" class="block text-sm font-medium text-gray-700">Reference Number</label>
                            <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number', $payment->reference_number) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Transaction reference or OR number">
                            @error('reference_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $payment->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3 pt-6">
                            <a href="{{ route('payments.show', $payment) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Payment
                            </button>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePaymentFields() {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            const checkFields = document.getElementById('checkFields');
            const bankTransferFields = document.getElementById('bankTransferFields');

            // Hide all conditional fields first
            checkFields.classList.add('hidden');
            bankTransferFields.classList.add('hidden');

            if (selectedMethod) {
                const methodValue = selectedMethod.value;

                // Show relevant fields based on payment method
                if (methodValue === 'check' || methodValue === 'pdc') {
                    checkFields.classList.remove('hidden');
                } else if (methodValue === 'bank_transfer') {
                    bankTransferFields.classList.remove('hidden');
                }
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            togglePaymentFields();
        });
    </script>
    @endpush
</x-app-layout>

<?php

namespace App\Http\Requests;

use App\Enums\BillingCycle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeaseContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('lease_contracts.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'tenant_id' => ['required', 'exists:tenants,id'],
            'contract_number' => ['nullable', 'string', 'max:50', 'unique:lease_contracts,contract_number'],
            'contract_date' => ['nullable', 'date'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'lease_term_months' => ['nullable', 'integer', 'min:1'],
            'billing_cycle' => ['required', Rule::enum(BillingCycle::class)],
            'billing_day' => ['nullable', 'integer', 'min:1', 'max:31'],
            'security_deposit' => ['nullable', 'numeric', 'min:0'],
            'advance_rent_months' => ['nullable', 'integer', 'min:0', 'max:12'],
            'escalation_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'escalation_frequency_months' => ['nullable', 'integer', 'min:1'],
            'next_escalation_date' => ['nullable', 'date'],
            'payment_terms_days' => ['nullable', 'integer', 'min:0', 'max:90'],
            'notes' => ['nullable', 'string'],
            'units' => ['required', 'array', 'min:1'],
            'units.*.unit_id' => ['required', 'exists:units,id'],
            'units.*.monthly_rent' => ['required', 'numeric', 'min:0'],
            'units.*.association_dues' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'property_id.required' => 'Please select a property.',
            'tenant_id.required' => 'Please select a tenant.',
            'start_date.required' => 'Start date is required.',
            'end_date.required' => 'End date is required.',
            'end_date.after' => 'End date must be after start date.',
            'billing_cycle.required' => 'Please select a billing cycle.',
            'units.required' => 'At least one unit must be selected.',
            'units.*.unit_id.required' => 'Unit selection is required.',
            'units.*.monthly_rent.required' => 'Monthly rent is required for each unit.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'units.*.monthly_rent' => 'monthly rent',
            'units.*.association_dues' => 'association dues',
        ];
    }
}

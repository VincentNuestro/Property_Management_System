<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('invoices.edit');
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
            'lease_contract_id' => ['nullable', 'exists:lease_contracts,id'],
            'invoice_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:invoice_date'],
            'period_start' => ['nullable', 'date'],
            'period_end' => ['nullable', 'date', 'after_or_equal:period_start'],
            'notes' => ['nullable', 'string'],

            // Line items
            'line_items' => ['required', 'array', 'min:1'],
            'line_items.*.charge_type_id' => ['required', 'exists:charge_types,id'],
            'line_items.*.description' => ['required', 'string', 'max:255'],
            'line_items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'line_items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'line_items.*.is_taxable' => ['nullable', 'boolean'],
            'line_items.*.tax_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'property_id.required' => 'Property is required.',
            'property_id.exists' => 'Selected property does not exist.',
            'tenant_id.required' => 'Tenant is required.',
            'tenant_id.exists' => 'Selected tenant does not exist.',
            'invoice_date.required' => 'Invoice date is required.',
            'due_date.required' => 'Due date is required.',
            'due_date.after_or_equal' => 'Due date must be on or after invoice date.',
            'line_items.required' => 'At least one line item is required.',
            'line_items.*.charge_type_id.required' => 'Charge type is required for each line item.',
            'line_items.*.description.required' => 'Description is required for each line item.',
            'line_items.*.quantity.required' => 'Quantity is required for each line item.',
            'line_items.*.unit_price.required' => 'Unit price is required for each line item.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeaseApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('lease_applications.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'property_id' => ['required', 'integer', 'exists:properties,id'],
            'tenant_id' => ['required', 'integer', 'exists:tenants,id'],
            'application_date' => ['required', 'date'],
            'desired_start_date' => ['required', 'date', 'after_or_equal:application_date'],
            'desired_lease_term' => ['required', 'integer', 'min:1', 'max:120'],
            'notes' => ['nullable', 'string', 'max:2000'],
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
            'application_date.required' => 'Application date is required.',
            'desired_start_date.required' => 'Desired start date is required.',
            'desired_start_date.after_or_equal' => 'Desired start date must be on or after application date.',
            'desired_lease_term.required' => 'Desired lease term is required.',
            'desired_lease_term.min' => 'Lease term must be at least 1 month.',
            'desired_lease_term.max' => 'Lease term cannot exceed 120 months (10 years).',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'property_id' => 'property',
            'tenant_id' => 'tenant',
            'application_date' => 'application date',
            'desired_start_date' => 'desired start date',
            'desired_lease_term' => 'desired lease term',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\TenantType;
use App\Enums\TenantStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('tenants.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tenant_type' => ['required', Rule::enum(TenantType::class)],
            'first_name' => [
                Rule::requiredIf(fn() => $this->tenant_type === TenantType::INDIVIDUAL->value),
                'nullable',
                'string',
                'max:255'
            ],
            'last_name' => [
                Rule::requiredIf(fn() => $this->tenant_type === TenantType::INDIVIDUAL->value),
                'nullable',
                'string',
                'max:255'
            ],
            'company_id' => [
                Rule::requiredIf(fn() => $this->tenant_type === TenantType::CORPORATE->value),
                'nullable',
                'exists:companies,id'
            ],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'mobile' => ['nullable', 'string', 'max:50'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'government_id_type' => ['nullable', 'string', 'max:50'],
            'government_id_number' => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::enum(TenantStatus::class)],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'tenant_type.required' => 'Tenant type is required.',
            'first_name.required' => 'First name is required for individual tenants.',
            'last_name.required' => 'Last name is required for individual tenants.',
            'company_id.required' => 'Company is required for corporate tenants.',
            'company_id.exists' => 'Selected company does not exist.',
            'email.email' => 'Please enter a valid email address.',
            'date_of_birth.before' => 'Date of birth must be a date before today.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'government_id_type' => 'ID type',
            'government_id_number' => 'ID number',
            'date_of_birth' => 'date of birth',
        ];
    }
}

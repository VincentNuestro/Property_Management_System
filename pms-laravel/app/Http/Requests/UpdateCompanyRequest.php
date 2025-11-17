<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('companies.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $companyId = $this->route('company')->id ?? null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'trade_name' => ['nullable', 'string', 'max:255'],
            'business_type' => ['nullable', 'string', 'max:100'],
            'industry' => ['nullable', 'string', 'max:100'],
            'tax_id' => ['nullable', 'string', 'max:100', Rule::unique('companies', 'tax_id')->ignore($companyId)],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'string', 'max:255', 'url'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:active,inactive'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Company name is required.',
            'tax_id.unique' => 'This tax ID is already registered to another company.',
            'email.email' => 'Please enter a valid email address.',
            'website.url' => 'Please enter a valid website URL.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\InquiryStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('inquiries.edit');
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
            'inquirer_name' => ['required', 'string', 'max:255'],
            'inquirer_email' => ['required', 'email', 'max:255'],
            'inquirer_phone' => ['nullable', 'string', 'max:50'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'space_type' => ['nullable', 'string', 'max:100'],
            'desired_area_sqm' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'desired_move_in_date' => ['nullable', 'date'],
            'budget_min' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'budget_max' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999999.99',
                Rule::requiredIf(fn() => $this->filled('budget_min')),
                'gte:budget_min',
            ],
            'source' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::enum(InquiryStatus::class)],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'notes' => ['nullable', 'string'],
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
            'inquirer_name.required' => 'Inquirer name is required.',
            'inquirer_email.required' => 'Inquirer email is required.',
            'inquirer_email.email' => 'Please enter a valid email address.',
            'budget_max.gte' => 'Maximum budget must be greater than or equal to minimum budget.',
            'assigned_to.exists' => 'Selected user does not exist.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'property_id' => 'property',
            'inquirer_name' => 'inquirer name',
            'inquirer_email' => 'inquirer email',
            'inquirer_phone' => 'inquirer phone',
            'company_name' => 'company name',
            'space_type' => 'space type',
            'desired_area_sqm' => 'desired area (sqm)',
            'desired_move_in_date' => 'desired move-in date',
            'budget_min' => 'minimum budget',
            'budget_max' => 'maximum budget',
            'assigned_to' => 'assigned user',
        ];
    }
}

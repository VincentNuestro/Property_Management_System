<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('payments.edit');
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
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'check_number' => ['nullable', 'string', 'max:50', 'required_if:payment_method,check,pdc'],
            'check_date' => ['nullable', 'date', 'required_if:payment_method,check,pdc'],
            'bank_name' => ['nullable', 'string', 'max:255', 'required_if:payment_method,check,pdc,bank_transfer'],
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
            'tenant_id.required' => 'Tenant is required.',
            'tenant_id.exists' => 'Selected tenant does not exist.',
            'payment_date.required' => 'Payment date is required.',
            'payment_method.required' => 'Payment method is required.',
            'amount.required' => 'Amount is required.',
            'amount.min' => 'Amount must be greater than zero.',
            'check_number.required_if' => 'Check number is required for check payments.',
            'check_date.required_if' => 'Check date is required for check payments.',
            'bank_name.required_if' => 'Bank name is required for this payment method.',
        ];
    }
}

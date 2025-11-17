<?php

namespace App\Http\Requests;

use App\Enums\ReservationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('reservations.create');
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
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'tenant_id' => ['required', 'integer', 'exists:tenants,id'],
            'reservation_number' => ['nullable', 'string', 'max:50', 'unique:reservations,reservation_number'],
            'reservation_date' => ['required', 'date'],
            'reservation_fee' => ['required', 'numeric', 'min:0'],
            'reservation_paid' => ['nullable', 'numeric', 'min:0'],
            'expiry_date' => ['required', 'date', 'after:reservation_date'],
            'status' => ['nullable', Rule::enum(ReservationStatus::class)],
            'notes' => ['nullable', 'string', 'max:1000'],
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
            'unit_id.required' => 'Unit is required.',
            'unit_id.exists' => 'Selected unit does not exist.',
            'tenant_id.required' => 'Tenant is required.',
            'tenant_id.exists' => 'Selected tenant does not exist.',
            'reservation_date.required' => 'Reservation date is required.',
            'reservation_fee.required' => 'Reservation fee is required.',
            'reservation_fee.min' => 'Reservation fee must be at least 0.',
            'expiry_date.required' => 'Expiry date is required.',
            'expiry_date.after' => 'Expiry date must be after reservation date.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'property_id' => 'property',
            'unit_id' => 'unit',
            'tenant_id' => 'tenant',
            'reservation_date' => 'reservation date',
            'reservation_fee' => 'reservation fee',
            'reservation_paid' => 'amount paid',
            'expiry_date' => 'expiry date',
        ];
    }
}

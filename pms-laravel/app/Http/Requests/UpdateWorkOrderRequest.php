<?php

namespace App\Http\Requests;

use App\Enums\WorkOrderType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('work_orders.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'maintenance_request_id' => ['nullable', 'exists:maintenance_requests,id'],
            'type' => ['required', Rule::enum(WorkOrderType::class)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'assignment_type' => ['required', 'in:internal,external'],
            'assigned_to' => ['nullable', 'required_if:assignment_type,internal', 'exists:users,id'],
            'vendor_name' => ['nullable', 'required_if:assignment_type,external', 'string', 'max:255'],
            'vendor_contact' => ['nullable', 'string', 'max:255'],
            'scheduled_date' => ['nullable', 'date'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Work order type is required.',
            'title.required' => 'Title is required.',
            'description.required' => 'Description is required.',
            'assignment_type.required' => 'Please select assignment type.',
            'assigned_to.required_if' => 'Assigned user is required for internal work orders.',
            'vendor_name.required_if' => 'Vendor name is required for external work orders.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clear assigned_to if external, clear vendor fields if internal
        if ($this->assignment_type === 'external') {
            $this->merge(['assigned_to' => null]);
        } else {
            $this->merge(['vendor_name' => null, 'vendor_contact' => null]);
        }
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\MaintenancePriority;
use App\Enums\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMaintenanceRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can(Permission::MAINTENANCE_REQUESTS_CREATE);
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
            'unit_id' => ['nullable', 'exists:units,id'],
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'category' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', Rule::enum(MaintenancePriority::class)],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'scheduled_date' => ['nullable', 'date'],
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
            'unit_id.exists' => 'Selected unit does not exist.',
            'tenant_id.exists' => 'Selected tenant does not exist.',
            'category.required' => 'Category is required.',
            'title.required' => 'Title is required.',
            'description.required' => 'Description is required.',
            'priority.required' => 'Priority is required.',
            'assigned_to.exists' => 'Selected user does not exist.',
            'scheduled_date.date' => 'Scheduled date must be a valid date.',
        ];
    }
}

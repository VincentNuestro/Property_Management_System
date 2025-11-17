<?php

namespace App\Http\Requests;

use App\Enums\UnitType;
use App\Enums\UnitStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('units.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $unitId = $this->route('unit')->id ?? null;

        return [
            'property_id' => ['required', 'integer', 'exists:properties,id'],
            'building_id' => ['nullable', 'integer', 'exists:buildings,id'],
            'floor_id' => ['nullable', 'integer', 'exists:floors,id'],
            'unit_code' => ['required', 'string', 'max:50', Rule::unique('units', 'unit_code')->ignore($unitId)],
            'unit_number' => ['required', 'string', 'max:50'],
            'type' => ['required', Rule::enum(UnitType::class)],
            'classification' => ['nullable', 'string', 'max:100'],
            'area_sqm' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:100'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:100'],
            'status' => ['required', Rule::enum(UnitStatus::class)],
            'base_rent' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'association_dues' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'description' => ['nullable', 'string'],
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
            'building_id.exists' => 'Selected building does not exist.',
            'floor_id.exists' => 'Selected floor does not exist.',
            'unit_code.required' => 'Unit code is required.',
            'unit_code.unique' => 'This unit code is already in use.',
            'unit_number.required' => 'Unit number is required.',
            'type.required' => 'Unit type is required.',
            'status.required' => 'Unit status is required.',
        ];
    }
}

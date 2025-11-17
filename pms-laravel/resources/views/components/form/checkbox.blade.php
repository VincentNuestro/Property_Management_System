@props(['disabled' => false, 'label' => '', 'name' => '', 'checked' => false, 'help' => ''])

<div class="mb-4">
    <div class="flex items-center">
        <input
            type="checkbox"
            name="{{ $name }}"
            id="{{ $name }}"
            value="1"
            {{ $disabled ? 'disabled' : '' }}
            {{ old($name, $checked) ? 'checked' : '' }}
            {{ $attributes->merge(['class' => 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500']) }}
        >

        @if($label)
            <label for="{{ $name }}" class="ml-2 block text-sm text-gray-700">
                {{ $label }}
            </label>
        @endif
    </div>

    @if($help)
        <p class="mt-1 ml-6 text-sm text-gray-500">{{ $help }}</p>
    @endif

    @error($name)
        <p class="mt-1 ml-6 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

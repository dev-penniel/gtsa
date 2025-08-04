@props(['label', 'wireModel'])

<div class="flex items-center space-x-2">
    <input
        type="checkbox"
        id="{{ $attributes->get('id') ?? $label }}"
        {{ $attributes->merge([
            'class' => 'rounded text-blue-600 border-gray-300 focus:ring-blue-500',
            'wire:model.defer' => $wireModel,
        ]) }}
    />
    <label for="{{ $attributes->get('id') ?? $label }}" class="text-gray-700 select-none">
        {{ $label }}
    </label>
</div>
@error($wireModel) <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

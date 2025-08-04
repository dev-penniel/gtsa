@props(['label', 'id' => null, 'wireModel'])

<div class="space-y-1">
    <label for="{{ $id ?? $attributes->get('id') }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </label>
    <textarea
        id="{{ $id ?? $attributes->get('id') }}"
        rows="4"
        {{ $attributes->merge([
            'class' => 'block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50',
            'wire:model.defer' => $wireModel,
        ]) }}
    ></textarea>
    @error($wireModel) <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>


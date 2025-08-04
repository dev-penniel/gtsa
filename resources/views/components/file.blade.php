@props(['label', 'wireModel'])

<div class="space-y-1">
    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input
        type="file"
        {{ $attributes->merge([
            'class' => 'block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100',
            'wire:model' => $wireModel,
        ]) }}
    />
    @error($wireModel) <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

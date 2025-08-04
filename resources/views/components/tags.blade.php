@props(['label', 'wireModel'])

<div class="space-y-1">
    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input
        type="text"
        placeholder="Comma separated values"
        {{ $attributes->merge([
            'class' => 'block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50',
            'wire:model.defer' => $wireModel,
        ]) }}
    />
    <p class="text-gray-500 text-xs italic">Separate tags with commas</p>
    @error($wireModel) <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>
<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
</div>

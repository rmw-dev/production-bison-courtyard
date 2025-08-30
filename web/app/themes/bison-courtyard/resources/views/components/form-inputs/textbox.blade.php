@props([
    'label' => null,
    'name',
    'type' => 'text',
])

<div class="form-group flex flex-col mb-6 w-full">
    @if($label)
        <label for="{{ $name }}" class="text-xl font-medium uppercase mb-2">
            {{ $label }}
        </label>
    @endif

    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        {{ $attributes->merge(['class' => 'w-full border-0 bg-[#f7f7f7] px-4 py-3 focus:outline-none focus:ring-2 focus:ring-theme-orange']) }}
    />
</div>

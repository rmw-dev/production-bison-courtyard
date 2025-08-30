@props([
    'label' => null,
    'name',
    'rows' => 7,
])

<div class="form-group flex flex-col w-full">
    @if($label)
        <label for="{{ $name }}" class="text-xl font-normal uppercase text-[#3a2a21]">
            {{ $label }}
        </label>
    @endif

    <textarea 
        id="{{ $name }}" 
        name="{{ $name }}" 
        rows="{{ $rows }}" 
        {{ $attributes->merge(['class' => 'p-4 w-full border-0 bg-[#f7f7f7] px-4 focus:outline-none focus:ring-2 focus:ring-theme-orange mt-2']) }}
    ></textarea>
</div>

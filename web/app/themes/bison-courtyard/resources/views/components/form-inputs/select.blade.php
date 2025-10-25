@props([
    'label' => null,
    'name',
    'options' => [],        // ['value' => 'Label', ...]
    'placeholder' => null,  // e.g. 'Please choose...'
    'selected' => null,     // preselected value or array of values
    'multiple' => false,
])

<div class="form-group flex flex-col mb-0 w-full">
    @if($label)
        <label for="{{ $name }}" class="text-xl font-medium uppercase mb-2">
            {{ $label }}
        </label>
    @endif

    @php
        $current = old($name, $selected);
        $isMultiple = (bool) $multiple;
    @endphp

    <select
        id="{{ $name }}"
        name="{{ $name }}{{ $isMultiple ? '[]' : '' }}"
        @if($isMultiple) multiple @endif
        {{ $attributes->merge(['class' => 'w-full border-0 bg-[#f7f7f7] px-4 py-3 h-[56px] focus:outline-none focus:ring-2 focus:ring-theme-orange']) }}
    >
        @if($placeholder && !$isMultiple)
            <option value="" disabled @selected(is_null($current) || $current==='')>
                {{ $placeholder }}
            </option>
        @endif

        @foreach($options as $value => $text)
            @php
                $selectedCondition = $isMultiple
                    ? in_array($value, (array) $current, true)
                    : (string) $current === (string) $value;
            @endphp
            <option value="{{ $value }}" @selected($selectedCondition)>{{ $text }}</option>
        @endforeach
    </select>
</div>

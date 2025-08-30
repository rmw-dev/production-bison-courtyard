@props([
  // Behavior / element
  'href'      => null,           // if set, renders <a>; otherwise <button>
  'type'      => 'button',       // button type: button|submit|reset
  'id'        => null,
  'disabled'  => false,
  'target'    => null,           // e.g., _blank
  'rel'       => null,           // e.g., noreferrer noopener
  // Styling
  'variant'   => 'primary',      // primary|secondary
  'size'      => 'lg',           // xs|sm|md|lg
  'full'      => false,          // full-width
])

@php
  $base = 'inline-flex items-center justify-center gap-2 rounded-xl font-medium transition
           focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed  hover:cursor-pointer uppercase';

  $variants = [
    'primary'   => 'bg-theme-orange text-white hover:bg-theme-orange/90 focus-visible:ring-black',
    'secondary' => 'bg-theme-blue text-white hover:bg-theme-orange/90 focus-visible:ring-black',
  ];

  $sizes = [
    'xs' => 'text-xs px-2.5 py-1.5',
    'sm' => 'text-sm px-3 py-2',
    'md' => 'text-xl px-4 py-2.5',
    'lg' => 'text-xl px-12 py-4',
  ];

  $class = implode(' ', [
    $base,
    $variants[$variant] ?? $variants['primary'],
    $sizes[$size] ?? $sizes['md'],
    $full ? 'w-full' : '',
  ]);

  // Accessibility helpers for <a disabled>
  $isLink = filled($href);
  $ariaDisabled = $disabled ? 'true' : 'false';

  // Sensible rel defaults for target=_blank
  $computedRel = $rel;
  if ($target === '_blank') {
    $parts = collect(explode(' ', (string) $rel))->filter()->map('trim');
    $computedRel = $parts->union(['noopener','noreferrer'])->implode(' ');
  }
@endphp

@if ($isLink)
  <a
    {{ $attributes->merge(['class' => $class]) }}
    href="{{ $disabled ? '#' : $href }}"
    @if($id) id="{{ $id }}" @endif
    @if($target) target="{{ $target }}" @endif
    @if($computedRel) rel="{{ $computedRel }}" @endif
    aria-disabled="{{ $ariaDisabled }}"
    @if($disabled) tabindex="-1" @endif
  >
    @isset($icon)
      <span class="-ml-0.5">{{ $icon }}</span>
    @endisset

    <span>{{ $slot }}</span>

    @isset($trailingIcon)
      <span class="-mr-0.5">{{ $trailingIcon }}</span>
    @endisset
  </a>
@else
  <button
    {{ $attributes->merge(['class' => $class]) }}
    type="{{ $type }}"
    @if($id) id="{{ $id }}" @endif
    @disabled($disabled)
  >
    @isset($icon)
      <span class="-ml-0.5">{{ $icon }}</span>
    @endisset

    <span>{{ $slot }}</span>

    @isset($trailingIcon)
      <span class="-mr-0.5">{{ $trailingIcon }}</span>
    @endisset
  </button>
@endif

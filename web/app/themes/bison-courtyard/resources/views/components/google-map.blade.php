@props([
  'lat'=> "51.177306",     // e.g. 51.1784
  'lng'=> "-115.57257",   // e.g. -115.5708
  'zoom' => 16,
  'icon' => null,      // URL to your custom marker icon
  'title' => null,     // Marker title
  'address' => null,   // Shown in InfoWindow if provided
  'mapStyle' => 'default', // 'default' or 'dark' (or supply JSON below)
  'mapStyleJson' => null,  // Optional: raw JSON style (array) overrides mapStyle
  'height' => '400px',
  'class' => '',
])



@php
  // Allow passing JSON (PHP array or string) for custom styling
  $styleJson = $mapStyleJson ? json_encode($mapStyleJson) : '';
   $whitePin = 'data:image/svg+xml;utf8,' . rawurlencode('
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 96" width="64" height="96">
      <!-- Outer pin path (border stroke only) -->
      <path d="M32 2C15 2 2 15 2 32c0 24 30 62 30 62s30-38 30-62C62 15 49 2 32 2z"
            fill="#0C384D"
            stroke="#0C384D"
            stroke-width="4"/>
      <!-- Inner circle -->
      <circle cx="32" cy="32" r="15"
              fill="#ffffff"
              stroke="#0C384D"
              stroke-width="4"/>
    </svg>
  ');
@endphp

<div
  class="gmap-wrapper {{ $class }}"
  style="height: {{ $height }};"
  data-gmap
  data-lat="{{ $lat }}"
  data-lng="{{ $lng }}"
  data-zoom="{{ $zoom }}"
  data-icon="{{ $whitePin }}"
  data-title="{{ $title }}"
  data-address="{{ $address }}"
  data-style="{{ $mapStyle }}"
  data-style-json='@if($styleJson){!! $styleJson !!}@endif'
  aria-label="Map: {{ $title ?? 'Location' }}"
></div>

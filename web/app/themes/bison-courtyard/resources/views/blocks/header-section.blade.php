{{-- resources/views/blocks/hero-section.blade.php --}}
@php
  // preview state (object or array safe)
  $isPreview = $is_preview
    ?? (is_object($block ?? null) ? ($block->preview ?? false)
    : (is_array($block ?? null) ? ($block['data']['is_preview'] ?? false) : false));

  $imgBackgroundId    = is_array($background_image ?? null) ? ($background_image['ID'] ?? null)   : ($background_image ?? null);
  $imgBackgroundAlt    = is_array($background_image ?? null) ? ($background_image['alt'] ?? '')     : '';
  $imgLeftId    = is_array($left_image ?? null) ? ($left_image['ID'] ?? null)   : ($left_image ?? null);
  $imgLeftAlt    = is_array($left_image ?? null) ? ($left_image['alt'] ?? '')     : '';
  $imgCenterId    = is_array($center_image ?? null) ? ($center_image['ID'] ?? null)   : ($center_image ?? null);
  $imgCenterAlt    = is_array($center_image ?? null) ? ($center_image['alt'] ?? '')     : '';
  $imgRightId    = is_array($right_image ?? null) ? ($right_image['ID'] ?? null)   : ($right_image ?? null);
  $imgRightAlt    = is_array($right_image ?? null) ? ($right_image['alt'] ?? '')     : '';
  $overlay   = isset($overlay_opacity) ? max(0, min(1, (float) $overlay_opacity)) : 0.35;
@endphp

<section class="relative isolate block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }} hidden md:block">
  <div class="px-8 lg:px-32 bg-gradient-to-b from-white from-50% to-theme-footer-light-tan to-50%">
    <div class="flex flex-col relative">
      @if($imgBackgroundId)
        <picture class="pointer-events-none inset-0">
          {!! wp_get_attachment_image(
              $imgBackgroundId,
              'full',
              false,
              [
                  'class'         => 'w-full aspect-17/9 object-cover',
                  'alt'           => $imgBackgroundAlt, // overrides default if needed
                  'loading'       => $isPreview ? 'lazy' : 'eager',
                  'fetchpriority' => $isPreview ? false : 'high',
                  'sizes'         => '(max-width: 1665px) 100vw, 1665px' 
              ]
          ) !!}
        </picture>
      @endif

      {{-- Overlays --}}
      <div class="absolute inset-0" style="background-color: rgba(0,0,0,{{ $overlay_opacity }});"></div>
      
      <svg viewBox="0 0 100 150" class="absolute inset-0 w-full h-full">
        <defs>
          <clipPath id="arch" clipPathUnits="objectBoundingBox">
            <!-- uniform inset: 15% left/right, 10% bottom -->
            <path d="M0.12,0.88 V0.4 
                    A0.37,0.26 0 0,1 0.88,0.4 
                    V0.88 Z"></path>
          </clipPath>
        </defs>
      </svg>
      <svg viewBox="0 0 100 150" class="absolute inset-0 w-full h-full">
        <defs>
          <clipPath id="arch-tall" clipPathUnits="objectBoundingBox">
            <path d="M0.08,0.9
                    V0.30
                    A0.42,0.3 0 0,1 0.92,0.30
                    V0.9 Z" />
          </clipPath>
        </defs>
      </svg>
      
      <div class="flex flex-col absolute inset-0 ">
        {{-- Images --}}
        <div class="grid grid-cols-[1fr_1.4fr_1fr] gap-[5%] h-full px-[5%] items-end">
          <div class="relative h-5/6 overflow-hidden {{ $left_color }} animate-fade-in" style="animation-delay: 0.5s;">
            {{-- Left Image --}}
            <div class="relative w-full h-full">
              {!! wp_get_attachment_image(
                  $imgLeftId,
                  'hero-1920',
                  false,
                  [
                    'class' => 'w-full h-full object-cover clip-arch',
                    'sizes' => '(max-width: 1920px) 25vw, 400px',
                    'alt'   => $imgCenterAlt,
                  ]
              ) !!}
            </div>
          </div>
          {{-- Center Image --}}
         <div class="relative h-full {{ $center_color }} animate-fade-in" style="animation-delay: 0s;">
            <div class="absolute top-0 h-[500px] w-full -mt-[500px] z-100 {{ $center_color }}"></div>
              <div class="relative w-full h-full clip-arch2">
                {!! wp_get_attachment_image(
                    $imgCenterId,            // attachment ID from ACF
                    'hero-1920',             // pick the registered size you want
                    false,
                    [
                      'class' => 'w-full h-full object-cover object-center clip-arch-tall',
                      'sizes' => '(max-width: 1920px) 30vw, 555px',
                      'alt'   => $imgCenterAlt,
                    ]
                ) !!}
              </div>
          </div>
          <div class="relative h-5/6 overflow-hidden {{ $right_color }} animate-fade-in" style="animation-delay: 0.25s;" >
            {{-- Right Image --}}
            <div class="relative w-full h-full">
              {!! wp_get_attachment_image(
                  $imgRightId,
                  'hero-1920',
                  false,
                  [
                    'class' => 'w-full h-full object-cover clip-arch',
                    'sizes' => '(max-width: 1920px) 25vw, 400px',
                    'alt'   => $imgRightAlt,
                  ]
              ) !!}
            </div>
          </div>
        </div>
        {{-- Content --}}
        <div class="text-white text-2xl md:text-3xl lg:text-6xl text-center w-full pt-[3%] pb-[2%] font-[800] mt-auto animate-fade-in" style="animation-delay: 0.95s;">
          {{ $heading }}
        </div>
      </div>
    </div>
    <div class="px-8 md:p-24 text-xl md:text-4xl text-center leading-[1.4] font-medium">
      {!! $sub_heading !!}
    </div>
  </div>
</section>
<section class="relative isolate block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }} md:hidden block" >
  <div class="relative w-full h-full flex flex-col justify-center items-center text-white aspect-3/2">
    <div class="absolute inset-0" style="background-color: rgba(0,0,0,{{ $overlay_opacity }});"></div>
    @if($heading)
      <h2 class="px-8 text-center absolute text-4xl font-[800] tracking-wider">{{ $heading }}</h2>
    @endif

    @if($mobile_header_image)
    <picture class="pointer-events-none inset-0">
      {!! wp_get_attachment_image(
          $mobile_header_image['id'],
          'full',
          false,
          [
              'class'         => 'w-full h-full object-cover',
              'alt'           => $imgBackgroundAlt, // overrides default if needed
              'loading'       => $isPreview ? 'lazy' : 'eager',
              'fetchpriority' => $isPreview ? false : 'high',
              'sizes'         => '100vw' 
          ]
      ) !!}
    </picture>
    @endif
  </div>
  <div class="px-8 text-xl md:text-4xl text-center leading-[1.4] py-16 bg-theme-footer-light-tan font-medium">
    {!! $sub_heading !!}
  </div>
  
</section>

{{-- resources/views/blocks/hero-section.blade.php --}}
@php
  // preview state (object or array safe)
  $isPreview = $is_preview
    ?? (is_object($block ?? null) ? ($block->preview ?? false)
    : (is_array($block ?? null) ? ($block['data']['is_preview'] ?? false) : false));

  $imgBackgroundUrl    = is_array($background_image ?? null) ? ($background_image['url'] ?? null)   : ($background_image ?? null);
  $imgBackgroundAlt    = is_array($background_image ?? null) ? ($background_image['alt'] ?? '')     : '';
  $imgLeftUrl    = is_array($left_image ?? null) ? ($left_image['url'] ?? null)   : ($left_image ?? null);
  $imgLeftAlt    = is_array($left_image ?? null) ? ($left_image['alt'] ?? '')     : '';
  $imgCenterUrl    = is_array($center_image ?? null) ? ($center_image['url'] ?? null)   : ($center_image ?? null);
  $imgCenterAlt    = is_array($center_image ?? null) ? ($center_image['alt'] ?? '')     : '';
  $imgRightUrl    = is_array($right_image ?? null) ? ($right_image['url'] ?? null)   : ($right_image ?? null);
  $imgRightAlt    = is_array($right_image ?? null) ? ($right_image['alt'] ?? '')     : '';
  $overlay   = isset($overlay_opacity) ? max(0, min(1, (float) $overlay_opacity)) : 0.35;
@endphp

<section class="relative isolate block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }}">
  <div class="px-8 lg:px-32 bg-gradient-to-b from-white from-50% to-theme-footer-light-tan to-50%">
    <div class="flex flex-col relative">
      @if($imgBackgroundUrl)
        <picture class="pointer-events-none inset-0">
          <img
            src="{{ $imgBackgroundUrl }}"
            alt="{{ $imgBackgroundAlt }}"
            class="w-full aspect-17/9 object-cover"
            loading="{{ $isPreview ? 'lazy' : 'eager' }}"
            @unless($isPreview) fetchpriority="high" @endunless
          >
        </picture>
      @endif

      {{-- Overlay --}}
      <div class="absolute inset-0" style="background-color: rgba(0,0,0,{{ $overlay_opacity }});"></div>
      
      
      <div class="flex flex-col absolute inset-0 ">
        {{-- Images --}}
        <div class="grid grid-cols-[1fr_1.4fr_1fr] gap-[5%] h-full px-[5%] items-end">
          <div class="relative h-5/6 overflow-hidden {{ $left_color }} animate-fade-in" style="animation-delay: 0.25s;">
            {{-- Left Image --}}
            <svg viewBox="0 0 100 150" class="absolute inset-0 w-full h-full">
              <defs>
                <clipPath id="arch" clipPathUnits="objectBoundingBox">
                  <!-- uniform inset: 15% left/right, 10% bottom -->
                  <path d="M0.12,0.88 V0.4 
                          A0.37,0.26 0 0,1 0.88,0.4 
                          V0.88 Z"></path>
                </clipPath>
              </defs>
              <image 
                href="{{ $imgLeftUrl }}" 
                width="100%" height="100%" 
                preserveAspectRatio="xMidYMid slice"
                clip-path="url(#arch)" />
            </svg>
          </div>
          {{-- Center Image --}}
         <div class="relative h-full {{ $center_color }} animate-fade-in-down" style="animation-delay: 0s;">
            <div class="absolute top-0 h-[500px] w-full -mt-[500px] z-100 {{ $center_color }}"></div>
            <svg viewBox="0 0 100 150" class="absolute inset-0 w-full h-full">
              <defs>
                <clipPath id="arch2" clipPathUnits="objectBoundingBox">
                  <path d="M0.04,0.9
                          V0.328
                          A0.44,0.3 0 0,1 0.96,0.328
                          V0.9
                          Z" />
                  </clipPath>
              </defs>
              <image 
                href="{{ $imgCenterUrl }}" 
                width="100%" height="100%" 
                preserveAspectRatio="xMidYMid slice"
                clip-path="url(#arch2)" />
            </svg>
          </div>


          <div class="relative h-5/6 overflow-hidden {{ $right_color }} animate-fade-in" style="animation-delay: 0.25s;" >
            {{-- Right Image --}}
            <svg viewBox="0 0 100 150" class="absolute inset-0 w-full h-full">
              <defs>
                <clipPath id="arch" clipPathUnits="objectBoundingBox">
                  <!-- uniform inset: 15% left/right, 10% bottom -->
                  <path d="M0.12,0.88 V0.4 
                          A0.37,0.26 0 0,1 0.88,0.4 
                          V0.88 Z"></path>
                </clipPath>
              </defs>
              <image 
                href="{{ $imgRightUrl }}" 
                width="100%" height="100%" 
                preserveAspectRatio="xMidYMid slice"
                clip-path="url(#arch)" />
            </svg>
          </div>
        </div>
        {{-- Content --}}
        <div class="text-white text-2xl md:text-3xl lg:text-6xl text-center w-full pt-[3%] pb-[2%] font-[800] mt-auto animate-fade-in" style="animation-delay: 0.95s;">
          {{ $heading }}
        </div>
      </div>
    </div>
    <div class="px-8 md:p-24 text-xl md:text-4xl text-center font-medium">
      {!! $sub_heading !!}
    </div>
  </div>
</section>

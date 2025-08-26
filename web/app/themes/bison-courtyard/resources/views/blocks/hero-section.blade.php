{{-- resources/views/blocks/hero-section.blade.php --}}
@php
  // preview state (object or array safe)
  $isPreview = $is_preview
    ?? (is_object($block ?? null) ? ($block->preview ?? false)
    : (is_array($block ?? null) ? ($block['data']['is_preview'] ?? false) : false));

  $imgUrl    = is_array($image ?? null) ? ($image['url'] ?? null)   : ($image ?? null);
  $imgAlt    = is_array($image ?? null) ? ($image['alt'] ?? '')     : '';
  $posterUrl = is_array($poster ?? null) ? ($poster['url'] ?? null) : ($poster ?? null);
  $overlay   = isset($overlay_opacity) ? max(0, min(1, (float) $overlay_opacity)) : 0.35;
@endphp
<section class="h-[1000px] relative isolate overflow-hidden block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }}">
  {{-- Background media --}}
  @if(($media_type ?? 'image') === 'video' && !empty($video_mp4))
    <video
      class="absolute inset-0 w-full h-full object-cover"
      autoplay muted loop playsinline
      @if($posterUrl) poster="{{ $posterUrl }}" @endif
    >
      @if(!empty($video_webm)) <source src="{{ $video_webm }}" type="video/webm">@endif
      <source src="{{ $video_mp4 }}" type="video/mp4">
    </video>
  @elseif($imgUrl)
    <picture class="pointer-events-none absolute inset-0">
      <img
        src="{{ $imgUrl }}"
        alt="{{ $imgAlt }}"
        class="absolute inset-0 w-full h-full object-cover"
        loading="{{ $isPreview ? 'lazy' : 'eager' }}"
        @unless($isPreview) fetchpriority="high" @endunless
      >
    </picture>
  @endif

  {{-- Overlay --}}
  <div class="absolute inset-0" style="background-color: rgba(0,0,0,{{ $overlay_opacity }});"></div>

  {{-- Content --}}
  <div class="absolute inset-0 z-10">
    <div class="inset-0 absolute mx-auto max-w-[1920px] px-4 py-24 md:py-36 text-center flex flex-col justify-center h-full">
      
      @if(!empty($headline))
        <h1 class="font-[800] absolute -bottom-15 w-full text-center text-3xl sm:text-4xl md:text-5xl lg:text-[180px] text-white tracking-widest animate-in">
          {{ $headline }}
        </h1>
      @endif

      @if(!empty($subheadline))
        <p class="font-[800] mt-4 text-white text-xl md:text-5xl max-w-6xl mx-auto tracking-widest leading-16 font-stretch-expanded animate-in">
          {!! $subheadline !!}
        </p>
      @endif
      
      {{-- InnerBlocks slot (buttons, etc.)
      <div class="inner-blocks mt-6">
        {!! '<InnerBlocks'.$templateAttr.' />' !!}
      </div>--}}
    </div>
  </div>
</section>

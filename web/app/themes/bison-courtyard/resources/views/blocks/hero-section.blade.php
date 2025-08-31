{{-- resources/views/blocks/hero-section.blade.php --}}
@php
  // preview state (object or array safe)
  $isPreview = $is_preview
    ?? (is_object($block ?? null) ? ($block->preview ?? false)
    : (is_array($block ?? null) ? ($block['data']['is_preview'] ?? false) : false));

  $imgId    = is_array($image ?? null) ? ($image['ID'] ?? null)   : ($image ?? null);
  $imgAlt    = is_array($image ?? null) ? ($image['alt'] ?? '')     : '';
  $posterUrl = is_array($poster ?? null) ? ($poster['url'] ?? null) : ($poster ?? null);
  $overlay   = isset($overlay_opacity) ? max(0, min(1, (float) $overlay_opacity)) : 0.35;


@endphp
<section class="h-[80vh] relative isolate overflow-hidden block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }}">
  
  {{-- Background media --}}
  @if(($media_type ?? 'image') === 'video' && ( !empty($video_mp4) || !empty($video_webm) ))
    <video
      id="hero-video"
      class="absolute inset-0 w-full h-full object-cover animate-zoom-slow"
      autoplay muted loop playsinline
      @if($posterUrl) poster="{{ $posterUrl }}" @endif
    >
      @if(!empty($video_webm)) <source src="{{ $video_webm['url']}}" type="video/webm">
      @else <source src="{{ $video_mp4 }}" type="video/mp4">
      @endif
    </video>
  @elseif($imgId)
    <picture class="pointer-events-none absolute inset-0">
      {!! wp_get_attachment_image(
          $imgId,                
          'full',                
          false,                 
          [
            'class'         => 'absolute inset-0 w-full h-full object-cover animate-zoom-slow',
            'alt'           => $imgAlt,  // overrides WP alt if needed
            'loading'       => $isPreview ? 'lazy' : 'eager',
            'fetchpriority' => $isPreview ? false : 'high',
            'sizes'         => '(max-width: 1920px) 100vw, 1920px', // optional
          ]
      ) !!}

    </picture>
  @endif

  {{-- Overlay --}}
  <div class="absolute inset-0" style="background-color: rgba(0,0,0,{{ $overlay_opacity }});"></div>

  {{-- Content --}}
  <div class="absolute inset-0 z-10">
    <div class="relative h-full px-4">
      <div class="inset-0 absolute mx-auto max-w-[1920px] py-24 md:py-36 text-center flex flex-col justify-center h-full">
        
        @if(!empty($headline))
          <h1 class="font-[800] mb-4 md:mb-0 md:absolute bottom-[-14px] xl:bottom-[-25px] w-full text-center text-4xl md:!text-[100px] xl:!text-[170px] text-white tracking-wider !leading-none animate-in-up delayed">
            {{ $headline }}
          </h1>
        @endif

        @if(!empty($subheadline))
          <h2 class="font-[800] px-8 mt-4 text-white !text-2xl md:!text-5xl max-w-6xl mx-auto tracking-widest animate-in-right">
            {!! $subheadline !!}
          </h2>
        @endif
        
        {{-- InnerBlocks slot (buttons, etc.)
        <div class="inner-blocks mt-6">
          {!! '<InnerBlocks'.$templateAttr.' />' !!}
        </div>--}}
      </div>
    </div>
  </div>
</section>
<script>
  const vid = document.getElementById('hero-video');
  vid.playbackRate = 0.75;
</script>

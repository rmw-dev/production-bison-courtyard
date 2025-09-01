<section class="relative isolate block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }} px-8 lg:px-24">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 lg:gap-x-24 gap-y-8 {{ $text_class }}">
      {{-- Left Column --}}
      <div>
      @unless(empty($text_heading))
        <div class="col-span-2 text-5xl mb-12 {{ $text_left_side ? 'order-1' : 'order-0' }}">
          {{ $text_heading }}
        </div>
      @endunless
      @unless(empty($text_content))
        <div class="prose flex flex-col {{ $text_left_side ? 'order-0' : 'order-1' }}">
          {!! $text_content !!}
        </div>
      @endunless
    </div>
    <div class="prose {{ $bleed_up ? '3xl:-mt-64' : '' }} z-50">
      @if(!empty($image['url']))
        <div class="relative flex justify-center">
          <div class="arch relative overflow-hidden rounded-t-[9999px] w-3/4">
            {!! wp_get_attachment_image(
                $image['ID'],          // requires that your ACF field returns array (ID, url, alt, etc.)
                'full',                // or a registered size, e.g. 'hero-1920'
                false,                 // icon?
                [
                  'class' => 'w-full h-full object-cover aspect-2/3 zoom-hover',
                  'alt'   => $image['alt'], // override WP alt if needed
                  'sizes' => '(max-width: 1920px) 33vw, 600px', // optional, adjust as needed
                ]
            ) !!}
            <span class="pointer-events-none absolute inset-8 rounded-t-[9999px] border border-white border-3"></span>
          </div>
        </div>
      @endif
    </div>

  </div>
  
</section>

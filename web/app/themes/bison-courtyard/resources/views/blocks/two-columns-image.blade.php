<section id="{{$block->block?->anchor ?? '' }}" class="relative isolate block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }} px-8 lg:px-24">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 lg:gap-x-24 gap-y-8 {{ $text_class }}">
    
      {{-- Left Column --}}
      <div class="{{ $text_left_side ? 'order-1' : 'order-0' }}">
      @unless(empty($text_heading))
        <div class="text-3xl md:text-5xl mb-8 md:mb-12 ">
          {{ $text_heading }}
        </div>
      @endunless
      @unless(empty($text_content))
        <div class="prose flex flex-col">
          {!! $text_content !!}
        </div>
      @endunless
      @unless(empty($text_buttons) || !is_array($text_buttons))
      <div class="flex flex-wrap gap-x-8 gap-y-4 mt-8">
        
        @foreach ($text_buttons as $button)
          <x-button 
            :href="$button['button_link']['url'] ?? '#'" 
            :variant="$button['button_style'] ?? 'primary'"
            :target="$button['button_link']['target'] ?? ''"
            class="shrink-0"
          > 
              {{ $button['button_link']['title'] ?? 'Learn More' }}
          </x-button>
        @endforeach
      </div>
      @endunless
    </div>
    <div class="prose z-50 {{ $fancy_image ? '3xl:-mt-64' : '' }} {{ $text_left_side ? 'order-0' : 'order-1' }}">
      @if(!empty($image['url']))
        <div class="relative flex justify-center">
          <div class="relative overflow-hidden {{ $fancy_image ? "rounded-t-[9999px] arch w-3/4" : "w-full aspect-video" }}">
            @if($fancy_image)
            
            {!! wp_get_attachment_image(
                $image['ID'],          
                'full',                
                false,                 
                [
                  'class' => 'w-full h-full object-cover aspect-2/3 zoom-hover',
                  'alt'   => $image['alt'], // override WP alt if needed
                  'sizes' => '(max-width: 1920px) 33vw, 600px', // optional, adjust as needed
                ]
            ) !!}
            @else
              {!! wp_get_attachment_image(
                  $image['ID'],          
                  'full',                
                  false,                 
                  [
                    'class' => 'w-full object-cover zoom-hover',
                    'alt'   => $image['alt'], 
                    'sizes' => '(max-width: 1920px) 50vw, 860px',
                  ]
              ) !!}
            @endif
            @if($fancy_image)
              <span class="pointer-events-none absolute inset-4 md:inset-8 rounded-t-[9999px] border border-white border-3"></span>
            @else
              <span class="pointer-events-none absolute inset-4 md:inset-8 border border-white border-3"></span>
            @endif

          </div>
        </div>
      @endif
    </div>

  </div>
  
</section>

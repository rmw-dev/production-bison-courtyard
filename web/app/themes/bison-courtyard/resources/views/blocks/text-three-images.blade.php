<section class="relative block-three-images-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }}">
  <div class="mx-auto max-w-[1920px] px-4 md:px-32">
    
    <div class="grid grid-cols-32 auto-rows-32">
      
      {{-- LEFT COLUMN: Heading + Content --}}
      
        @if(!empty($heading))
          <h2 class="col-start-1 col-end-33 flex flex-col justify-center text-theme-black font-[800] text-3xl md:text-5xl mb-24 text-center">
            {{ $heading }}
          </h2>
        @endif

      
        @if(!empty($content))
          <div class="prose prose-lg py-24 text-theme-black row-start-2 row-end-3 col-start-1 col-end-31 lg:col-end-18 max-w-none">
            {!! $content !!}
          </div>
        @endif

        {{-- RIGHT COLUMN: Arched image --}}
        @if(!empty($image_1['url']))
            <div class="relative flex justify-center col-start-21 col-end-32 row-start-2 row-end-3 overflow-hidden">
                <div class="arch relative overflow-hidden rounded-t-[9999px] w-3/4 lg:w-full">
                    <img src="{{ $image_1['url'] }}" alt="{{ $image_1['alt'] }}" class="w-full object-cover aspect-2/3 zoom-hover">
                    <span class="pointer-events-none absolute inset-10 rounded-t-[9999px] border border-white border-3"></span>
                </div>
            </div>
        @endif

        {{-- BOTTOM ROW: Two images side by side --}}
        
        @if(!empty($image_2['url']))
            <div class="relative row-start-3 row-end-4 col-start-3 col-end-14 -mt-24 aspect-square overflow-hidden">
              <img src="{{ $image_2['url'] }}" alt="{{ $image_2['alt'] }}" class="w-full aspect-square object-cover zoom-hover">
              <span class="pointer-events-none absolute inset-10 border border-white border-3"></span>
            </div>
        @endif

        @if(!empty($image_3['url']))
            <div class="relative row-start-3 row-end-4 col-start-16 col-end-31 mt-24 aspect-3/2 overflow-hidden">
            <img src="{{ $image_3['url'] }}" alt="{{ $image_3['alt'] }}" class="w-full h-full object-cover zoom-hover">
            <span class="pointer-events-none absolute inset-10 border border-white border-3"></span>
            </div>
        @endif
        
    </div>

    
  </div>
</section>

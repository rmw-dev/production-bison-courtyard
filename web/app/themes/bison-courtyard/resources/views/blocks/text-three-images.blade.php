<section class="relative block-three-images-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }}">
  @if(!empty($heading))
      <h2 class="flex flex-col justify-center bg-theme-footer-light-tan lg:{{ $layout['background_color'] ?? '' }} font-[800] text-3xl md:text-5xl py-16 lg:mb-8 text-center px-8 lg:px-32">
        {{ $heading }}
      </h2>
    @endif
  <div class="mx-auto max-w-[1920px] px-8 lg:px-32">
    <div class="grid grid-cols-32 auto-rows-32">
      
      {{-- LEFT COLUMN: Heading + Content --}}
      
        @if(!empty($content))
          <div class="prose prose-lg py-8 md:py-16 2xl:py-24 text-theme-black row-start-2 row-end-3 col-start-1 col-end-31 lg:col-end-18 max-w-none">
            {!! $content !!}
          </div>
        @endif

        {{-- RIGHT COLUMN: Arched image --}}
        @if(!empty($image_1['url']))
            <div class="relative flex justify-center col-start-21 col-end-32 row-start-2 row-end-3 overflow-hidden hidden lg:block">
                <div class="arch relative overflow-hidden rounded-t-[9999px] lg:w-full">
                    <img src="{{ $image_1['url'] }}" alt="{{ $image_1['alt'] }}" class="w-full object-cover aspect-2/3 zoom-hover">
                    <span class="pointer-events-none absolute inset-4 lg:inset-10 rounded-t-[9999px] border border-white  border-3"></span>
                </div>
            </div>
        @endif

        {{-- BOTTOM ROW: Two images side by side --}}
        
        @if(!empty($image_2['url']))
            <div class="relative row-start-3 row-end-4 col-start-1 2xl:col-start-3 col-end-33 md:col-end-14 2xl:-mt-24 aspect-square overflow-hidden">
              <img src="{{ $image_2['url'] }}" alt="{{ $image_2['alt'] }}" class="w-full aspect-square object-cover zoom-hover">
              <span class="pointer-events-none absolute inset-4 lg:inset-10 border border-white border-3"></span>
            </div>
        @endif

        @if(!empty($image_3['url']))
            <div class="relative row-start-4 md:row-start-3 row-end-4 col-start-1 md:col-start-16 col-end-33 2xl:col-end-31 2xl:mt-24 aspect-3/2 overflow-hidden mt-8">
            <img src="{{ $image_3['url'] }}" alt="{{ $image_3['alt'] }}" class="w-full h-full object-cover zoom-hover">
            <span class="pointer-events-none absolute inset-4 lg:inset-10 border border-white border-3"></span>
            </div>
        @endif
        
    </div>

    
  </div>
</section>

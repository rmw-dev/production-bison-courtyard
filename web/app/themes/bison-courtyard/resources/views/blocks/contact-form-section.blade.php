<section id="{{$block->block?->anchor ?? '' }}" class="relative isolate overflow-hidden block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }} px-8 md:px-24">
  <div class="grid lg:grid-cols-2 gap-12 lg:gap-24">
    <div>
      @unless(empty($left_heading))
      <div class="col-span-2 text-5xl font-[800]">
        {{ $left_heading }}
      </div>
      @endunless
      
      @unless(empty($left_content))
      <div class="prose pt-8 flex flex-col ">
        {!! $left_content !!}
      </div>
      @endunless
      <x-google-map
        lat="51.17730601621462"
        lng="-115.57257007801668"
        zoom="17"
        icon="{{ Vite::asset('resources/images/pin.svg') }}"
        title="Bison Courtyard"
        address="211 Bear St, Banff, AB"
        mapStyle="bison"
        height="520px"
        class="rounded-xl overflow-hidden mt-10"
      />
    </div>
    <div class="prose">
      @unless(empty($right_heading))
      <div class="col-span-2 !text-5xl font-[800]">{{ $right_heading }}</div>
      @endunless
      @unless(empty($right_content))
      <div class="prose pt-8 flex flex-col ">
        {!! $right_content !!}
      </div>
      @endunless
      @unless(empty($show_form) || empty($form_type))
        @include($form_type)
      @endunless
    </div>
  </div>
  
</section>

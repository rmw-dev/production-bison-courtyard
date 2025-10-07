<section id="{{$block->block?->anchor ?? '' }}" class="relative isolate overflow-hidden block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }} {{ $has_overlapping_image_below === '1' ? 'pb-32' : '' }} {{ $bison_tracks_bg !== 'None'  ? 'bison-print-bg' : '' }} px-8 lg:px-24">
  @unless(empty($left_heading) && empty($right_heading))
  <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 {{ $text_class }}">
    @unless(empty($left_heading))
    <h2 class="!text-3xl md:!text-5xl mb-8 md:!mb-4">
      {{ $left_heading }}
    </h2>
    @endunless
    @unless(empty($right_heading))
      <h2 class="hidden md:block md:pl-10 !text-5xl">
        {{ $right_heading }}
      </h2>
    @endunless
  </div>
  @endunless
  <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 {{ $text_class }}">
    @unless(empty($left_content))
    <div class="prose flex flex-col pb-8 md:py-8 {{ $left_vertical_center_align_class }}">
      {!! $left_content !!}
    </div>
    @endunless
    @unless(empty($right_heading))
      <h2 class="text-3xl md:!text-5xl md:hidden md:pt-12 mb-8">
        {{ $right_heading }}
      </h2>
    @endunless
    @unless(empty($right_content))
    <div class="prose md:pl-10 md:border-l border-current md:py-8 {{ $right_vertical_center_align_class }} {{ $has_overlapping_image_below === 'Right' ? '3xl:!pb-32' : '' }}">
      {!! $right_content !!}
    </div>
    @endunless
  </div>


  @if (!empty($bison_tracks_bg) && $bison_tracks_bg !== 'None')
  <div class="-z-10 absolute bottom-0 left-0 right-0 top-0 overflow-hidden" >
    <div class="absolute w-full bottom-0  leading-none pointer-events-none text-[#f5f1ed] {{ $bison_tracks_bg === 'Right' ? 'scale-x-[-1]' : '' }}">
      {!! file_get_contents(Vite::asset('resources/images/bison-tracks.svg')); !!}
    </div>
  </div>
  @endif
  
</section>


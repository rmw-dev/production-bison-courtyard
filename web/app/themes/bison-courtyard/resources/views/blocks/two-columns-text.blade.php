{{-- resources/views/blocks/hero-section.blade.php --}}

<section class="relative isolate overflow-hidden block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }} {{ $has_overlapping_image_below === '1' ? 'pb-32' : '' }} px-24">
  <div class="grid grid-cols-2 gap-x-16 {{ $text_class }}">
    @unless(empty($left_heading))
    <div class="col-span-2 text-5xl mb-4">
      {{ $left_heading }}
    </div>
    @endunless
    @unless(empty($left_content))
    <div class="prose pt-8 flex flex-col {{ $left_vertical_center_align_class }}">
      {!! $left_content !!}
    </div>
    @endunless

    <div class="prose pt-8 pl-10 border-l border-current {{ $right_vertical_center_align_class }} {{ $has_overlapping_image_below === 'Right' ? 'pb-32' : '' }}">
      @unless(empty($right_heading))
      <div class="col-span-2 text-5xl mb-4">
        {{ $right_heading }}
      </div>
      @endunless
      {!! $right_content !!}
    </div>
  </div>
</section>

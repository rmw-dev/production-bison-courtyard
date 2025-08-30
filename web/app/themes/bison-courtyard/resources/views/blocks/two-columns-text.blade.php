{{-- resources/views/blocks/hero-section.blade.php --}}

<section class="relative isolate overflow-hidden block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }} {{ $has_overlapping_image_below === '1' ? 'pb-32' : '' }} px-8 lg:px-24">
  @unless(empty($left_heading) && empty($right_heading))
  <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 {{ $text_class }}">
    @unless(empty($left_heading))
    <div class="text-5xl">
      {{ $left_heading }}
    </div>
    @endunless
    @unless(empty($right_heading))
      <div class="hidden md:block md:pl-10 text-5xl">
        {{ $right_heading }}
      </div>
    @endunless
  </div>
  @endunless
  <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 {{ $text_class }}">
    @unless(empty($left_content))
    <div class="prose flex flex-col py-8 {{ $left_vertical_center_align_class }}">
      {!! $left_content !!}
    </div>
    @endunless
    @unless(empty($right_heading))
      <div class="text-5xl md:hidden pt-4 md:pt-12 mb-4">
        {{ $right_heading }}
      </div>
    @endunless
    @unless(empty($right_content))
    <div class="prose md:pl-10 md:border-l border-current md:py-8 {{ $right_vertical_center_align_class }} {{ $has_overlapping_image_below === 'Right' ? '3xl:!pb-32' : '' }}">
      {!! $right_content !!}
    </div>
    @endunless
  </div>
</section>

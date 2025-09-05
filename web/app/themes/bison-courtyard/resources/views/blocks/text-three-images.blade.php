<section class="relative block-three-images-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }}">
  @if(!empty($heading))
    <h2 class="flex flex-col justify-center bg-theme-footer-light-tan lg:{{ $layout['background_color'] ?? '' }} font-[800] text-3xl md:text-5xl py-16 lg:mb-8 text-center px-8 lg:px-32">
      {{ $heading }}
    </h2>
  @endif
  @if(!empty($show_event && $show_event === true))
    <div class="w-full bg-theme-footer-light-tan px-32 py-16 mb-16 text-xl grid grid-cols-2 gap-16 justify-center items-center">
      <div class="">
        <h2 class="font-[800] mb-4">Featured Event</h2>
        <h3 class="mb-2"> {{ $featured_event->post_title }}</h2>
        <p class="mt-0 mb-10 border-b pb-4">{{ get_field('event_date_start', $featured_event->ID) }}</p>
        <div class="prose">{!! get_field('event_featured_excerpt', $featured_event->ID) !!}</div>
      </div>
      <div>
         {!! wp_get_attachment_image(get_field('event_featured_image', $featured_event->ID), 'full', false, ['class' => 'w-full']); !!}
      </div>
    </div>
  @endif

  <div class="mx-auto max-w-[1920px] px-8 lg:px-32">
    <div class="grid grid-cols-32 auto-rows-32">
      @if(!empty($image_1['id']))
          <div class="md:hidden w-full col-start-1 col-end-33 pt-8">
              <div class="arch relative overflow-hidden rounded-t-[9999px] lg:w-full">
                  {!! wp_get_attachment_image(
                    $image_1['ID'],      
                    'full',              
                    false,               
                    [
                      'class' => 'w-full object-cover aspect-2/3 zoom-hover',
                      'alt'   => $image_1['alt'], 
                      'sizes' => '100vw',
                    ]
                  ) !!}
                  <span class="pointer-events-none absolute inset-4 lg:inset-8 rounded-t-[9999px] border border-white  border-3"></span>
              </div>
          </div>
      @endif
      
      {{-- LEFT COLUMN: Heading + Content --}}
      
        @if(!empty($content))
          <div class="prose prose-lg py-8 md:py-16 2xl:py-24 text-theme-black row-start-2 row-end-3 col-start-1 col-end-33 lg:col-end-18 max-w-none">
            {!! $content !!}
          </div>
        @endif

        {{-- RIGHT COLUMN: Arched image --}}
        @if(!empty($image_1['url']))
            <div class="relative flex justify-center col-start-21 col-end-32 row-start-2 row-end-3 overflow-hidden hidden lg:block">
                <div class="arch relative overflow-hidden rounded-t-[9999px] lg:w-full">
                    {!! wp_get_attachment_image(
                        $image_1['ID'],      
                        'full',              
                        false,               
                        [
                          'class' => 'w-full object-cover aspect-2/3 zoom-hover',
                          'alt'   => $image_1['alt'],
                          'sizes' => '(max-width: 1920px) 33vw, 600px', 
                        ]
                    ) !!}
                    <span class="pointer-events-none absolute inset-4 lg:inset-8 rounded-t-[9999px] border border-white  border-3"></span>
                </div>
            </div>
        @endif

        {{-- BOTTOM ROW: Two images side by side --}}
        
        @if(!empty($image_2['url']))
            <div class="relative row-start-3 row-end-4 col-start-1 2xl:col-start-3 col-end-33 md:col-end-14 2xl:-mt-24 aspect-square overflow-hidden">
              {!! wp_get_attachment_image(
                  $image_2['ID'],
                  'full',
                  false,
                  [
                    'class' => 'w-full aspect-square object-cover zoom-hover',
                    'alt'   => $image_2['alt'],
                    'sizes' => '(max-width: 768px) 100vw, (max-width: 1920px) 50vw, 600px',
                  ]
              ) !!}
              <span class="pointer-events-none absolute inset-4 lg:inset-8 border border-white border-3"></span>
            </div>
        @endif

        @if(!empty($image_3['url']))
            <div class="relative row-start-4 md:row-start-3 row-end-4 col-start-1 md:col-start-16 col-end-33 2xl:col-end-30 2xl:mt-24 aspect-3/2 overflow-hidden mt-8">
              {!! wp_get_attachment_image(
                    $image_3['ID'],
                    'full',
                    false,
                    [
                      'class' => 'w-full h-full object-cover zoom-hover',
                      'alt'   => $image_3['alt'],
                      'sizes' => '(max-width: 768px) 100vw, (max-width: 1920px) 50vw, 600px',
                    ]
                ) !!}
              <span class="pointer-events-none absolute inset-4 lg:inset-8 border border-white border-3"></span>
            </div>
        @endif
        
    </div>

    
  </div>
</section>

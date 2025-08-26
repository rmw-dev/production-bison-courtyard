@extends('layouts.app')

@section('content')

  <div class="container mx-auto max-w-[1920px]">
    <div class="relative aspect-3/1">
      <div class="bg-white h-[50%]">
      </div>
      <div class="bg-theme-dark-blue h-[50%]">
      </div>
      
      <div class="absolute bottom-[0%] w-full px-32 h-full">
        {{-- Featured image --}}
        @if (has_post_thumbnail())
          <div class="w-full h-full overflow-hidden rounded-t-4xl">
              <div class="arch relative rounded-t-xl h-full">
                  @if (has_post_thumbnail())
                    {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full object-cover object-top h-full']) !!}
                  @endif
                  <span class="pointer-events-none absolute inset-10 rounded-t-xl border border-white border-3"></span>
              </div>
          </div>
        @endif
      </div>
    </div>
    <div class="bg-theme-dark-blue flex flex-col justify-center pt-12 pb-16 text-white text-center">
        {{ the_title( '<h1 class="text-4xl lg:text-5xl font-[800] px-32 pb-4">', '</h1>' ) }}
        <p class="text-xl">{{ $date_string}}</p>
      </div>
    <div class="px-32 py-24 text-xl grid grid-cols-[1fr_500px] gap-x-16 gap-y-8 lg:gap-y-16">
      <div class="prose">
      {!! the_content() !!}
      </div>
      <div class="border-l border-black pl-10">
        <h2 class="text-3xl font-[800]">Upcoming Events</h2>

        <div class="mt-8 grid grid-cols-1 gap-8">
          @php
            $today = date('Ymd');
            $events = new WP_Query([
              'post_type' => 'event',
              'posts_per_page' => 2,
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => [
                [
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'NUMERIC'
                ]
              ]
            ]);
          @endphp

          @if ($events->have_posts())
            @while ($events->have_posts()) @php $events->the_post() @endphp
              @include('partials.cards.event-card', ['i' => 0])
            @endwhile
          @endif
          </div>
    </div>
    </div>
    
  </div>
@endsection

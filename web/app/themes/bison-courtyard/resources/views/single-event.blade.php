@extends('layouts.app')

@section('content')

  <div class="container mx-auto max-w-[1920px] mt-8 md:mt-0">
    <div class="relative aspect-2/1 md:aspect-4/1">
      <div class="bg-white h-[50%]">
      </div>
      <div class="bg-theme-dark-blue h-[50%]">
      </div>
      
      <div class="absolute bottom-[0%] w-full px-8 lg:px-32 h-full">
        {{-- Featured image --}}
        @if (has_post_thumbnail())
          <div class="w-full h-full overflow-hidden rounded-t-4xl">
              <div class="arch relative rounded-t-xl h-full">
                  @if (has_post_thumbnail())
                    {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full object-cover object-top h-full']) !!}
                  @endif
                  <span class="pointer-events-none absolute inset-4 lg:inset-8 rounded-t-xl border border-white border-3"></span>
              </div>
          </div>
        @endif
      </div>
    </div>
    <div class="bg-theme-dark-blue flex flex-col justify-center pt-12 pb-16 text-white text-center">
        {{ the_title( '<h1 class="text-4xl lg:text-5xl font-[800] px-8 lg:px-32 pb-4">', '</h1>' ) }}
        <p class="text-xl">{{ $date_string}}</p>
      </div>
    <div class="px-8 lg:px-32 pt-8 lg:pt-24 text-xl grid xl:grid-cols-[1fr_350px] gap-x-16 gap-y-8 lg:gap-y-16">
      <div class="prose">
      {!! the_content() !!}
      </div>
      <div class="xl:border-l border-black xl:pl-10">
        <h2 class="text-3xl font-[800]">Upcoming Events</h2>
        <div class="mt-8 grid md:grid-cols-2 xl:grid-cols-1 gap-8">
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
             @php $i = 0; @endphp
            @while ($events->have_posts()) @php $events->the_post() @endphp
              @include('partials.cards.event-card', ['i' => $i++])
            @endwhile
          @else
            No additional upcoming events.
          @endif
            <h2 class="text-3xl font-[800]">Explore More</h2>
            <div class="prose">
              <p><a href="/" class="text-blue-500 hover:underline">Home</a></p>
              <p><a href="/discover" class="text-blue-500 hover:underline">Store Directory</a></p>
              <p><a href="/events" class="text-blue-500 hover:underline">Back to Events</a></p>
            </div>
        </div>
    </div>
    
    </div>
    <div class="hidden md:flex items-center flex-col bg-theme-footer-light-tan justify-center py-8 lg:py-16 gap-8 mt-8 lg:mt-16 text-center">
      <h2>Explore More at the Bison Courtyard</h2>
      <div class="flex flex-wrap gap-x-8 gap-y-4 shrink-0 justify-center">
        <x-button href="/events" variant="tertiary">Events</x-button>
        <x-button href="/" variant="tertiary">Home</x-button>
      </div>
    </div>
  </div>
@endsection

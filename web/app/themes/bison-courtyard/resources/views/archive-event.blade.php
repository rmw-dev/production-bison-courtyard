@extends('layouts.app')

@section('content')
  @php
    //page for template
    $page_id = 141;
  @endphp

  <div class="container mx-auto max-w-[1920px]">
    
    @if ($page_id)
      <div class="prose max-w-none mb-10">
        {!! do_blocks( get_post_field('post_content', $page_id) ) !!}
      </div>
    @endif

    {{-- Native archive loop (pagination, SEO, all intact) --}}
    @if (have_posts())
      <div class="grid gap-8 sm:grid-cols-2 xl:grid-cols-3 lg:grid-cols-2 container mx-auto max-w-[1920px] pt-24 px-32">
        @php $i = 0; @endphp
        @while (have_posts()) @php the_post() @endphp
          @include('partials.cards.event-card')
        @php $i++; @endphp
        @endwhile
      </div>

      <div class="mt-10 w-full flex justify-center">
        {{-- Pagination --}}
        {!! the_posts_pagination([
          'prev_text' => '←',
          'next_text' => '→',
        ]) !!}
      </div>
    @else
      <p class="text-gray-600">{{ __('No events found.', 'td') }}</p>
    @endif
  </div>

@endsection

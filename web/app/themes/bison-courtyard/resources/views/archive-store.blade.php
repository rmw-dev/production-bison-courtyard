@extends('layouts.app')

@section('content')
  @php
    //page for template
    $page_id = 152;
  @endphp

  <div class="container mx-auto max-w-[1920px]">
    
    @if ($page_id)
      <div class="prose max-w-none mb-10">
        {!! do_blocks( get_post_field('post_content', $page_id) ) !!}
      </div>
    @endif

    {{-- Native archive loop (pagination, SEO, all intact) --}}
    @if (have_posts())

      @php
        // Collect posts from the main (paginated) query
        $stores = [];
        while (have_posts()) { the_post(); $stores[] = get_post(); }
        rewind_posts();

        // Group by store_type
        $groups = [];   // term_id => ['term' => WP_Term, 'posts' => []]
        $untagged = [];

        foreach ($stores as $p) {
          $terms = wp_get_post_terms($p->ID, 'store_type', ['orderby' => 'name', 'order' => 'ASC']);
          if (empty($terms) || is_wp_error($terms)) {
            $untagged[] = $p;
            continue;
          }
          // If a store has multiple types, it will appear in multiple groups.
          foreach ($terms as $t) {
            $id = $t->term_id;
            if (!isset($groups[$id])) {
              $groups[$id] = ['term' => $t, 'posts' => []];
            }
            $groups[$id]['posts'][] = $p;
          }
        }

        // Sort groups by term name
        uasort($groups, fn($a, $b) => strcasecmp($a['term']->name, $b['term']->name));
      @endphp

      {{-- Render grouped stores --}}
      @foreach ($groups as $group)
        <h2 class="mt-16 text-2xl font-bold">{!! $group['term']->name !!}</h2>

        <div class="grid gap-8 sm:grid-cols-2 xl:grid-cols-3 lg:grid-cols-2 pt-8">
          @foreach ($group['posts'] as $p)
            @php $post = $p; setup_postdata($post); @endphp
            @include('partials.cards.store-card', ['i' => 0]) {{-- or your card partial --}}
          @endforeach
        </div>
      @endforeach

      @if (!empty($untagged))
        <h2 class="mt-16 text-2xl font-bold">Other</h2>
        <div class="grid gap-8 sm:grid-cols-2 xl:grid-cols-3 lg:grid-cols-2 pt-8">
          @foreach ($untagged as $p)
            @php $post = $p; setup_postdata($post); @endphp
            @include('partials.cards.store-card', ['i' => 0]) {{-- or your card partial --}}
          @endforeach
        </div>
      @endif

      @php wp_reset_postdata(); @endphp

      <div class="mt-10 w-full flex justify-center">
        {!! the_posts_pagination(['prev_text' => '←', 'next_text' => '→']) !!}
      </div>

    @else
      <p class="text-gray-600">{{ __('No stores found.', 'td') }}</p>
    @endif

  </div>

@endsection

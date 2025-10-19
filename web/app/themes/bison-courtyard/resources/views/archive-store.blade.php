@extends('layouts.app')

@section('content')
  @php $page_id = 152; 
  global $wp_query;
  @endphp

  <div class="container mx-auto max-w-[1920px]">
    <div class="prose max-w-none mb-0 lg:mb-10">
      {!! do_blocks(get_post_field('post_content', $page_id)) !!}
    </div>

    <div class="mx-8 lg:mx-16">
      {{-- Native archive loop (pagination, SEO, all intact) --}}
      @if ($wp_query->have_posts())

        @php
          global $wp_query;

          // Collect posts from the main (paginated) query
          $stores = $wp_query->posts;

          // Group by store_type
          $groups   = []; // term_id => ['term' => WP_Term, 'posts' => []]
          $untagged = [];

          foreach ($stores as $p) {
            $terms = wp_get_post_terms($p->ID, 'store_type', [
              'orderby' => 'name',
              'order'   => 'ASC'
            ]);

            if (empty($terms) || is_wp_error($terms)) {
              $untagged[] = $p;
              continue;
            }

            foreach ($terms as $t) {
              $id = $t->term_id;
              if (!isset($groups[$id])) {
                $groups[$id] = ['term' => $t, 'posts' => []];
              }

              // Ensure no dupes in this group
              if (!in_array($p->ID, wp_list_pluck($groups[$id]['posts'], 'ID'))) {
                $groups[$id]['posts'][] = $p;
              }
            }
          }

          // Sort groups by name
          uasort($groups, fn($a, $b) => strcasecmp($a['term']->name, $b['term']->name));
        @endphp

        {{-- Render grouped stores --}}
        @foreach ($groups as $group)
          <h2 id="{{ $group['term']->slug}}" class="pt-16 !text-3xl md:!text-5xl font-medium uppercase tracking-wider">
            {!! $group['term']->name !!}
          </h2>

          <div class="grid gap-24 xl:gap-32 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 pt-8 pr-[20%] md:pr-[10%] xl:pr-[2%] mb-16">
            @php $i = 0; @endphp
            @foreach ($group['posts'] as $p)
              @php
                global $post;
                $post = $p;
                setup_postdata($post);
              @endphp
              @include('partials.cards.store-card')
              @php $i++; @endphp
            @endforeach
            @php wp_reset_postdata(); @endphp
          </div>
        @endforeach

        @if (!empty($untagged))
          <h2 class="mt-16 text-2xl font-bold">Other</h2>
          <div class="grid gap-8 sm:grid-cols-2 xl:grid-cols-3 lg:grid-cols-2 pt-8">
            @foreach ($untagged as $p)
              @php
                global $post;
                $post = $p;
                setup_postdata($post);
              @endphp
              @include('partials.cards.store-card', ['i' => 0])
            @endforeach
            @php wp_reset_postdata(); @endphp
          </div>
        @endif

        <div class="mt-10 w-full flex justify-center">
          {!! the_posts_pagination(['prev_text' => '←', 'next_text' => '→']) !!}
        </div>

      @else
        <p class="text-gray-600">{{ __('No stores found.', 'td') }}</p>
      @endif
    </div>
  </div>
@endsection

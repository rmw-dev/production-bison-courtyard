<article 
    class="event-card border rounded-t-xl overflow-hidden opacity-0 hover:-translate-y-2 duration-300 ease-out"
    style="animation-delay: {{ $i * 150 }}ms"
>
    <a href="{{ get_permalink() }}" class="block">
        <div class="arch relative overflow-hidden rounded-t-xl w-3/4 lg:w-full">
            @if (has_post_thumbnail())
        {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full aspect-2/1 object-cover', 'style' => "animation-delay: {{ $i * 150 + 150 }}ms"]) !!}
        @endif
            <span class="pointer-events-none absolute inset-6 rounded-t-xl border border-white border-2"></span>
        </div>
        
        <div class="px-8 py-6">
        <h2 class="text-xl font-[800] mb-2">{!! get_the_title() !!}</h2>
        <time datetime="{{ get_post_time('c', true) }}" class="block text-sm text-gray-500 mb-3">
            
        </time>
        <p class="text-gray-700 text-base">{{ get_the_excerpt() }}</p>
        <p class="mt-4 text-sm font-[800]">READ MORE &rarr;</p>
        
        </div>
    </a>
</article>

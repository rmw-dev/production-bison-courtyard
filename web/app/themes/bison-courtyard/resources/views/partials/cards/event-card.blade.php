<article 
    class="group event-card border rounded-t-xl overflow-hidden opacity-0 hover:bg-theme-footer-light-tan/30 hover:shadow duration-300 ease-out will-change-transform"
    style="animation-delay: {{ $i * 150 }}ms"
>
    <a href="{{ get_permalink() }}" class="block">
        <div class="arch relative overflow-hidden rounded-t-xl w-3/4 w-full">
            @if (has_post_thumbnail())
        {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full aspect-2/1 object-cover', 'style' => "animation-delay: {{ $i * 150 + 150 }}ms"]) !!}
        @endif
            <span class="pointer-events-none absolute inset-6 rounded-t-xl border border-white border-2"></span>
        </div>
        
        <div class="px-8 py-6">
        <h2 class="!text-xl font-[800] mb-2">{!! get_the_title() !!}</h2>
        <time datetime="{{ get_post_time('c', true) }}" class="block text-sm text-gray-500 mb-3">
            {{ $date_string }}
        </time>
        <p class="text-gray-700 text-base">{{ get_the_excerpt() }}</p>
        <p class="flex items-center gap-2 mt-4 text-sm font-[800]">READ MORE <span class="inline-block group-hover:translate-x-1 duration-300">@svg('heroicon-o-arrow-right','w-4 h-4 text-theme-orange transition-color duration-300 hover:text-theme-brown')</span></p>
        
        </div>
    </a>
</article>

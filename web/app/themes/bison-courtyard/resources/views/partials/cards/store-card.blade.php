<article 
    class="store-card aspect-square border overflow-hidden hover:-translate-y-2 duration-300 ease-out p-4"
    style="animation-delay: {{ $i * 150 }}ms"
>
    <a href="{{ get_permalink() }}" class="block">
      
            @if (has_post_thumbnail())
                {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full aspect-square object-contain']) !!}
            @endif    

        
    </a>
</article>

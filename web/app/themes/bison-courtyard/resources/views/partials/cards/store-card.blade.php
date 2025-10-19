<a href="{{ get_permalink() }}" class="">
    <article 
        class="store-card hover:-translate-y-2 duration-300 ease-out aspect-2/3 opacity-0"
        style="animation-delay: {{ $i * 150 }}ms"
    >   
        <div class="relative flex justify-center w-full h-full">
            <div class="arch overflow-hidden rounded-t-[9999px] lg:w-full lg:h-full relative">
                
                {!! wp_get_attachment_image( get_field('store_image'), 'full', false, ['class' => 'w-full h-full object-cover'] ) !!}
                <span class="pointer-events-none absolute inset-2 lg:inset-4 rounded-t-[9999px] border border-white border-2"></span>
            </div>
            <div class="aspect-square rounded-full bg-white flex p-4 justify-center items-center border-2 absolute bottom-0 right-0 translate-x-1/3 translate-y-1/3 w-3/5">
                @if (has_post_thumbnail())
                    {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-4/5 h-4/5 aspect-square object-contain']) !!}
                @endif 
            <div>
        </div>
    </article>
</a>

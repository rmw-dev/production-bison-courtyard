<section id="{{$block->block?->anchor ?? '' }}" class="relative isolate overflow-hidden block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }} md:px-8 lg:px-24">

    <div class="flex items-center flex-col justify-center px-8 py-16 gap-8 text-center {{ $text_color }} {{ $banner_background_color }}">
        <h2 class="text-3xl md:!text-5xl font-[800]">{{ $heading }}</h2>
        @unless(empty($sub_heading))
        <div class="text-xl md:text-2xl">{{ $sub_heading }}</div>
        @endunless
        <div class="flex flex-wrap gap-x-8 gap-y-4 shrink-0 justify-center">        
        @foreach ($buttons as $button)
            <x-button 
            :href="$button['button_link']['url'] ?? '#'" 
            :variant="$button['button_style'] ?? 'primary'"
            :target="$button['button_link']['target'] ?? ''"
            class="shrink-0"
            > 
                {{ $button['button_link']['title'] ?? 'Learn More' }}
            </x-button>
        @endforeach
        </div>
    </div>
</section>

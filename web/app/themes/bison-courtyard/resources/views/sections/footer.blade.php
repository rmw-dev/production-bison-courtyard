<footer class="content-info max-w-[1920px] mx-auto relative mt-24">
  <div>
    @php(dynamic_sidebar('sidebar-footer'))
    <img src="{{ Vite::asset('resources/images/mountain-range.svg') }}" class="w-full" alt="{!! $siteName !!}">
    <div class="absolute inset-0 flex items-center justify-center text-theme-brown font-[800] text-theme-brown text-base md:text-2xl lg:text-3xl xl:text-5xl w-2/3 lg:w-3/4 mx-auto spacing-">
      <div class="leading-[1.4] text-center self-start h-1/6 md:h-1/3 lg:h-4/5 flex justify-center flex-col">
        <div>
          <span class="tracking-wider">BISON COURTYARD ON BEAR STREET</span><br />
            eat. drink. shop. explore. revitalize.
          </div>
      </div>
    </div>
    <div class="flex flex-wrap justify-center items-center lg:grid lg:grid-cols-5 bg-theme-footer-tan gap-16 pb-8 text-xl leading-relaxed text-center text-theme-brown font-[800] pt-16">
      <div class="min-w-96 lg:min-w-0"><?php dynamic_sidebar( 'footer-1' ); ?></div>
      <div class="min-w-96 lg:min-w-0"><?php dynamic_sidebar( 'footer-2' ); ?></div>
      <div class="w-full lg:w-auto flex justify-center order-last lg:order-none shrink-0"><img src="{{ Vite::asset('resources/images/logo-full-colour.svg') }}" class="w-[225px]" alt="{!! $siteName !!}"></div>
      <div class="min-w-96 lg:min-w-0"><?php dynamic_sidebar( 'footer-3' ); ?></div>
      <div class="min-w-96 lg:min-w-0"><?php dynamic_sidebar( 'footer-4' ); ?></div>
        
    </div>
    <div class="text-center text-theme-brown p-4 bg-theme-footer-tan font-[800]">
      &copy; {{ date('Y') }} {{ $siteName }}.
    </div>
  </div>
</footer>

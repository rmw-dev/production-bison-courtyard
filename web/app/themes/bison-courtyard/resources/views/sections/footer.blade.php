<footer class="content-info max-w-[1920px] mx-auto relative mt-8 md:mt-24">
  <div>
    @php(dynamic_sidebar('sidebar-footer'))
    <img src="{{ Vite::asset('resources/images/mountain-range.svg') }}" class="w-full" alt="{!! $siteName !!}">
    <div class="absolute inset-0 flex items-center justify-center text-theme-brown font-[800] text-theme-brown text-base md:text-2xl lg:text-3xl xl:text-5xl w-2/3 lg:w-3/4 mx-auto spacing-">
      <div class="leading-[1.4] text-center self-start h-1/6 md:h-1/3 lg:h-4/5 flex justify-center flex-col">
        <div class="hidden md:block">
          <span class="tracking-wider">BISON COURTYARD ON BEAR STREET</span><br />
            eat. drink. shop. explore. revitalize.
          </div>
      </div>
    </div>
    <div class="justify-center items-center grid grid-cols-2 lg:grid-cols-5 bg-theme-footer-tan gap-x-16 gap-y-0 pb-8 text-sm md:text-xl leading-relaxed text-center text-theme-brown font-[800] pt-16">
      <div class="lg:min-w-0"><?php dynamic_sidebar( 'footer-1' ); ?></div>
      <div class="lg:min-w-0"><?php dynamic_sidebar( 'footer-2' ); ?></div>
      <div class="hidden lg:flex lg:w-auto justify-center order-last lg:order-none min-w-[200px]"><img src="{{ Vite::asset('resources/images/logo-full-colour.svg') }}" class="w-[225px]" alt="{!! $siteName !!}"></div>
      <div class="lg:min-w-0"><?php dynamic_sidebar( 'footer-3' ); ?></div>
      <div class="lg:min-w-0"><?php dynamic_sidebar( 'footer-4' ); ?></div>
    </div>
    <div class="lg:hidden lg:w-auto bg-theme-footer-tan flex justify-center order-last lg:order-none pb-4"><img src="{{ Vite::asset('resources/images/logo-full-colour.svg') }}" class="w-[150px] md:w-[250px]" alt="{!! $siteName !!}"></div>
    <div class="text-center text-theme-brown p-4 bg-theme-footer-tan font-[800]">
      &copy; {{ date('Y') }} {{ $siteName }}.
    </div>
  </div>
</footer>

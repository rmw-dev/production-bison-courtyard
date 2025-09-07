
<section class="relative isolate block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }}">
  <div class="px-8 lg:px-32 grid md:grid-cols-2 text-xl lg:w-3/4 mx-auto gap-16">
    <div class="text-center md:text-left">
      <h2 class="text-4xl md:mt-32 mb-6 font-[800]">HOURS</h2>
      <div class="!leading-12 prose">{!! $store_hours !!}</div>
      <h2 class="text-4xl mt-12 mb-6 font-[800]">CONTACT DETAILS</h2>
      <div class="!leading-12 prose">{!! $store_contact_details !!}</div>
      <div class="!leading-12 prose flex justify-center md:justify-start gap-4 mt-6">
        @if($store_instagram_address)
          <a href="{{ $store_instagram_address }}" target="_blank">@svg('bi-instagram','w-8 h-8 text-theme-brown transition-color duration-300 hover:text-theme-orange')</a>
        @endif
        @if($store_facebook_address)
          <a href="{{ $store_facebook_address }}" target="_blank">@svg('bi-facebook','w-8 h-8 text-theme-brown transition-color duration-300 hover:text-theme-orange')</a>
        @endif
        @if($store_twitter_address)
          <a href="{{ $store_twitter_address }}"  target="_blank">@svg('bi-twitter','w-8 h-8 text-theme-brown transition-color duration-300 hover:text-theme-orange')</a>
        @endif
      </div>
    </div>
    <div class="order-first md:order-last md:block hidden">
       <div class="relative flex justify-center col-start-21 col-end-32 row-start-2 row-end-3 overflow-hidden">
          <div class="arch relative overflow-hidden rounded-t-[9999px] w-full">
            {!! wp_get_attachment_image( $store_image, 'full', false, [ 'class' => 'w-full object-cover aspect-2/3 zoom-hover' ] ) !!}
            <span class="pointer-events-none absolute inset-8 rounded-t-[9999px] border border-white border-3"></span>
          </div>
       </div>
    </div>
  </div>
  <div class="flex flex-col items-center gap-12 bg-theme-footer-light-tan px-8 lg:px-32 py-16 lg:py-24 my-16 lg:my-24 text-4xl text-center">
    Explore more stores at the Bison Courtyard
    <x-button href="/discover" variant="tertiary" class="ml-8">Store Directory</x-button-link>
  </div>
</section>

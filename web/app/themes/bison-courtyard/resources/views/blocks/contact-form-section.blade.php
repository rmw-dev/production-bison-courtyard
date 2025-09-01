{{-- resources/views/partials/contact-form-section.blade.php --}}
@php
  $endpoint  = rest_url('rmw/v1/contact');
  $restNonce = wp_create_nonce('wp_rest');
@endphp

<section class="relative isolate overflow-hidden block-hero-section {{ $layout['padding_class'] ?? '' }} {{ $layout['background_color'] ?? '' }} px-8 md:px-24">
  <div class="grid lg:grid-cols-2 gap-12 lg:gap-24">
    <div>
      @unless(empty($left_heading))
      <div class="col-span-2 text-5xl font-[800]">
        {{ $left_heading }}
      </div>
      @endunless
      
      @unless(empty($left_content))
      <div class="prose pt-8 flex flex-col ">
        {!! $left_content !!}
      </div>
      @endunless
      <x-google-map
        lat="51.17730601621462"
        lng="-115.57257007801668"
        
        zoom="17"
        icon="{{ Vite::asset('resources/images/pin.svg') }}"
        title="Bison Courtyard"
        address="211 Bear St, Banff, AB"
        mapStyle="bison"
        height="820px"
        class="rounded-xl overflow-hidden mt-10"
      />
    </div>
    <div class="prose">
      @unless(empty($right_heading))
      <div class="col-span-2 !text-5xl font-[800]">{{ $right_heading }}</div>
      @endunless
      @unless(empty($right_content))
      <div class="prose pt-8 flex flex-col ">
        {!! $right_content !!}
      </div>
      @endunless
      <form method="POST" action="/contact" data-endpoint="{{ $endpoint }}" data-nonce="{{ $restNonce }}" id="contact-form" class="mt-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-form-inputs.textbox label="First Name" name="first_name" />
            <x-form-inputs.textbox label="Last Name" name="last_name" />
            <x-form-inputs.textbox label="Contact Number" name="contact_number" />
            <x-form-inputs.textbox label="Email" name="email" type="email" />
            <div class="hidden">
              <label for="website">Website</label>
              <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
            </div>
        </div>

        <x-form-inputs.textarea label="Message" name="message" rows="6" />
        <x-button id="saveBtn" type="submit" class="mt-8">
          Send
        </x-button>
      </form>
      <div id="form-status" class="mt-3 text-sm"></div>
    </div>
  </div>
  
</section>

<form
  method="POST"
  action="/parking-inquiry"
  id="parking-inquiry-form"
  data-endpoint="{{ $endpoint }}"
  data-nonce="{{ $restNonce }}"
  class="mt-12"
>
  @csrf

  {{-- Auto-generate current date (hidden) --}}
  <input type="hidden" name="submission_date" value="{{ now()->toDateString() }}">

  <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
    <x-form-inputs.textbox label="First Name" name="first_name" />
    <x-form-inputs.textbox label="Last Name" name="last_name" />

    <x-form-inputs.textbox label="Email Address" name="email" type="email" />
    <x-form-inputs.textbox label="Phone Number" name="phone_number" type="tel" />
  </div>

  {{-- Honeypot --}}
  <div class="hidden">
    <label for="website">Website</label>
    <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
  </div>

  <x-button id="parkingSubmitBtn" type="submit" class="mt-8">
    Submit Inquiry
  </x-button>

  <div id="parking-inquiry-status" class="mt-3 text-sm"></div>
</form>

<form
  method="POST"
  action="/residential-leasing-inquiry"
  id="residential-leasing-form"
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

    <x-form-inputs.textbox label="Phone Number" name="phone_number" type="tel" />
    <x-form-inputs.textbox label="Email Address" name="email" type="email" />

    {{-- Unit Type Interested In --}}
    <x-form-inputs.select
      label="Unit Type Interested In"
      name="unit_type"
      :options="[
        'studio' => 'Studio / 1 Bedroom',
        '2br' => '2 Bedroom',
        '3br' => '3 Bedroom',
        'all' => 'All',
      ]"
      placeholder="Please choose..."
      class="md:col-span-2"
    />

  </div>

  {{-- Additional Comments or Questions --}}
  <x-form-inputs.textarea
    label="Additional Comments or Questions"
    name="comments"
    rows="6"
    class="mb-4"
    placeholder="Please provide any additional details or questions you may have."
  />

  {{-- Honeypot --}}
  <div class="hidden">
    <label for="website">Website</label>
    <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
  </div>

  <x-button id="resLeasingSubmitBtn" type="submit" class="mt-8">
    Submit Inquiry
  </x-button>

  <div id="residential-leasing-status" class="mt-3 text-sm"></div>
</form>

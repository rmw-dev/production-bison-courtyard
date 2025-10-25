<form method="POST" action="/contact" data-endpoint="{{ $endpoint }}" data-nonce="{{ $restNonce }}" id="contact-form" class="mt-12">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
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

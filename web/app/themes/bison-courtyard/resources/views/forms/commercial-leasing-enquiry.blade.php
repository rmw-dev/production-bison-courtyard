<form method="POST" action="/leasing-inquiry" data-endpoint="{{ $endpoint ?? '' }}" data-nonce="{{ $restNonce ?? '' }}" id="commercial-leasing-form" class="mt-12">
  @csrf

  {{-- Auto-generate current date (hidden) --}}
  <input type="hidden" name="submission_date" value="{{ now()->toDateString() }}">

  <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
    <x-form-inputs.textbox label="First Name" name="first_name" />
    <x-form-inputs.textbox label="Last Name" name="last_name"  />

    <x-form-inputs.textbox label="Phone Number" name="phone_number" type="tel" />
    <x-form-inputs.textbox label="Email Address" name="email" type="email" />

    <x-form-inputs.textbox label="Business Name" name="business_name" class="col-span-2" />
    {{-- Type of Business --}}
    <x-form-inputs.select
      label="Type of Business"
      name="business_type"
      :options="[
        'office' => 'Office',
        'retail' => 'Retail',
        'services' => 'Services',
        'food_beverage' => 'Food & Beverage',
        'health_wellness' => 'Health & Wellness',
        'recreation' => 'Recreation',
      ]"
      placeholder="Please choose..."
    />
      

    {{-- Preferred Unit Size --}}
    <x-form-inputs.select
      label="Preferred Unit Size"
      name="preferred_unit_size"
      :options="[
        'lt_500' => 'Less than 500 sq ft',
        '500_1000' => '500–1,000 sq ft',
        '1000_2000' => '1,000–2,000 sq ft',
        'gt_2000' => 'Over 2,000 sq ft',
      ]"
      placeholder="Please choose..."
    />

    {{-- Preferred Move-in Timeline --}}
    <x-form-inputs.select
      label="Preferred Move-in Timeline"
      name="move_in_timeline"
      :options="[
        'immediately' => 'Immediately',
        '1_3_months' => 'Within 1–3 Months',
        '3_6_months' => '3–6 Months',
        '6_plus_months' => '6+ Months',
      ]"
      placeholder="Please choose..."
      class="md:col-span-2"
    />
  </div>

  {{-- Additional Notes --}}
  <x-form-inputs.textarea label="Additional Notes or Questions" name="notes" rows="6" class="mb-4" />

  {{-- How did you hear from us --}}
  <x-form-inputs.select
    label="How did you hear about us?"
    name="referral_source"
    :options="[
      'website' => 'Website',
      'online_search' => 'Online Search (Google)',
      'online_ad' => 'Online Ad (Kijiji, Spacelist, etc.)',
      'social_media' => 'Social Media (Instagram, Facebook, LinkedIn)',
      'referral' => 'Referral (Friend, Agent, or Business Contact)',
      'other' => 'Other',
    ]"
    placeholder="Please choose..."
    class=""
  />

  {{-- Honeypot --}}
  <div class="hidden">
    <label for="website">Website</label>
    <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
  </div>

  <x-button id="leasingSubmitBtn" type="submit" class="mt-8">
    Submit Inquiry
  </x-button>

  <div id="leasing-form-status" class="mt-3 text-sm"></div>
</form>

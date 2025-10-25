function setError(el, msg) {
  if (!el) return;
  el.classList.add('ring-2', 'ring-red-600');
  el.setAttribute('aria-invalid', 'true');

  let help = el.parentElement?.querySelector('.field-error');
  if (!help) {
    help = document.createElement('p');
    help.className = 'field-error text-red-600 text-base mt-2';
    el.parentElement?.appendChild(help);
  }
  help.textContent = msg;
}

function clearError(el) {
  if (!el) return;
  el.classList.remove('ring-2', 'ring-red-600');
  el.removeAttribute('aria-invalid');
  const help = el.parentElement?.querySelector('.field-error');
  if (help) help.remove();
}

function value(form, name) {
  const el = form.querySelector(`[name="${name}"]`);
  return el ? el.value.trim() : '';
}

function validate(form) {
  let ok = true;

  // required fields for this form
  const required = [
    'first_name',
    'last_name',
    'email',
    'business_type',
    'preferred_unit_size',
    'move_in_timeline',
  ];

  // clear all previous errors
  form.querySelectorAll('input, textarea, select').forEach(clearError);

  // generic required check
  required.forEach((name) => {
    const el = form.querySelector(`[name="${name}"]`);
    if (!el || !value(form, name)) {
      setError(el, 'This field is required.');
      ok = false;
    }
  });

  // email format
  const emailEl = form.querySelector('[name="email"]');
  if (emailEl && value(form, 'email')) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!re.test(value(form, 'email'))) {
      setError(emailEl, 'Enter a valid email address.');
      ok = false;
    }
  }

  // phone optional, but sanity-check if provided
  const phoneEl = form.querySelector('[name="phone_number"]');
  if (phoneEl && value(form, 'phone_number')) {
    const digits = value(form, 'phone_number').replace(/[^\d+]/g, '');
    if (digits.length && digits.length < 7) {
      setError(phoneEl, 'Phone number looks too short.');
      ok = false;
    }
  }

  // honeypot must be empty
  const hp = form.querySelector('[name="website"]');
  if (hp && hp.value) ok = false;

  return ok;
}

async function submitLeasingForm(form, statusEl, btn) {
  const payload = {
    submission_date: value(form, 'submission_date') || new Date().toISOString().slice(0, 10),
    first_name: value(form, 'first_name'),
    last_name: value(form, 'last_name'),
    phone_number: value(form, 'phone_number'),
    email: value(form, 'email'),
    business_name: value(form, 'business_name'),
    business_type: value(form, 'business_type'),
    preferred_unit_size: value(form, 'preferred_unit_size'),
    move_in_timeline: value(form, 'move_in_timeline'),
    notes: value(form, 'notes'),
    referral_source: value(form, 'referral_source'),
    website: value(form, 'website'), // honeypot
  };

  const endpoint = form.dataset.endpoint || form.getAttribute('action') || '';
  const nonce = form.dataset.nonce || '';

  if (!endpoint) {
    statusEl.textContent = 'Error: Missing endpoint.';
    statusEl.classList.replace('text-gray-600', 'text-red-600');
    return;
  }

  try {
    btn?.setAttribute('disabled', 'true');
    statusEl.textContent = 'Sending...';
    statusEl.className = 'mt-3 text-xl text-gray-600';

    const res = await fetch(endpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        ...(nonce ? { 'X-WP-Nonce': nonce } : {}),
      },
      credentials: 'same-origin',
      body: JSON.stringify(payload),
    });

    const json = await res.json().catch(() => ({}));
    if (!res.ok || json?.success === false) {
      throw new Error(json?.message || `Submission failed (${res.status})`);
    }

    statusEl.textContent = 'Thanks — your inquiry has been sent.';
    statusEl.classList.replace('text-gray-600', 'text-green-700');
    form.reset();
  } catch (err) {
    statusEl.textContent = `Error: ${err.message}`;
    statusEl.classList.replace('text-gray-600', 'text-red-600');
  } finally {
    btn?.removeAttribute('disabled');
  }
}

// Attach once for this specific form
document.addEventListener('submit', (e) => {
  console.log('submit event triggered');
  const form = e.target.closest('#commercial-leasing-form');
  if (!form) return;

  e.preventDefault();

  const status = document.querySelector('#leasing-form-status') || form.querySelector('#leasing-form-status');
  const btn = form.querySelector('#leasingSubmitBtn') || form.querySelector('button[type="submit"], [type="submit"]');

  // reset UI
  form.querySelectorAll('input, textarea, select').forEach(clearError);
  if (status) {
    status.textContent = '';
    status.className = 'mt-3 text-xl text-gray-600';
  }

  if (!validate(form)) {
    if (status) {
      status.textContent = 'Please fix the highlighted fields.';
      status.classList.replace('text-gray-600', 'text-red-600');
    }
    return;
  }

  submitLeasingForm(form, status || document.createElement('div'), btn);
});


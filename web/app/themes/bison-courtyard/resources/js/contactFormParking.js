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

const getVal = (form, name) => (form.querySelector(`[name="${name}"]`)?.value || '').trim();

function validate(form) {
  let ok = true;

  form.querySelectorAll('input, textarea, select').forEach(clearError);

  const required = ['first_name', 'last_name', 'email'];
  required.forEach((name) => {
    const el = form.querySelector(`[name="${name}"]`);
    if (!el || !getVal(form, name)) {
      setError(el, 'This field is required.');
      ok = false;
    }
  });

  const emailEl = form.querySelector('[name="email"]');
  if (emailEl && getVal(form, 'email')) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!re.test(getVal(form, 'email'))) {
      setError(emailEl, 'Enter a valid email address.');
      ok = false;
    }
  }

  const phoneEl = form.querySelector('[name="phone_number"]');
  if (phoneEl && getVal(form, 'phone_number')) {
    const digits = getVal(form, 'phone_number').replace(/[^\d+]/g, '');
    if (digits.length && digits.length < 7) {
      setError(phoneEl, 'Phone number looks too short.');
      ok = false;
    }
  }

  const hp = form.querySelector('[name="website"]');
  if (hp && hp.value) ok = false;

  return ok;
}

async function submitForm(form, statusEl, btn) {
  const payload = {
    submission_date: getVal(form, 'submission_date') || new Date().toISOString().slice(0, 10),
    first_name: getVal(form, 'first_name'),
    last_name: getVal(form, 'last_name'),
    email: getVal(form, 'email'),
    phone_number: getVal(form, 'phone_number'),
    website: getVal(form, 'website'), // honeypot
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

document.addEventListener('submit', (e) => {
  const form = e.target.closest('#parking-inquiry-form');
  if (!form) return;

  e.preventDefault();

  const status = document.querySelector('#parking-inquiry-status') || form.querySelector('#parking-inquiry-status');
  const btn = form.querySelector('#parkingSubmitBtn') || form.querySelector('button[type="submit"], [type="submit"]');

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

  submitForm(form, status || document.createElement('div'), btn);
});

// resources/scripts/contact.js
function setError(el, msg) {
  el.classList.add('ring-2', 'ring-red-600');
  el.setAttribute('aria-invalid', 'true');
  let help = el.parentElement.querySelector('.field-error');
  if (!help) {
    help = document.createElement('p');
    help.className = 'field-error text-red-600 text-base mt-2';
    el.parentElement.appendChild(help);
  }
  help.textContent = msg;
}

function clearError(el) {
  el.classList.remove('ring-2', 'ring-red-600');
  el.removeAttribute('aria-invalid');
  const help = el.parentElement.querySelector('.field-error');
  if (help) help.remove();
}

function validate(form) {
  let ok = true;

  const must = ['first_name', 'last_name', 'email', 'message'];
  must.forEach((name) => {
    const el = form.querySelector(`[name="${name}"]`);
    clearError(el);
    if (!el || !el.value.trim()) {
      setError(el, 'This field is required.');
      ok = false;
    }
  });

  const emailEl = form.querySelector('[name="email"]');
  if (emailEl && emailEl.value) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!re.test(emailEl.value.trim())) {
      setError(emailEl, 'Enter a valid email address.');
      ok = false;
    }
  }

  const phoneEl = form.querySelector('[name="contact_number"]');
  if (phoneEl && phoneEl.value) {
    const val = phoneEl.value.replace(/[^\d+]/g, '');
    if (val.length && val.length < 7) {
      setError(phoneEl, 'Phone number looks too short.');
      ok = false;
    }
  }

  // honeypot must remain empty
  const hp = form.querySelector('[name="website"]');
  if (hp && hp.value) ok = false;

  return ok;
}

document.addEventListener('submit', async (e) => {
  const form = e.target.closest('#contact-form');
  if (!form) return;
  e.preventDefault();

  // UI
  const status = document.querySelector('#form-status');
  const btn = form.querySelector('button[type="submit"], [type="submit"]');

  // reset errors
  form.querySelectorAll('input, textarea').forEach(clearError);
  status.textContent = '';
  status.className = 'mt-3 text-xl text-gray-600';

  if (!validate(form)) {
    status.textContent = 'Please fix the highlighted fields.';
    status.classList.replace('text-gray-600', 'text-red-600');
    return;
  }

  const payload = {
    first_name: form.first_name.value.trim(),
    last_name: form.last_name.value.trim(),
    contact_number: form.contact_number.value.trim(),
    email: form.email.value.trim(),
    message: form.message.value.trim(),
    website: form.website.value.trim(), // honeypot
  };

  try {
    btn?.setAttribute('disabled', 'true');
    status.textContent = 'Sending...';

    const res = await fetch(form.dataset.endpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': form.dataset.nonce,
      },
      credentials: 'same-origin',
      body: JSON.stringify(payload),
    });

    const json = await res.json().catch(() => ({}));
    if (!res.ok || json?.success === false) {
      throw new Error(json?.message || `Submission failed (${res.status})`);
    }

    status.textContent = 'Thanks—your message has been sent.';
    status.classList.replace('text-gray-600', 'text-green-700');
    form.reset();
  } catch (err) {
    status.textContent = `Error: ${err.message}`;
    status.classList.replace('text-gray-600', 'text-red-600');
  } finally {
    btn?.removeAttribute('disabled');
  }
});


// Optional: simple IntersectionObserver to lazy-init maps in viewport
function onVisible(el, cb) {
  if (!('IntersectionObserver' in window)) return cb();
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        io.unobserve(el);
        cb();
      }
    });
  }, { rootMargin: '200px' });
  io.observe(el);
}



const PRESET_STYLES = {
  default: null,

  bison: [
    {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [
            {
                "lightness": 100
            },
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#C6E2FF"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#C5E3BF"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#D1D1B8"
            }
        ]
    }
]

  // keep your other presets here...
};



function parseStyle(el) {
  const raw = el.getAttribute('data-style-json');
  if (raw) {
    try { return JSON.parse(raw); } catch (_) {}
  }
  const preset = el.getAttribute('data-style') || 'default';
  return PRESET_STYLES[preset] ?? null;
}

function initMapEl(el) {
  const lat = parseFloat(el.getAttribute('data-lat'));
  const lng = parseFloat(el.getAttribute('data-lng'));
  const zoom = parseInt(el.getAttribute('data-zoom') || '15', 10);
  const icon = el.getAttribute('data-icon');
  const title = el.getAttribute('data-title') || '';
  const address = el.getAttribute('data-address') || '';
  const styles = parseStyle(el);

  const center = { lat, lng };

  const map = new google.maps.Map(el, {
    center,
    zoom,
    disableDefaultUI: false,
    mapTypeControl: false,
    streetViewControl: false,
    fullscreenControl: true,
    styles: styles || undefined,
  });

  const markerOpts = {
    position: center,
    map,
    title,
    optimized: true,
  };

  if (icon) {
    // Tweak size/anchor to match your icon
    markerOpts.icon = {
      url: icon,
      scaledSize: new google.maps.Size(40, 60), // adjust to your asset
      anchor: new google.maps.Point(20, 40),    // bottom-center
    };
  }

  const marker = new google.maps.Marker(markerOpts);

  if (address || title) {
    const iw = new google.maps.InfoWindow({
      content: `
        <div style="max-width:220px">
          ${title ? `<strong>${title}</strong><br>` : ''}
          ${address ? `<span>${address}</span>` : ''}
        </div>`,
    });
    marker.addListener('click', () => iw.open({ anchor: marker, map }));
  }

  // Keep center on resize (optional)
  google.maps.event.addDomListener(window, 'resize', () => {
    const c = map.getCenter();
    google.maps.event.trigger(map, 'resize');
    map.setCenter(c);
  });
}

function initAllMaps() {
  document.querySelectorAll('[data-gmap]').forEach((el) => {
    onVisible(el, () => initMapEl(el));
  });
}

// If API is already on page, run now; otherwise we’ll run from callback
if (window.google && window.google.maps) {
  initAllMaps();
}

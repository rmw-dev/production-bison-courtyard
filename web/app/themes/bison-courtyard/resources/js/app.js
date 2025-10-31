import.meta.glob([
  '../images/**',
  '../fonts/**',
]);
import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import intersect from '@alpinejs/intersect'

// Plugins (optional but handy)
Alpine.plugin(collapse)
Alpine.plugin(intersect)

// Avoid double-start during HMR
if (!window.Alpine) {
  window.Alpine = Alpine
  Alpine.start()
}

document.addEventListener("DOMContentLoaded", () => {
  const zoomImages = document.querySelectorAll(".zoom-hover");

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate-zoom");        
        obs.unobserve(entry.target); // run only once
      }
    });
  }, { threshold: 0.3 }); // 30% visible before triggering

  zoomImages.forEach(img => observer.observe(img));
});

document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".event-card");

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.parentElement.querySelectorAll('.event-card').forEach(card => card.classList.add("animate-in-up"));
        
        obs.unobserve(entry.target); // run only once
      }
    });
  }, { threshold: 0.5 }); // 30% visible before triggering

  cards.forEach(card => observer.observe(card));
});

document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".store-card");

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.parentElement.querySelectorAll('.store-card').forEach(card => card.classList.add("animate-in-up"));
        
        obs.unobserve(entry.target); // run only once
      }
    });
  }, { threshold: 0.5 }); // 30% visible before triggering

  cards.forEach(card => observer.observe(card));
});

document.addEventListener("DOMContentLoaded", () => {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("animate-in");
          obs.unobserve(entry.target); // run only once
        }
      });
    }, { threshold: 0.5 });

    document.querySelectorAll(".zoom-image, .zoom-text")
      .forEach(el => observer.observe(el));
  });

document.addEventListener("DOMContentLoaded", () => {

  
  const footer = document.querySelector("footer");

  const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.querySelector('#mountains').style.transform = 'translateY(0)';
          entry.target.querySelector('#mountains').style.opacity = '1';
          entry.target.querySelector('#trees').style.transform = 'translateY(0)';
          entry.target.querySelector('#footer-heading').style.transform = 'translateY(0)';
          entry.target.querySelector('#footer-heading').style.opacity = '1';
          obs.unobserve(entry.target); // run only once
        }
      });
    }, { threshold: 0.4 });

    
    observer.observe(footer);

});


document.addEventListener("DOMContentLoaded", () => {
  const sections = Array.from(document.querySelectorAll(".bison-print-bg"));
  const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("animate");
          obs.unobserve(entry.target); // run only once
        }
      });
    }, { threshold: 0.4 });

    sections.forEach(section => observer.observe(section));    

});

document.addEventListener("DOMContentLoaded", () => {
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
});


document.addEventListener("DOMContentLoaded", () => {
  const calendlyButtons = document.querySelectorAll("[href*='#open-calendly']");
  calendlyButtons.forEach(button => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      Calendly.initPopupWidget({url: 'https://calendly.com/administration-arctosbanff'});
      return false;
    });
  });
});

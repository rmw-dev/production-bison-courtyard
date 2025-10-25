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

console.log('App JS loaded');

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
  console.log(sections)
  const observer = new IntersectionObserver((entries, obs) => {
    console.log(entries)
      entries.forEach(entry => {
        console.log('before if')
        if (entry.isIntersecting) {
          entry.target.classList.add("animate");
          obs.unobserve(entry.target); // run only once
        }
      });
    }, { threshold: 0.4 });

    sections.forEach(section => observer.observe(section));    

});

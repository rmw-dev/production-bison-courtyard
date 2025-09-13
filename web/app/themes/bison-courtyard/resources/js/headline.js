document.addEventListener("DOMContentLoaded", function() {
    resizeHeadline();
    
    const headline = document.getElementById('headline');
    headline.style.transition = 'opacity 1s ease-in-out';
    headline.classList.remove('opacity-0');
    headline.classList.remove('translate-y-30');
    window.addEventListener("resize", resizeHeadline);
});

const resizeHeadline = () => {
    const headline = document.getElementById('headline');
    const headlineHeight = headline.offsetHeight;
    headline.style.bottom = `-${headlineHeight * 0.24}px`; // Adjust the value as needed
};

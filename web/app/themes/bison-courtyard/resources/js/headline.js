document.addEventListener("DOMContentLoaded", function() {
    resizeHeadline();
    window.addEventListener("resize", resizeHeadline);
});

const resizeHeadline = () => {
    const headline = document.getElementById('headline');
    const headlineHeight = headline.offsetHeight;
    headline.style.bottom = `-${headlineHeight * 0.24}px`; // Adjust the value as needed
};

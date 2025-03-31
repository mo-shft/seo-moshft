document.addEventListener('DOMContentLoaded', function() {
    let sliders = document.querySelectorAll('.slider');
    sliders.forEach(slider => {
        let slides = slider.querySelectorAll('.slide');
        let slideIndex = 0;
        const showSlides = () => {
            slides.forEach((slide, index) => {
                slide.style.display = (index === slideIndex) ? 'block' : 'none';
            });
            slideIndex = (slideIndex + 1) % slides.length;
            setTimeout(showSlides, 3000); // تغيير الصورة تلقائيًا كل 3 ثوان
        };
        showSlides();
    });
});
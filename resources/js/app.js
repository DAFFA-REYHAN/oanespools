// resources/js/app.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;

// Import components
import {
    popupCards,
    gallerySlider,
    artikelSlider,
    modal
} from './components';

// Fancybox
import {
    Fancybox
} from '@fancyapps/ui';
import '@fancyapps/ui/dist/fancybox/fancybox.css';

// Swiper
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

document.addEventListener('DOMContentLoaded', () => {
    // Fancybox untuk Gambar
    Fancybox.bind("[data-fancybox='images']", {
        Thumbs: {
            autoStart: false
        },
        Toolbar: {
            display: ['close', 'counter', 'zoom', 'slideshow', 'fullscreen', 'download']
        },
        Image: {
            zoom: true,
        },
        Carousel: {
            infinite: true,
        }
    });

    // Fancybox untuk Video
    Fancybox.bind("[data-fancybox='videos']", {
        Thumbs: {
            autoStart: true
        },
        Toolbar: {
            display: ['close', 'counter', 'zoom', 'slideshow', 'fullscreen']
        },
        Carousel: {
            infinite: true,
            Video: {
                autoplay: false,
            },
        },
    });

    // Swiper initialization
    const swiper1 = new Swiper(".mySwiper", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        loop: true,
        effect: 'slide',
        speed: 1000,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 1,
                spaceBetween: 30,
            },
        },
    });

    // Handle page visibility change for autoplay
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            swiper1.autoplay.start();
        } else {
            swiper1.autoplay.stop();
        }
    });
});

// Make components globally available
window.popupCards = popupCards;
window.gallerySlider = gallerySlider;
window.artikelSlider = artikelSlider;
window.modal = modal;

// Start Alpine
Alpine.start();
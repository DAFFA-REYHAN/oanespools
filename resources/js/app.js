import Alpine from 'alpinejs';
window.Alpine = Alpine;

import {
    popupCards,
    gallerySlider
} from './components';

// Fancybox
import {
    Fancybox
} from '@fancyapps/ui';
import '@fancyapps/ui/dist/fancybox/fancybox.css';
import '@fancyapps/ui/dist/fancybox/fancybox.esm.js';
import '@fancyapps/ui/dist/fancybox/fancybox.umd.js';

// Swiper
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

document.addEventListener('DOMContentLoaded', () => {
    // Fancybox untuk Gambar
    Fancybox.bind("[data-fancybox='images']", {
       
        
    });

    // Fancybox untuk Video
    Fancybox.bind("[data-fancybox='videos']", {
        Thumbs: {
            autoStart: true // Menampilkan thumbnail
        },
        Toolbar: {
            display: ['close', 'counter', 'zoom', 'slideshow', 'fullscreen']
        },
        Carousel: {
            Video: {
                autoplay: false,
            },
        },
    });


    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },

    });

});

window.popupCards = popupCards;
window.gallerySlider = gallerySlider;

Alpine.start();

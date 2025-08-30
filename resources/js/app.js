import Alpine from 'alpinejs';
window.Alpine = Alpine;

// Import Fancybox
import {Fancybox} from '@fancyapps/ui';
import '@fancyapps/ui/dist/fancybox/fancybox.css';

// Import Swiper
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

// Component: Popup Cards
const popupCards = (initialCards = []) => ({
    cards: initialCards,
    showModal: false,
    selectedCard: {},

    openModal(card) {
        this.selectedCard = card;
        this.showModal = true;
        document.body.style.overflow = 'hidden';
    },

    closeModal() {
        this.showModal = false;
        this.selectedCard = {};
        document.body.style.overflow = 'auto';
    }
});

// Component: Gallery Slider
const gallerySlider = (images = []) => ({
    images: images,
    currentSet: 0,
    imageGroups: [],
    intervalId: null,

    init() {
        this.setupGroups();
        this.startSlide();
    },

    setupGroups() {
        const groupSize = window.innerWidth >= 768 ? 4 : 2;
        this.imageGroups = [];
        for (let i = 0; i < this.images.length; i += groupSize) {
            this.imageGroups.push(this.images.slice(i, i + groupSize));
        }
    },

    startSlide() {
        if (this.imageGroups.length <= 1) return;

        this.intervalId = setInterval(() => {
            this.currentSet = (this.currentSet + 1) % this.imageGroups.length;
        }, 3000);
    },

    destroy() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
        }
    }
});

// Component: Artikel Slider
const artikelSlider = (articles = []) => ({
    articles: articles,
    currentSlide: 0,
    showModal: false,
    selectedArtikel: null,
    autoPlayInterval: null,

    init() {
        this.startAutoPlay();
        window.addEventListener('resize', () => {
            this.currentSlide = 0;
        });
    },

    itemsPerView() {
        if (window.innerWidth >= 1024) return 3;
        if (window.innerWidth >= 768) return 2;
        return 1;
    },

    maxSlide() {
        return Math.max(0, this.articles.length - this.itemsPerView());
    },

    shouldShowNavigation() {
        return this.articles.length > this.itemsPerView();
    },

    nextSlide() {
        if (this.currentSlide < this.maxSlide()) {
            this.currentSlide++;
        } else {
            this.currentSlide = 0;
        }
    },

    prevSlide() {
        if (this.currentSlide > 0) {
            this.currentSlide--;
        }
    },

    startAutoPlay() {
        this.autoPlayInterval = setInterval(() => {
            this.nextSlide();
        }, 5000);
    },

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
        }
    },

    openModal(artikel) {
        this.selectedArtikel = artikel;
        this.showModal = true;
        document.body.style.overflow = 'hidden';
    },

    closeModal() {
        this.showModal = false;
        this.selectedArtikel = null;
        document.body.style.overflow = 'auto';
    },

    getExcerpt(content, length = 120) {
        const text = content.replace(/<[^>]*>/g, '');
        return text.length > length ? text.substring(0, length) + '...' : text;
    },

    formatDate(dateString) {
        const date = new Date(dateString);
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    },

    formatDateLong(dateString) {
        const date = new Date(dateString);
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    },

    shareArticle() {
        if (navigator.share && this.selectedArtikel) {
            navigator.share({
                title: this.selectedArtikel.title,
                text: this.getExcerpt(this.selectedArtikel.content, 100),
                url: window.location.href
            });
        }
    }
});

// Component: Modal
const modal = () => ({
    isOpen: false,

    open() {
        this.isOpen = true;
        document.body.style.overflow = 'hidden';
    },

    close() {
        this.isOpen = false;
        document.body.style.overflow = 'auto';
    }
});

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize Fancybox for Images
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

    // Initialize Fancybox for Videos with better performance
    Fancybox.bind("[data-fancybox='videos']", {
        Thumbs: {
            autoStart: false
        },
        Toolbar: {
            display: ['close', 'counter', 'fullscreen']
        },
        Carousel: {
            infinite: true,
        },
        Html: {
            video: {
                autoplay: false,
                ratio: 16 / 9
            }
        },
        on: {
            init: (fancybox) => {
                // Pause all videos that are playing
                const videos = document.querySelectorAll('video');
                videos.forEach(v => {
                    if (!v.paused) {
                        v.pause();
                    }
                });
            }
        }
    });

    // Initialize Video Slider dengan optimasi
    const videoSwiper = new Swiper(".video-swiper", {
        spaceBetween: 30,
        centeredSlides: true,
        loop: false, // Disable loop untuk video performance
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        speed: 600,
        navigation: {
            nextEl: ".video-button-next",
            prevEl: ".video-button-prev"
        },
        pagination: {
            el: ".video-pagination",
            clickable: true,
            dynamicBullets: true
        },
        on: {
            slideChange: function () {
                // Pause all videos when changing slide
                const videos = this.el.querySelectorAll('video');
                videos.forEach(v => v.pause());
            }
        }
    });

    // Initialize regular image slider
    const imageSwiper = new Swiper(".mySwiper", {
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

    // Handle page visibility change for performance
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            if (imageSwiper.autoplay) {
                imageSwiper.autoplay.start();
            }
        } else {
            if (imageSwiper.autoplay) {
                imageSwiper.autoplay.stop();
            }
            // Pause all videos
            document.querySelectorAll('video').forEach(v => v.pause());
        }
    });

    // Lazy load videos
    const lazyVideos = document.querySelectorAll('video[data-src]');
    if ('IntersectionObserver' in window) {
        const videoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const video = entry.target;
                    if (video.dataset.src) {
                        video.src = video.dataset.src;
                        video.removeAttribute('data-src');
                        video.load();
                    }
                    videoObserver.unobserve(video);
                }
            });
        }, {
            rootMargin: '100px'
        });

        lazyVideos.forEach(video => videoObserver.observe(video));
    }
});

// Make components globally available
window.popupCards = popupCards;
window.gallerySlider = gallerySlider;
window.artikelSlider = artikelSlider;
window.modal = modal;

// Start Alpine
Alpine.start();
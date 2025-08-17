// resources/js/alpine/components.js

/**
 * Galeri slider
 * @param {Array<{src:string, alt:string}>} images
 */
export function gallerySlider(allImages) {
    // Bikin grup 4 gambar per slide
    const groups = [];
    for (let i = 0; i < allImages.length; i += 4) {
        groups.push(allImages.slice(i, i + 4));
    }

    return {
        imageGroups: groups,
        currentSet: 0,
        showModal: false,
        selectedImage: "",
        startSlide() {
            setInterval(() => {
                this.currentSet = (this.currentSet + 1) % this.imageGroups.length;
            }, 5000);
        },
        openImage(src) {
            this.selectedImage = src;
            this.showModal = true;
        },
        closeImage() {
            this.showModal = false;
            this.selectedImage = "";
        },
    };
}

/**
 * Popup cards layanan
 * @param {Array<{title:string, subtitle:string, image:string, description:string}>} cards
 */
export function popupCards(cards = []) {
    return {
        showModal: false,
        selectedCard: {},
        cards,

        openModal(card) {
            this.selectedCard = card;
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
        },
    };
}

// Simplified and more reliable artikelSlider component
export function artikelSlider(artikels) {
    return {
        // State
        currentSlide: 0,
        artikels: artikels || [],
        showModal: false,
        selectedArtikel: null,
        autoPlay: true,
        autoPlayInterval: null,
        windowWidth: window.innerWidth,

        // Initialize component
        init() {
            this.updateWindowWidth();
            this.startAutoPlay();
            this.setupEventListeners();
        },

        // Update window width reactively
        updateWindowWidth() {
            this.windowWidth = window.innerWidth;
        },

        // Responsive items per view
        itemsPerView() {
            if (this.windowWidth >= 1024) return 3; // lg: 3 items
            if (this.windowWidth >= 768) return 2; // md: 2 items  
            return 1; // mobile: 1 item
        },

        // Calculate maximum slide index
        maxSlide() {
            const total = this.artikels.length;
            const perView = this.itemsPerView();
            return Math.max(0, total - perView);
        },

        // Navigation methods
        nextSlide() {
            if (this.artikels.length <= this.itemsPerView()) return;

            this.currentSlide = this.currentSlide >= this.maxSlide() ?
                0 :
                this.currentSlide + 1;
        },

        prevSlide() {
            if (this.artikels.length <= this.itemsPerView()) return;

            this.currentSlide = this.currentSlide <= 0 ?
                this.maxSlide() :
                this.currentSlide - 1;
        },

        goToSlide(index) {
            this.currentSlide = Math.min(Math.max(0, index), this.maxSlide());
        },

        // Auto-play functionality
        startAutoPlay() {
            this.stopAutoPlay();

            if (this.autoPlay && this.shouldShowNavigation()) {
                this.autoPlayInterval = setInterval(() => {
                    this.nextSlide();
                }, 4000);
            }
        },

        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        },

        // Check if navigation should be visible
        shouldShowNavigation() {
            return this.artikels.length > this.itemsPerView();
        },

        // Modal methods
        openModal(artikel) {
            this.selectedArtikel = artikel;
            this.showModal = true;
            document.body.style.overflow = "hidden";
            this.stopAutoPlay();
        },

        closeModal() {
            this.showModal = false;
            this.selectedArtikel = null;
            document.body.style.overflow = "auto";
            this.startAutoPlay();
        },

        // Share functionality
        shareArticle() {
            if (!this.selectedArtikel) return;

            const shareData = {
                title: this.selectedArtikel.title,
                text: this.getExcerpt(this.selectedArtikel.content, 100),
                url: window.location.href
            };

            if (navigator.share) {
                navigator.share(shareData).catch(console.error);
            } else {
                // Fallback: copy to clipboard
                const textToCopy = `${shareData.title}\n${shareData.url}`;

                if (navigator.clipboard) {
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        alert('Link artikel berhasil disalin!');
                    }).catch(() => {
                        alert('Gagal menyalin link artikel.');
                    });
                } else {
                    alert('Fitur share tidak didukung di browser ini.');
                }
            }
        },

        // Utility methods
        stripHtml(html) {
            if (!html) return '';
            const div = document.createElement('div');
            div.innerHTML = html;
            return div.textContent || div.innerText || '';
        },

        getExcerpt(content, limit = 150) {
            const plainText = this.stripHtml(content);
            return plainText.length > limit ?
                plainText.substring(0, limit) + '...' :
                plainText;
        },

        formatDate(dateString) {
            if (!dateString) return '';
            try {
                return new Date(dateString).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            } catch (e) {
                return dateString;
            }
        },

        formatDateLong(dateString) {
            if (!dateString) return '';
            try {
                return new Date(dateString).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            } catch (e) {
                return dateString;
            }
        },

        // Setup event listeners
        setupEventListeners() {
            // Resize listener with debounce
            let resizeTimeout;
            const handleResize = () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    this.updateWindowWidth();

                    // Adjust current slide if needed
                    const newMaxSlide = this.maxSlide();
                    if (this.currentSlide > newMaxSlide) {
                        this.currentSlide = newMaxSlide;
                    }

                    // Restart autoplay
                    if (!this.showModal) {
                        this.startAutoPlay();
                    }
                }, 150);
            };

            window.addEventListener('resize', handleResize);

            // Keyboard navigation
            const handleKeydown = (e) => {
                if (this.showModal) {
                    if (e.key === 'Escape') {
                        this.closeModal();
                    }
                } else {
                    if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        this.prevSlide();
                    } else if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        this.nextSlide();
                    }
                }
            };

            document.addEventListener('keydown', handleKeydown);

            // Store handlers for cleanup
            this._resizeHandler = handleResize;
            this._keydownHandler = handleKeydown;
        },

        // Cleanup
        destroy() {
            this.stopAutoPlay();

            if (this._resizeHandler) {
                window.removeEventListener('resize', this._resizeHandler);
            }

            if (this._keydownHandler) {
                document.removeEventListener('keydown', this._keydownHandler);
            }
        }
    }
}

/**
 * Reusable Modal Component
 */
export function modal() {
    return {
        // State
        isOpen: false,
        title: '',
        content: '',

        // Initialize
        init() {
            // Listen for escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isOpen) {
                    this.close();
                }
            });
        },

        // Methods
        open(title = '', content = '') {
            this.title = title;
            this.content = content;
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },

        close() {
            this.isOpen = false;
            document.body.style.overflow = 'auto';
            this.title = '';
            this.content = '';
        },

        // Click outside to close
        handleBackdropClick(event) {
            if (event.target === event.currentTarget) {
                this.close();
            }
        }
    }
}
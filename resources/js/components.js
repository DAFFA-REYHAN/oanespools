// resources/js/alpine/components.js

/**
 * Galeri slider
 * @param {Array<{src:string, alt:string}>} images
 */
export function gallerySlider(allImages) {
    // Bikin grup 4 gambar per slide
    console.log(allImages);
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

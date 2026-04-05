/**
 * This will track all the images and fonts for publishing.
 */
import.meta.glob(["../images/**", "../fonts/**"]);

/**
 * Main vue bundler.
 */
import { createApp } from "vue/dist/vue.esm-bundler";
import Swiper from "swiper";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

/**
 * Main root application registry.
 */
window.app = createApp({
    data() {
        return {};
    },

    mounted() {
        this.lazyImages();
        this.initBeanspaSliders();
        this.initBeanspaPolicySliders();
        this.initAboutSectionMotion();
        this.initScrollReveal();
    },

    methods: {
        onSubmit() {},

        onInvalidSubmit({ values, errors, results }) {
            setTimeout(() => {
                const errorKeys = Object.entries(errors)
                    .map(([key, value]) => ({ key, value }))
                    .filter(error => error["value"].length);

                if (errorKeys.length > 0) {
                    const errorKey = errorKeys[0]["key"];

                    let scrollTarget = null;
                    
                    // Try to find the input element with the exact name first.
                    let firstErrorElement = document.querySelector('[name="' + errorKey + '"]');
                    
                    // If not found and the key doesn't end with [], try with the [] suffix (for array fields).
                    if (
                        ! firstErrorElement 
                        && ! errorKey.endsWith('[]')
                    ) {
                        firstErrorElement = document.querySelector('[name="' + errorKey + '[]"]');
                    }
                    
                    // If still not found, try to find any element that starts with this name (for nested fields).
                    if (! firstErrorElement) {
                        firstErrorElement = document.querySelector('[name^="' + errorKey + '"]');
                    }

                    // If we found the input element.
                    if (firstErrorElement) {
                        scrollTarget = firstErrorElement;
                        
                        // Check if this is a TinyMCE textarea (hidden by TinyMCE).
                        if (firstErrorElement.tagName === 'TEXTAREA' && firstErrorElement.style.display === 'none') {
                            // Find the TinyMCE editor container.
                            const editorId = firstErrorElement.id;

                            const tinyMCEContainer = document.querySelector('#' + editorId + '_parent');
                            
                            if (tinyMCEContainer) {
                                scrollTarget = tinyMCEContainer;
                            }
                        }
                    } else {
                        // If the input is not found, try to find the error message element itself.
                        // VeeValidate renders error messages with a v-error-message component having a name attribute.
                        const errorMessageElement = document.querySelector('[name="' + errorKey + '"] p, [name="' + errorKey + '[]"] p');
                        
                        if (errorMessageElement) {
                            // Scroll to the parent container of the error message.
                            scrollTarget = errorMessageElement.closest('.border') || errorMessageElement.closest('div[class*="bg-white"]') || errorMessageElement;
                        }
                    }

                    if (scrollTarget) {
                        scrollTarget.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });
                        
                        // Try to focus the element: for TinyMCE, focus the editor; for regular inputs, focus the input.
                        if (firstErrorElement) {
                            if (firstErrorElement.tagName === 'TEXTAREA' && firstErrorElement.style.display === 'none') {
                                // Focus the TinyMCE editor if available.
                                const editorId = firstErrorElement.id;

                                if (window.tinymce && tinymce.get(editorId)) {
                                    tinymce.get(editorId).focus();
                                }
                            } else if (firstErrorElement.focus) {
                                firstErrorElement.focus();
                            }
                        }
                    } else {
                        // If the scroll target is not found, show a flash message with all errors.
                        const allErrors = errorKeys
                            .map(error => {
                                if (Array.isArray(error.value)) {
                                    return error.value.join(', ');
                                }

                                return error.value;
                            })
                            .filter(msg => msg).join(' ');
                        
                        this.$emitter.emit('add-flash', { 
                            type: 'error', 
                            message: allErrors 
                        });
                    }
                }
            }, 100);
        },

        lazyImages() {
            var lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));

            let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        let lazyImage = entry.target;

                        lazyImage.src = lazyImage.dataset.src;

                        lazyImage.classList.remove('lazy');

                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });

            lazyImages.forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        },

        initBeanspaSliders() {
            document.querySelectorAll('.beanspa-swiper').forEach((slider) => {
                if (slider.swiper) {
                    return;
                }

                new Swiper(slider, {
                    modules: [Navigation, Pagination, Autoplay],
                    loop: true,
                    speed: 700,
                    autoplay: {
                        delay: 5500,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        prevEl: slider.querySelector('[data-swiper-prev]'),
                        nextEl: slider.querySelector('[data-swiper-next]'),
                    },
                    pagination: {
                        el: slider.querySelector('[data-swiper-pagination]'),
                        clickable: true,
                    },
                });
            });
        },

        initBeanspaPolicySliders() {
            document.querySelectorAll('.policy-swiper, .beanspa-policy-swiper').forEach((slider) => {
                if (slider.swiper) {
                    return;
                }

                new Swiper(slider, {
                    speed: 1000,
                    slidesPerView: 3,
                    spaceBetween: 20,
                    grabCursor: true,
                    breakpoints: {
                        300: {
                            slidesPerView: 1.2,
                            spaceBetween: 14,
                        },
                        500: {
                            slidesPerView: 1.3,
                            spaceBetween: 14,
                        },
                        767: {
                            slidesPerView: 1.4,
                            spaceBetween: 20,
                        },
                        992: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                        1199: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                    },
                });
            });
        },

        initAboutSectionMotion() {
            const aboutBlocks = document.querySelectorAll('.beanspa-about-motion');

            if (! aboutBlocks.length) {
                return;
            }

            const observer = new IntersectionObserver((entries, revealObserver) => {
                entries.forEach((entry) => {
                    if (! entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                });
            }, {
                threshold: 0.3,
            });

            aboutBlocks.forEach((item) => observer.observe(item));
        },

        initScrollReveal() {
            const revealItems = document.querySelectorAll('.beanspa-reveal-left');

            if (! revealItems.length) {
                return;
            }

            const observer = new IntersectionObserver((entries, revealObserver) => {
                entries.forEach((entry) => {
                    if (! entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                });
            }, {
                threshold: 0.2,
            });

            revealItems.forEach((item) => observer.observe(item));
        },
    },
});

/**
 * Global plugins registration.
 */
import Axios from "./plugins/axios";
import Emitter from "./plugins/emitter";
import Shop from "./plugins/shop";
import VeeValidate from "./plugins/vee-validate";
import Flatpickr from "./plugins/flatpickr";

[
    Axios,
    Emitter,
    Shop,
    VeeValidate,
    Flatpickr,
].forEach((plugin) => app.use(plugin));

/**
 * Global directives.
 */
import Debounce from "./directives/debounce";

app.directive("debounce", Debounce);

export default app;

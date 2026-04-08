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
import { initBeanspaBeforeAfterSample } from "./beanspa-before-after-sample";

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
        this.initBeanspaServiceSliders();
        this.initBeanspaFeedbackSlider();
        this.initThongKeCounters();
        this.initAboutSectionMotion();
        this.initScrollReveal();
        initBeanspaBeforeAfterSample();
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

        initBeanspaServiceSliders() {
            const mobileMediaQuery = window.matchMedia('(max-width: 767px)');

            document.querySelectorAll('.beanspa-services-swiper').forEach((slider) => {
                if (slider.dataset.serviceSliderReady === 'true') {
                    return;
                }

                slider.dataset.serviceSliderReady = 'true';

                const section = slider.closest('[data-service-section], .section_services_v2');
                const wrapper = slider.querySelector('.swiper-wrapper');
                const pagination = slider.querySelector('[data-service-pagination], .services-tabs__dots');

                if (! wrapper || ! pagination) {
                    return;
                }

                const originalSlides = Array.from(wrapper.children).map((slide) => slide.cloneNode(true));
                let dots = [];
                let swiper = null;
                let currentMode = null;

                const triggerSectionReveal = () => {
                    if (! section || ! section.classList.contains('is-inview')) {
                        return;
                    }

                    section.classList.remove('is-inview');

                    window.requestAnimationFrame(() => {
                        section.classList.add('is-inview');
                    });
                };

                const syncDots = (activeIndex) => {
                    dots.forEach((dot, index) => {
                        const isActive = index === activeIndex;

                        dot.classList.toggle('is-active', isActive);
                        dot.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                    });

                    triggerSectionReveal();
                };

                const renderDots = (count) => {
                    pagination.innerHTML = '';

                    for (let index = 0; index < count; index += 1) {
                        const dot = document.createElement('button');

                        dot.type = 'button';
                        dot.className = 'services-tabs__dot';
                        dot.dataset.serviceDot = index;
                        dot.setAttribute('aria-label', 'Service slide ' + (index + 1));
                        dot.setAttribute('aria-pressed', 'false');
                        pagination.appendChild(dot);
                    }

                    dots = Array.from(pagination.querySelectorAll('.services-tabs__dot'));
                };

                const buildSlides = (isMobile) => {
                    wrapper.innerHTML = '';

                    if (isMobile) {
                        originalSlides.forEach((slide) => {
                            Array.from(slide.querySelectorAll('.service-card')).forEach((card) => {
                                const mobileSlide = document.createElement('div');
                                const mobileGrid = document.createElement('div');

                                mobileSlide.className = 'swiper-slide services-tab-slide services-tab-slide--mobile';
                                mobileGrid.className = 'services-cards-grid services-cards-grid--mobile';
                                mobileGrid.appendChild(card.cloneNode(true));
                                mobileSlide.appendChild(mobileGrid);
                                wrapper.appendChild(mobileSlide);
                            });
                        });

                        slider.classList.add('is-mobile-cards');
                    } else {
                        originalSlides.forEach((slide) => {
                            wrapper.appendChild(slide.cloneNode(true));
                        });

                        slider.classList.remove('is-mobile-cards');
                    }
                };

                const createSwiper = () => {
                    swiper = new Swiper(slider, {
                        speed: 700,
                        slidesPerView: 1,
                        spaceBetween: 0,
                        grabCursor: true,
                        allowTouchMove: true,
                        autoHeight: true,
                        preventClicks: false,
                        preventClicksPropagation: false,
                        touchStartPreventDefault: false,
                        on: {
                            init(instance) {
                                syncDots(instance.activeIndex);
                            },
                            slideChange(instance) {
                                syncDots(instance.activeIndex);
                            },
                        },
                    });
                };

                const rebuildSlider = () => {
                    const nextMode = mobileMediaQuery.matches ? 'mobile' : 'desktop';

                    if (currentMode === nextMode) {
                        return;
                    }

                    currentMode = nextMode;

                    if (swiper) {
                        swiper.destroy(true, true);
                        swiper = null;
                    }

                    buildSlides(nextMode === 'mobile');
                    renderDots(wrapper.children.length);
                    createSwiper();
                };

                pagination.addEventListener('click', (event) => {
                    const dot = event.target.closest('.services-tabs__dot');

                    if (! dot || ! swiper) {
                        return;
                    }

                    event.preventDefault();
                    event.stopPropagation();

                    const dotIndex = dots.indexOf(dot);
                    const dataIndex = Number.parseInt(dot.dataset.serviceDot, 10);
                    const targetIndex = Number.isNaN(dataIndex) ? dotIndex : dataIndex;

                    if (targetIndex >= 0) {
                        swiper.slideTo(targetIndex);
                    }
                });

                rebuildSlider();
                mobileMediaQuery.addEventListener('change', rebuildSlider);
            });
        },

        initBeanspaFeedbackSlider() {
            const el = document.querySelector('.swiper_feedback');

            if (! el || el.dataset.feedbackReady === 'true') {
                return;
            }

            el.dataset.feedbackReady = 'true';

            new Swiper(el, {
                modules: [Pagination],
                slidesPerView: 1,
                spaceBetween: 12,
                grabCursor: true,
                loop: true,
                pagination: {
                    el: el.querySelector('.swiper-pagination'),
                    clickable: true,
                },
                breakpoints: {
                    600: {
                        slidesPerView: 2,
                        spaceBetween: 12,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 12,
                    },
                },
            });
        },

        initThongKeCounters() {
            const items = document.querySelectorAll('.thongke-counter');

            if (! items.length) {
                return;
            }

            const animateCounter = (element) => {
                const target = Number.parseInt(element.dataset.target, 10);

                if (Number.isNaN(target)) {
                    return;
                }

                const duration = 1400;
                const start = performance.now();

                const step = (now) => {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    const value = Math.round(target * eased);

                    element.textContent = String(value);

                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };

                window.requestAnimationFrame(step);
            };

            const observer = new IntersectionObserver((entries, currentObserver) => {
                entries.forEach((entry) => {
                    if (! entry.isIntersecting) {
                        return;
                    }

                    animateCounter(entry.target);
                    currentObserver.unobserve(entry.target);
                });
            }, {
                threshold: 0.35,
            });

            items.forEach((item) => {
                observer.observe(item);
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

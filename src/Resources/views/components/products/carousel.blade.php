<v-products-carousel
    src="{{ $src }}"
    title="{{ $title }}"
    navigation-link="{{ $navigationLink ?? '' }}"
>
    <x-shop::shimmer.products.carousel :navigation-link="$navigationLink ?? false" />
</v-products-carousel>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-products-carousel-template"
    >
        <section
            class="section-index beanspa-products-carousel-section"
            v-if="! isLoading && products.length"
        >
        <div
            class="container beanspa-products-carousel mt-16 max-lg:px-8 max-md:mt-8 max-sm:mt-7 max-sm:!px-4"
        >
            <div class="beanspa-products-carousel__head flex items-end justify-between gap-6">
                <h2 class="text-3xl max-md:text-2xl max-sm:text-xl">
                    @{{ title }}
                </h2>

                <div class="flex items-center justify-between gap-8">
                    <a
                        :href="navigationLink"
                        class="beanspa-products-carousel__viewall-link hidden max-lg:flex"
                        v-if="navigationLink"
                    >
                        <p class="items-center text-xl max-md:text-base max-sm:text-sm">
                            @lang('shop::app.components.products.carousel.view-all')

                            <span class="icon-arrow-right text-2xl max-md:text-lg max-sm:text-sm"></span>
                        </p>
                    </a>

                    <template v-if="products.length > 3">
                        <span
                            v-if="products.length > 4 || (products.length > 3 && isScreenMax2xl)"
                            class="icon-arrow-left-stylish rtl:icon-arrow-right-stylish inline-block cursor-pointer text-2xl max-lg:hidden"
                            role="button"
                            aria-label="@lang('shop::app.components.products.carousel.previous')"
                            tabindex="0"
                            @click="swipeLeft"
                        >
                        </span>

                        <span
                            v-if="products.length > 4 || (products.length > 3 && isScreenMax2xl)"
                            class="icon-arrow-right-stylish rtl:icon-arrow-left-stylish inline-block cursor-pointer text-2xl max-lg:hidden"
                            role="button"
                            aria-label="@lang('shop::app.components.products.carousel.next')"
                            tabindex="0"
                            @click="swipeRight"
                        >
                        </span>
                    </template>
                </div>
            </div>

            <div
                ref="swiperContainer"
                class="beanspa-products-carousel__track flex gap-6 pb-2.5 [&>*]:flex-[0] mt-8 overflow-auto scroll-smooth scrollbar-hide max-md:gap-5 max-md:mt-5 max-sm:gap-4 max-md:pb-0 max-md:whitespace-nowrap"
                @pointerdown="onTrackPointerDown"
                @pointermove="onTrackPointerMove"
                @pointerup="onTrackPointerUp"
                @pointercancel="onTrackPointerUp"
            >
                <x-shop::products.card
                    class="beanspa-products-carousel__card min-w-[300px] max-md:h-fit max-md:min-w-[232px] max-sm:min-w-[186px]"
                    v-for="product in products"
                />
            </div>

            <a
                :href="navigationLink"
                class="beanspa-products-carousel__viewall secondary-button mx-auto mt-6 block w-max rounded-2xl px-11 py-3 text-center text-base max-lg:mt-0 max-lg:hidden max-lg:py-3.5 max-md:rounded-lg"
                :aria-label="title"
                v-if="navigationLink"
            >
                @lang('shop::app.components.products.carousel.view-all')
            </a>
        </div>
        </section>

        <!-- Product Card Listing -->
        <template v-if="isLoading">
            <x-shop::shimmer.products.carousel :navigation-link="$navigationLink ?? false" />
        </template>
    </script>

    <script type="module">
        app.component('v-products-carousel', {
            template: '#v-products-carousel-template',

            props: [
                'src',
                'title',
                'navigationLink',
            ],

            data() {
                return {
                    isLoading: true,

                    products: [],

                    offset: 323,

                    isScreenMax2xl: window.innerWidth <= 1440,

                    activePointerId: null,

                    dragStartX: 0,

                    dragStartScrollLeft: 0,

                    isDraggingTrack: false,
                };
            },

            mounted() {
                this.getProducts();
            },

            created() {
                window.addEventListener('resize', this.updateScreenSize);
            },

            beforeDestroy() {
                window.removeEventListener('resize', this.updateScreenSize);
            },

            methods: {
                getProducts() {
                    this.$axios.get(this.src)
                        .then(response => {
                            this.isLoading = false;

                            this.products = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },

                updateScreenSize() {
                    this.isScreenMax2xl = window.innerWidth <= 1440;
                },

                swipeLeft() {
                    const container = this.$refs.swiperContainer;

                    container.scrollLeft -= this.offset;
                },

                swipeRight() {
                    const container = this.$refs.swiperContainer;

                    // Check if scroll reaches the end
                    if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
                        // Reset scroll to the beginning
                        container.scrollLeft = 0;
                    } else {
                        // Scroll to the right
                        container.scrollLeft += this.offset;
                    }
                },

                onTrackPointerDown(event) {
                    const container = this.$refs.swiperContainer;

                    if (! container || event.pointerType === 'mouse' && event.button !== 0) {
                        return;
                    }

                    this.activePointerId = event.pointerId;
                    this.dragStartX = event.clientX;
                    this.dragStartScrollLeft = container.scrollLeft;
                    this.isDraggingTrack = true;

                    container.setPointerCapture(event.pointerId);
                    container.classList.add('is-dragging');
                },

                onTrackPointerMove(event) {
                    const container = this.$refs.swiperContainer;

                    if (! this.isDraggingTrack || ! container || event.pointerId !== this.activePointerId) {
                        return;
                    }

                    const deltaX = event.clientX - this.dragStartX;

                    container.scrollLeft = this.dragStartScrollLeft - deltaX;
                },

                onTrackPointerUp(event) {
                    const container = this.$refs.swiperContainer;

                    if (! container || event.pointerId !== this.activePointerId) {
                        return;
                    }

                    if (container.hasPointerCapture(event.pointerId)) {
                        container.releasePointerCapture(event.pointerId);
                    }

                    this.activePointerId = null;
                    this.isDraggingTrack = false;
                    container.classList.remove('is-dragging');
                },
            },
        });
    </script>
@endPushOnce

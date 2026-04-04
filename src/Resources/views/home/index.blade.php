@php
    $channel = core()->getCurrentChannel();
@endphp

@push ('meta')
    <meta
        name="title"
        content="{{ $channel->home_seo['meta_title'] ?? 'BeanSpa - Natural Wellness' }}"
    />

    <meta
        name="description"
        content="{{ $channel->home_seo['meta_description'] ?? 'BeanSpa handcrafted wellness products for mindful daily rituals.' }}"
    />

    <meta
        name="keywords"
        content="{{ $channel->home_seo['meta_keywords'] ?? 'beanspa, wellness, skincare, bodycare' }}"
    />
@endPush

@push('scripts')
    @if (! empty($categories))
        <script>
            localStorage.setItem('categories', JSON.stringify(@json($categories)));
        </script>
    @endif
@endpush

@push('styles')
    <style>
        .beanspa-swiper .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.55);
            opacity: 1;
            transition: all 0.25s ease;
        }

        .beanspa-swiper .swiper-pagination-bullet-active {
            width: 32px;
            background: #f0a793;
        }
    </style>
@endpush

<x-shop::layouts>
    <x-slot:title>
        {{ $channel->home_seo['meta_title'] ?? 'BeanSpa - Natural Wellness' }}
    </x-slot>

    <section class="bg-white px-0 pb-8 pt-0 lg:pb-10 lg:pt-0">
        <div class="mx-auto w-full px-5">
            <div class="beanspa-swiper swiper relative w-full overflow-hidden rounded-[32px] bg-[#2d1c17] shadow-[0_14px_40px_rgba(48,28,18,0.15)] aspect-[3/2] sm:aspect-[16/9] lg:aspect-[21/9]">
                <div class="swiper-wrapper h-full">
                    {{-- Slide 1 --}}
                    <div class="swiper-slide relative h-full">
                        <img
                            src="{{ bagisto_asset('images/slider-hero.jpg') }}"
                            alt="BeanSpa hero slider 1"
                            class="absolute inset-0 h-full w-full object-cover"
                        >
                        <div class="pointer-events-none absolute inset-0 z-10 bg-[linear-gradient(90deg,rgba(30,18,14,0.72)_0%,rgba(30,18,14,0.28)_45%,rgba(30,18,14,0.08)_100%)]"></div>
                        <div class="absolute inset-0 z-20 flex items-center py-6 pl-10 pr-5 sm:py-10 sm:pl-16 sm:pr-10 lg:pl-24 lg:pr-20">
                            <div class="max-w-[520px] text-white">
                                <span class="inline-flex rounded-full border border-white/70 px-3 py-1.5 text-xs font-medium sm:px-7 sm:py-2.5 sm:text-[15px]">
                                    Chăm Sóc Sắc Đẹp Toàn Diện
                                </span>
                                <h1 class="mt-2 font-heading text-[28px] font-semibold leading-[1.05] sm:mt-4 sm:text-[48px] lg:text-[56px] lg:leading-[1.06]">
                                    Nâng Niu Vẻ Đẹp Của Bạn
                                </h1>
                                <div class="mt-3 flex flex-wrap gap-3 sm:mt-6 sm:gap-4">
                                    <a
                                        href="{{ route('shop.search.index') }}"
                                        class="inline-flex items-center gap-2 rounded-full bg-brand-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-primary/90 sm:px-8 sm:py-3.5 sm:text-lg"
                                    >
                                        Xem thêm
                                        <span class="icon-arrow-right text-base sm:text-xl"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Slide 2 --}}
                    <div class="swiper-slide relative h-full">
                        <img
                            src="{{ bagisto_asset('images/slider-hero-2.jpg') }}"
                            alt="BeanSpa hero slider 2"
                            class="absolute inset-0 h-full w-full object-cover"
                        >
                        <div class="pointer-events-none absolute inset-0 z-10 bg-[linear-gradient(90deg,rgba(20,40,35,0.70)_0%,rgba(20,40,35,0.25)_50%,rgba(20,40,35,0.05)_100%)]"></div>
                        <div class="absolute inset-0 z-20 flex items-center py-6 pl-10 pr-5 sm:py-10 sm:pl-16 sm:pr-10 lg:pl-24 lg:pr-20">
                            <div class="max-w-[520px] text-white">
                                <span class="inline-flex rounded-full border border-white/70 px-3 py-1.5 text-xs font-medium sm:px-7 sm:py-2.5 sm:text-[15px]">
                                    Sản Phẩm Thuần Tự Nhiên
                                </span>
                                <h2 class="mt-2 font-heading text-[28px] font-semibold leading-[1.05] sm:mt-4 sm:text-[48px] lg:text-[56px] lg:leading-[1.06]">
                                    Thư Giãn & Tái Tạo Năng Lượng
                                </h2>
                                <div class="mt-3 flex flex-wrap gap-3 sm:mt-6 sm:gap-4">
                                    <a
                                        href="{{ route('shop.search.index') }}"
                                        class="inline-flex items-center gap-2 rounded-full bg-brand-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-primary/90 sm:px-8 sm:py-3.5 sm:text-lg"
                                    >
                                        Khám phá ngay
                                        <span class="icon-arrow-right text-base sm:text-xl"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button
                    type="button"
                    class="absolute left-5 top-1/2 z-30 hidden h-14 w-14 -translate-y-1/2 items-center justify-center rounded-full bg-brand-primary/70 text-white transition hover:bg-brand-primary lg:flex"
                    aria-label="Slider trước"
                    data-swiper-prev
                >
                    <span class="icon-arrow-left text-2xl"></span>
                </button>

                <button
                    type="button"
                    class="absolute right-5 top-1/2 z-30 hidden h-14 w-14 -translate-y-1/2 items-center justify-center rounded-full bg-brand-primary/70 text-white transition hover:bg-brand-primary lg:flex"
                    aria-label="Slider tiếp theo"
                    data-swiper-next
                >
                    <span class="icon-arrow-right text-2xl"></span>
                </button>

                <div class="absolute bottom-4 left-1/2 z-30 hidden -translate-x-1/2 lg:flex" data-swiper-pagination></div>
            </div>
        </div>
    </section>

    @foreach ($customizations as $customization)
        @php($data = $customization->options)

        @switch ($customization->type)
            @case ($customization::IMAGE_CAROUSEL)
                <x-shop::carousel
                    :options="$data"
                    aria-label="{{ trans('shop::app.home.index.image-carousel') }}"
                />

                @break
            @case ($customization::STATIC_CONTENT)
                @if (! empty($data['css']))
                    @push ('styles')
                        <style>
                            {{ $data['css'] }}
                        </style>
                    @endpush
                @endif

                @if (! empty($data['html']))
                    {!! $data['html'] !!}
                @endif

                @break
            @case ($customization::CATEGORY_CAROUSEL)
                <x-shop::categories.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.categories.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.home.index')"
                    aria-label="{{ trans('shop::app.home.index.categories-carousel') }}"
                />

                @break
            @case ($customization::PRODUCT_CAROUSEL)
                <x-shop::products.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.products.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.search.index', $data['filters'] ?? [])"
                    aria-label="{{ trans('shop::app.home.index.product-carousel') }}"
                />

                @break
        @endswitch
    @endforeach
</x-shop::layouts>

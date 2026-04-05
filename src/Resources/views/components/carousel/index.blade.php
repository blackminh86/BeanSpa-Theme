@props(['options'])

@php
    $images = collect($options['images'] ?? [])->filter(fn ($image) => ! empty($image['image']))->values();

    $defaultSlides = [
        [
            'badge'    => 'Chăm Sóc Sắc Đẹp Toàn Diện',
            'title'    => 'Nâng Niu Vẻ Đẹp Của Bạn',
            'cta'      => 'Xem thêm',
            'gradient' => 'bg-[linear-gradient(90deg,rgba(30,18,14,0.72)_0%,rgba(30,18,14,0.28)_45%,rgba(30,18,14,0.08)_100%)]',
        ],
        [
            'badge'    => 'Sản Phẩm Thuần Tự Nhiên',
            'title'    => 'Thư Giãn & Tái Tạo Năng Lượng',
            'cta'      => 'Khám phá ngay',
            'gradient' => 'bg-[linear-gradient(90deg,rgba(20,40,35,0.70)_0%,rgba(20,40,35,0.25)_50%,rgba(20,40,35,0.05)_100%)]',
        ],
    ];
@endphp

@if ($images->isNotEmpty())
    <section class="bg-white px-0 pb-8 pt-0 lg:pb-10 lg:pt-0">
        <div class="mx-auto w-full px-5">
            <div class="beanspa-swiper swiper relative w-full overflow-hidden rounded-[32px] bg-[#2d1c17] shadow-[0_14px_40px_rgba(48,28,18,0.15)] aspect-[3/2] sm:aspect-[16/9] lg:aspect-[21/9]">
                <div class="swiper-wrapper h-full">
                    @foreach ($images as $index => $image)
                        @php
                            $slide = $defaultSlides[$index % count($defaultSlides)];
                            $title = $image['title'] ?? $slide['title'];
                            $link = $image['link'] ?? route('shop.search.index');
                        @endphp

                        <div class="swiper-slide relative h-full">
                            <img
                                src="{{ $image['image'] }}"
                                alt="{{ $title }}"
                                class="absolute inset-0 h-full w-full object-cover"
                            >

                            <div class="pointer-events-none absolute inset-0 z-10 {{ $slide['gradient'] }}"></div>

                            <div class="absolute inset-0 z-20 flex items-center py-6 pl-10 pr-5 sm:py-10 sm:pl-16 sm:pr-10 lg:pl-24 lg:pr-20">
                                <div class="max-w-[520px] text-white">
                                    <span class="inline-flex rounded-full border border-white/70 px-3 py-1.5 text-xs font-medium sm:px-7 sm:py-2.5 sm:text-[15px]">
                                        {{ $slide['badge'] }}
                                    </span>

                                    <h2 class="mt-2 font-heading text-[28px] font-semibold leading-[1.05] sm:mt-4 sm:text-[48px] lg:text-[56px] lg:leading-[1.06]">
                                        {{ $title }}
                                    </h2>

                                    <div class="mt-3 flex flex-wrap gap-3 sm:mt-6 sm:gap-4">
                                        <a
                                            href="{{ $link }}"
                                            class="inline-flex items-center gap-2 rounded-full bg-brand-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-primary/90 sm:px-8 sm:py-3.5 sm:text-lg"
                                        >
                                            {{ $slide['cta'] }}

                                            <span class="icon-arrow-right text-base sm:text-xl"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($images->count() > 1)
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
                @endif
            </div>
        </div>
    </section>
@endif
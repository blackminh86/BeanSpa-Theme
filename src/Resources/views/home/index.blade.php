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

<x-shop::layouts>
    <x-slot:title>
        {{ $channel->home_seo['meta_title'] ?? 'BeanSpa - Natural Wellness' }}
    </x-slot>

    <section class="bg-gradient-to-r from-[#0f766e] to-[#0e7490] text-white">
        <div class="mx-auto max-w-[1440px] px-6 py-20 md:px-10 lg:px-14">
            <div class="max-w-3xl">
                <p class="mb-4 text-sm uppercase tracking-[0.25em] text-teal-100">Beanspa Collection</p>

                <h1 class="mb-6 text-4xl font-semibold leading-tight md:text-6xl">
                    Ritual wellness for calmer mornings and softer evenings.
                </h1>

                <p class="mb-10 text-lg text-teal-50 md:text-xl">
                    Discover curated body and skin essentials inspired by botanical care and simple routines.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a
                        href="{{ route('shop.search.index') }}"
                        class="rounded-full bg-white px-8 py-3 text-sm font-semibold uppercase tracking-widest text-teal-700 transition hover:bg-teal-50"
                    >
                        Shop Now
                    </a>

                    <a
                        href="{{ route('shop.search.index', ['sort' => 'created_at']) }}"
                        class="rounded-full border border-white/50 px-8 py-3 text-sm font-semibold uppercase tracking-widest text-white transition hover:bg-white/10"
                    >
                        New Arrivals
                    </a>
                </div>
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

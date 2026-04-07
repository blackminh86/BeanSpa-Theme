{!! view_render_event('bagisto.shop.layout.features.before') !!}

<!--
    The ThemeCustomizationRepository repository is injected directly here because there is no way
    to retrieve it from the view composer, as this is an anonymous component.
-->
@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

@php
    $channel = core()->getCurrentChannel();

    $customization = $themeCustomizationRepository->findOneWhere([
        'type'       => 'services_content',
        'status'     => 1,
        'theme_code' => $channel->theme,
        'channel_id' => $channel->id,
    ]); 
@endphp

<!-- Features -->
@if ($customization)
    <section
        class="section-index section_thong_ke"
        v-pre
    >
        <div class="container">
            <div class="box_thongke">
                <div class="thongke-grid">
                    @foreach ($customization->options['services'] as $service)
                        <div class="thongke-item {{ $loop->first ? '' : 'thongke-item--divider' }}">
                            <span
                                class="thongke-icon"
                                role="presentation"
                            >
                                <span class="{{ $service['service_icon'] }} thongke-icon-glyph"></span>
                            </span>

                            <div class="thongke-content">
                                <p class="thongke-num font-dmserif">
                                    {{ $service['title'] }}
                                </p>

                                <p class="thongke-label">
                                    {{ $service['description'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

{!! view_render_event('bagisto.shop.layout.features.after') !!}
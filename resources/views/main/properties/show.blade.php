@section('title', $row->title)
@section('description', Str::limit($row->title, 150))
@section('image', propertyImage($row->main_image, 'medium'))
@section('image-type', 'webp')
@extends('main.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('body-class', 'bg-gray-200')
{{-- <x-css :links="[['from' => 'plugins', 'link' => 'owl-carousel/owl.carousel.min.css']]" /> --}}
@section('content')


    <main id="property-show">

        <header id="gallery" class="section-gap mb-3 mt-4 mb-md-4">
            <div class="container">
                <div class="form-row">

                    <div
                        class="main-image-container mb-2 mb-md-0 {{ count($row->attachments) == 0 ? 'col-12' : 'col-md-8' }}">

                        <a href="{{ propertyImage($row->main_image, 'large') }}" data-fancybox="group" data-caption="">
                            <img class="main-img cursor-zoom-in" src="{{ propertyImage($row->main_image, 'large') }}"
                                alt="">
                        </a>

                        @if ($row->youtube_video_url)
                            <a href="{{ youtubeEmbed($row->youtube_video_url) }}" class="youtube-play-btn-modern"
                                data-fancybox="group" title="{{ __('main.property.watch_video') }}">
                                <svg width="24" height="24" viewBox="0 0 260 180" fill="white">
                                    <path
                                        d="M220,2H40C19.01,2,2,19.01,2,40v100c0,20.99,17.01,38,38,38h180c20.99,0,38-17.01,38-38V40C258,19.01,240.99,2,220,2z M102,130V50l68,40L102,130z" />
                                </svg>
                            </a>
                        @endif

                    </div>
                    <!-- main image -->

                    <div class="col-md-4">
                        @if (count($row->attachments))
                            <section id="more-images" class="">
                                <div class="form-row">
                                    @foreach ($row->attachments as $img)
                                        <div class="col-6 col-md-12 {{ $loop->index > 1 ? 'd-none' : '' }}">
                                            <a href="{{ propertyImage('attachments/' . $img->attachment_name, 'large') }}"
                                                data-fancybox="group" data-caption="">
                                                <img class=" radius {{ $loop->first ? 'mb-2' : '' }}"
                                                    src="{{ propertyImage('attachments/' . $img->attachment_name, 'medium') }}"
                                                    loading="lazy" alt="">
                                            </a>
                                        </div>
                                    @endforeach
                                </div><!-- form-row -->
                            </section>
                        @endif
                    </div><!-- attachments -->

                </div><!-- row -->
            </div><!-- container -->
        </header><!-- header gallery -->

        <div id="header-bar">
            <div class="container d-flex align-items-center justify-content-between flex-wrap">

                <div class="d-flex flex-column">
                    <h1 class="mb-1">{{ $row->title }}</h1>
                    @if (!empty($row->city) || empty($row->neighborhood))
                        <div class="meta-mini mt-2 mt-md-1">
                            <span class="badge-dot">
                                @if (!empty($row->city))
                                    {{ $row->city->name }}
                                @endif
                                @if (!empty($row->neighborhood))
                                    — {{ $row->neighborhood->name }}
                                @endif
                            </span>
                        </div>
                    @endif

                </div><!-- title & location -->

                <div class="text-nowrap my-2 d-flex align-items-center">
                    @if ($row->getPrice())
                        <span class="price-badge">
                            <span class="currency-icon">{!! currency_icon() !!}</span>
                            @if ($row->purpose == 'sale')
                                {{ number_format($row->sale_price) }}
                            @else
                                {{ number_format($row->rent_price_monthly) }}
                                <span class="font-13 text-muted">/
                                    {{ __('main.property.per_month') }}</span>
                            @endif
                        </span><!-- price -->
                    @endif
                </div><!-- price + location -->

            </div>
        </div><!-- Header bar -->

        <div class="container">
            <div class="row">
                <div class="col-12">

                    <section id="details" class="details section-gap mt-3">
                        <div class="box p-4 p-md-5">
                            <h4 class="section-title mb-3">{{ __('main.property.details') }}</h4>
                            <div class="form-row">
                                @foreach ($details as $item)
                                    @php $has = filled($item['value']); @endphp
                                    @if ($has)
                                        <div class="col-lg-4 col-sm-6 col-12 mb-2">
                                            <div class="detail-chip">
                                                <span class="icon">{!! $item['icon'] !!}</span>
                                                <span class="label">{{ $item['name'] }}</span>
                                                <span class="value ">
                                                    {{ $item['value'] }}@if ($item['text'])
                                                        <small>{{ $item['text'] }}</small>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <div class="row">

                        @if ($row->description)
                            <div class=" {{ count($row->features) + count($row->amenities) > 0 ? 'col-md-7' : 'col-12' }}">
                                <section id="desc" class="section-gap">
                                    <div class="box p-4 p-md-5">
                                        <h4 class="section-title mb-3">{{ __('main.property.description') }}</h4>

                                        @php
                                            $desc = $row->description;
                                            $short = mb_substr($desc, 0, 350);
                                            $hasMore = mb_strlen($desc) > 350;
                                        @endphp

                                        <div class="description">
                                            {!! nl2br(e($short)) !!}
                                            @if ($hasMore)
                                                <span class="dots">...</span>
                                                <span class="more d-none">{!! nl2br(e(mb_substr($desc, 350))) !!}</span>
                                                <div class="read-more mt-2">
                                                    <a href="javascript:void(0)" class="show-more text-primary">Read
                                                        More</a>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </section>
                            </div>
                        @endif
                        @if (count($row->features) + count($row->amenities) > 0)
                            <div class="col-md-5">
                                <section id="features" class="section-gap">
                                    <div class="box p-4 p-lg-5">
                                        <h4 class="section-title mb-3">{{ __('main.property.features') }} &
                                            {{ __('main.property.amenities') }}</h4>

                                        <div class="row">
                                            @foreach (collect($row->features)->merge($row->amenities) as $feature)
                                                <div class="col-md-6 col-sm-6 col-12 mb-2">
                                                    <div class="feature-item">
                                                        <span class="icon mr-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" fill="#000000" viewBox="0 0 256 256">
                                                                <path
                                                                    d="M176.49,95.51a12,12,0,0,1,0,17l-56,56a12,12,0,0,1-17,0l-24-24a12,12,0,1,1,17-17L112,143l47.51-47.52A12,12,0,0,1,176.49,95.51ZM236,128A108,108,0,1,1,128,20,108.12,108.12,0,0,1,236,128Zm-24,0a84,84,0,1,0-84,84A84.09,84.09,0,0,0,212,128Z">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                        <span class="font-weight-400">{{ $feature->name }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </section>
                            </div>
                        @endif
                    </div>


                    @if ($row->google_map_iframe)
                        <section id="location" class="section-gap">
                            <div class="box p-4 p-md-5">

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h4 class="section-title mb-0 ">الموقع على الخريطة</h4>
                                    <div class="meta-mini d-none d-sm-block ">
                                        {{ $row->city?->name }} — {{ $row->neighborhood?->name }}
                                    </div>
                                </div>

                                {!! $row->google_map_iframe !!}

                            </div>
                        </section>
                    @endif



                    @if (count($row->units))
                        <div id="models" class="section-gap">
                            <div class="box p-0">
                                <h4 class="section-title px-4 px-lg-5 pt-4 pt-lg-4 mb-3">{{ __('main.property.models') }}
                                </h4>


                                <ul class="nav px-4 px-lg-5  nav-tabs" id="myTab" role="tablist">
                                    @foreach ($row->units as $item)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->index == 0 ? 'active' : '' }}"
                                                id="tab-{{ $item->id }}" data-toggle="tab"
                                                href="#tab-item-{{ $item->id }}" role="tab" aria-controls="home"
                                                aria-selected="true">
                                                {{ $item->unit_number }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content px-4 px-lg-5 pb-4" id="myTabContent">
                                    @foreach ($row->units as $item)
                                        <div class="tab-pane pt-4 show {{ $loop->index == 0 ? 'active' : '' }}"
                                            id="tab-item-{{ $item->id }}" role="tabpanel"
                                            aria-labelledby="home-tab">

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="">

                                                        <div class="detail-chip py-2 mb-2">
                                                            <img style="width: 16px"
                                                                src="{{ asset('dashboard/images/icons/mtr.svg') }}"
                                                                alt="">
                                                            <div class="label d-inline-block">
                                                                {{ __('main.property.area') }}
                                                            </div>
                                                            <div class="value d-inline-block">
                                                                {{ $item->area }}
                                                                {{ __('main.property.square_meter') }}
                                                            </div>
                                                        </div>

                                                        <div class="detail-chip py-2 mb-2">
                                                            {!! $icons['bedrooms'] !!}
                                                            <div class="label d-inline-block">
                                                                {{ __('main.property.bedrooms') }} :
                                                            </div>
                                                            <div class="value d-inline-block">{{ $item->bedrooms }}
                                                            </div>
                                                        </div>

                                                        <div class="detail-chip py-2 mb-2">
                                                            {!! $icons['bathrooms'] !!}
                                                            <div class="label d-inline-block">
                                                                {{ __('main.property.bathrooms') }}
                                                            </div>
                                                            <div class="value d-inline-block">{{ $item->bathrooms }}
                                                            </div>
                                                        </div>

                                                        <div class="detail-chip py-2 mb-2">

                                                            <div class="label d-inline-block">
                                                                {{ __('main.property.price') }}
                                                            </div>
                                                            <div class="value d-inline-block">
                                                                <span class="price-badge">
                                                                    {{ number_format($item->price) }}
                                                                    <span
                                                                        class="currency-icon">{!! currency_icon() !!}</span>
                                                                </span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div><!-- info -->

                                                <div class="col-md-8">
                                                    <img class="radius img-fluid"src="{{ largeAsset('properties/units/' . $item->image) }}"
                                                        alt="" loading="lazy">
                                                </div>

                                            </div>

                                        </div>
                                    @endforeach
                                </div>


                            </div>
                        </div>
                    @endif


                           <section id="property-whatsapp-cta" class="section-gap pt-0">

                        <div class="whatsapp-cta">

                            <div class="row align-items-center">

                                <div class="col-lg-8">

                                    <div class="whatsapp-cta-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                            <path
                                                d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                                        </svg>
                                    </div>

                                    <div class="whatsapp-cta-content">

                                        <h3>
                                          تواصل معنا مباشر
                                        </h3>

                                        <p>
                                            إذا كنت تفضل عدم استخدام النموذج، يمكنك التواصل معنا عبر واتساب أو الاتصال بنا
                                            مباشرة، وسنكون سعداء بخدمتك.
                                        </p>

                                        <span class="reply-time">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-bolt">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M13 3l0 7l6 0l-8 11l0 -7l-6 0l8 -11" />
                                            </svg>
                                            بنرد عليك في أسرع وقت.
                                        </span>

                                    </div>

                                </div>

                                <div class="col-lg-4">

                                    <div class="whatsapp-cta-actions">

                                        <a href="https://wa.me/201234567890" target="_blank" class="btn btn-whatsapp">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                            <path
                                                d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                                        </svg>
                                            ابدأ المحادثة
                                        </a>

                                        <a href="tel:+201234567890" class="btn btn-call">

                                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>

                                            اتصل بنا

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>


                    </section>

                    
                    <section id="interest" class="mb-5 section-gap">
                        <div class="box p-4 p-lg-5">

                            @if ($clientHasInterest)
                                <div class="text-center py-4">
                                    <img src="{{ asset('assets/images/shapes/check-outline-second.png') }}"
                                        alt="Success" width="120">
                                    <h5 class="mt-3">{{ __('main.property.request_received_title') }}</h5>
                                    <p class="text-muted mb-2">{{ __('main.property.request_received_message') }}</p>
                                </div>
                            @else
                                <div class="section-title mb-4">
                                    <h4 class="mb-0">{{ __('main.property.interested_title') }}</h4>
                                    <p class=" font-weight-300 text-secondary font-16 mb-0 mt-2">
                                        {{ __('main.property.contact_prompt') }}
                                    </p>
                                </div>

                                <form class="form" method="POST"
                                    action="{{ route('main.properties.interests.store', $row->uuid) }}">
                                    @csrf

                                    @if (!clientHasAuth())

                                        <div class="form-row">

                                            <div class="col-md-6">
                                                <x-form-group :properties="[
                                                    'input' => [
                                                        'type' => 'text',
                                                        'name' => 'name',
                                                        'options' => [
                                                            'required',
                                                            'placeholder' => __('main.property.placeholder_name'),
                                                            'maxlength' => 45,
                                                        ],
                                                    ],
                                                    'label' => [
                                                        'text' => __('main.property.full_name'),
                                                    ],
                                                ]" />
                                            </div><!-- name -->

                                            <div class="col-md-6">
                                                <div class="form-row">

                                                    <div class="col-12">
                                                        <label for="">{{ __('main.property.phone') }}</label>
                                                    </div>

                                                    <div class="col-xl-3 col-md-5 col-sm-4 col-6">
                                                        <div class="input-flags">
                                                            <select name="country_code" class="country-select">
                                                                @foreach ($globalPhoneData['countries'] as $country)
                                                                    <option value="{{ $country['code'] }}"
                                                                        data-flag="{{ $country['flag'] }}">
                                                                        {{ $country['code'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-9 col-md-7 col-sm-8 col-6">
                                                        <x-form-group :properties="[
                                                            'input' => [
                                                                'type' => 'number',
                                                                'name' => 'phone',
                                                                'value' => '',
                                                                'options' => [
                                                                    'required',
                                                                    'placeholder' => __(
                                                                        'client.register.form.phone_number',
                                                                    ),
                                                                ],
                                                            ],
                                                        ]" />
                                                    </div><!-- phone -->

                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <x-form-group :properties="[
                                                    'input' => [
                                                        'type' => 'text',
                                                        'name' => 'email',
                                                        'options' => [
                                                            'required',
                                                            'placeholder' => __('main.property.placeholder_email'),
                                                            'maxlength' => 150,
                                                        ],
                                                    ],
                                                    'label' => [
                                                        'text' => __('main.property.email_optional'),
                                                    ],
                                                ]" />
                                            </div>

                                        </div>

                                    @endif

                                    <x-form-group :properties="[
                                        'textarea' => [
                                            'name' => 'message',
                                            'options' => [
                                                'required',
                                                'placeholder' => __('main.property.placeholder_interest_message', [
                                                    'name' => clientAuth('name'),
                                                ]),
                                                'rows' => 5,
                                            ],
                                        ],
                                        'label' => [
                                            'text' => __('main.property.message'),
                                        ],
                                    ]" />

                                    <button type="submit"
                                        class="btn btn-second px-5 mt-2 btn-shine btn-block">{{ __('main.property.send_interest') }}</button>
                                </form>


                            @endif

                        </div>
                    </section>


             


                </div><!-- col-lg-8 -->

            </div><!-- row -->
        </div><!-- container -->

    </main>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        // دعم data-fancybox="group" في Fancybox v6
        document.addEventListener('DOMContentLoaded', function() {
            // لكل group موجود
            document.querySelectorAll('[data-fancybox="group"]').forEach(function(el) {
                const groupName = 'group'; // اسم الجروب الثابت

                // اجمع كل الـ links بنفس الـ group
                const groupLinks = document.querySelectorAll('[data-fancybox="group"]');

                // حوّلها لـ Fancybox gallery
                Fancybox.bind(groupLinks, {
                    groupAll: true, // كلهم في جاليري واحد
                    Thumbs: {
                        autoStart: false
                    } // thumbnails اختياري
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {

            $('.show-more').on('click', function() {
                var $btn = $(this);
                var $wrap = $btn.closest('.description');
                $wrap.find('.more').toggleClass('d-none');
                $wrap.find('.dots').toggleClass('d-none');
                $btn.text($btn.text().trim() === 'عرض المزيد' ? 'إخفاء' : 'عرض المزيد');
            });

            function formatFlag(state) {
                if (!state.id) {
                    return state.text;
                }

                var flag = $(state.element).data('flag');

                var $state = $(
                    '<span><img class="flag-img" src="' + flag + '" /> ' + state.text + '</span>'
                );

                return $state;
            }

            $('.country-select').select2({
                templateResult: formatFlag,
                templateSelection: formatFlag,
                minimumResultsForSearch: -1, // disable search
                width: '100%'
            });

        });
    </script>
@endsection



{{-- <x-js :links="[
    ['from' => 'plugins', 'link' => 'owl-carousel/owl.carousel.min.js'],
    ['from' => 'pages', 'link' => 'home/home.js'],
]" /> --}}

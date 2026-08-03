@php
    $removeAppNameFromTitle = true;
    $headerSliderTitleDesc = $headerSliderTitleDesc['title'];
    // replace *word* with span (keep position)
    $cleanTitle = preg_replace('/\*(.*?)\*/', '<span class="app-name">$1</span>', $headerSliderTitleDesc);
@endphp
@section('title', 'أمكنة | عقارات للبيع والإيجار في مصر - شقق، فلل ومحلات بالتقسيط أو الكاش')
@section('description', __('main.footer.description'))
@section('image', metaImage('meta-home.webp'))
@section('image-type', 'webp')
@extends('main.layouts.master')
@section('css')
    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection
@section('content')

    <main id="home-page">

        <section style="background-image: url({{ $headerRandomImage }})" id="home-banner">
            <div class="container d-flex h-100 align-items-center justify-content-center">
                <div class=" text-center w-100">


                    {{-- Home Search Box --}}
                    <div class="row justify-content-center">

                        <div class="col-lg-7 col-md-12">
                            <h1 class="mb-0">{!! $cleanTitle !!}</h1>
                        </div>

                        <div class="col-lg-8 col-md-10">


                            <form action="{{ route('main.properties.index') }}" method="GET" class="home-search-box mt-4">

                                <div class="home-search-inner">

                                    <div class="d-flex justify-content-center pb-0">
                                        <div class="home-search-purpose">
                                            @foreach ($sections as $key => $section)
                                                <button type="button"
                                                    class="home-purpose-btn {{ ($filters['purpose'] ?? 'sale') == $key ? 'active' : '' }}"
                                                    data-purpose="{{ $key }}">
                                                    {!! $section['short_icon'] ?? $section['icon'] !!}
                                                    {{ $section['name'] }}
                                                </button>
                                            @endforeach
                                            <input type="hidden" name="purpose" class="home-selected-purpose"
                                                value="{{ $filters['purpose'] ?? 'sale' }}">
                                        </div>
                                    </div>{{-- Purpose (بيع / إيجار) --}}

                                    <div class="d-flex pb-0 inputs-box mt-1 ">

                                        {{-- Location --}}
                                        <div class="home-search-location flex-grow-1">
                                            <div class="form-group mb-0">
                                                <select name="city_id" class="form-control choices"
                                                    data-placeholder="{{ __('main.filters.location_placeholder') }}">
                                                    <option value="" hidden>{{ __('main.filters.all') }}</option>
                                                    @foreach (getCities() as $cityRow)
                                                        <option value="{{ $cityRow->id }}">
                                                            {{ $cityRow->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div><!-- form-group -->
                                        </div>

                                        {{-- Property Type --}}
                                        <div class="home-search-type">
                                            <div class="form-group mb-0">
                                                <select name="property_type_id" class="form-control choices"
                                                    data-placeholder="{{ __('main.filters.property_type') }}">
                                                    <option value="" hidden>{{ __('main.filters.all') }}</option>
                                                    @foreach ($propertyTypes as $type)
                                                        <option value="{{ $type->id }}"
                                                            {{ ($filters['property_type_id'] ?? '') == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        {{-- Submit --}}
                                        <div class="home-search-submit">
                                            <button type="submit" style="min-width: 100px"
                                                class="btn btn-second btn-block">
                                                {{ __('main.filters.search') }}
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </form>

                        </div><!-- col -->
                    </div><!-- row -->

                </div>
            </div>
        </section>

        <div class="translateY-up">

            {{-- Neighborhoods Section (Swiper) --}}
            <section id="home-neighborhoods" class="section-gap">
                <div class="container-fluid">
                    <div class="section-header text-center mb-0 mb-lg-5">
                        <h2 class="section-title">أهم المناطق</h2>
                        <p class="section-subtitle">تصفح العقارات في أشهر المدن والمناطق</p>
                    </div>

                    <div class="swiper swiper-neighborhoods">
                        <div class="swiper-wrapper">
                            @foreach ($neighborhoods as $neighborhood)
                                <div class="swiper-slide">
                                    <a href="{{ route('main.properties.index', ['neighborhood_id' => $neighborhood->id]) }}"
                                        class="city-card d-block position-relative overflow-hidden">

                                        <img src="{{ $neighborhood->image != '' ? largeAsset('neighborhoods/' . $neighborhood->image) : asset('assets/images/default/default-banner-home.png') }}"
                                            class="img-fluid w-100 h-100 city-card__image" alt="{{ $neighborhood->name }}">

                                        <div class="city-card__overlay d-flex align-items-center justify-content-between">

                                            <div class="city-card__title">
                                                {{ $neighborhood->name }}
                                            </div>

                                            <div class="city-card__icon">

                                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

                                                    <path d="M12 22s7-6.2 7-12a7 7 0 1 0-14 0c0 5.8 7 12 7 12z" />

                                                    <circle cx="12" cy="10" r="2.8" />

                                                </svg>

                                            </div>

                                        </div>

                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Navigation -->
                        <div class="swiper-button-next swiper-button-next-neighborhoods"></div>
                        <div class="swiper-button-prev swiper-button-prev-neighborhoods"></div>
                    </div>
                </div>
            </section>

            {{-- Budget Section --}}
            <section id="home-budget" class="section-gap">
                <div class="container-fluid">
                    <div class="section-header text-center mb-5">
                        <h2 class="section-title">ابحث حسب ميزانيتك</h2>
                        <p class="section-subtitle">اختر الفئة المناسبة لميزانيتك واستعرض أفضل العقارات المتاحة</p>
                    </div>

                    <div class="row no-gutters budget-row">

                        <div class="col-xl-3 col-md-6 mb-4 mb-lg-0">
                            <a href="{{ route('main.properties.index', ['purpose' => 'sale', 'price_max' => 1500000]) }}"
                                class="budget-card">
                                <span class="budget-shape"></span>
                                <span class="budget-tag">أقل من</span>
                                <span class="budget-price">1,500,000</span>
                                <span class="budget-currency">الجنيه المصري</span>
                                <span class="budget-btn">عرض العقارات</span>
                            </a>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4 mb-lg-0">
                            <a href="{{ route('main.properties.index', ['purpose' => 'sale', 'price_min' => 1500000, 'price_max' => 5000000]) }}"
                                class="budget-card">
                                <span class="budget-shape"></span>
                                <span class="budget-tag">من</span>
                                <span class="budget-price">1.5 - 5 مليون</span>
                                <span class="budget-currency">الجنيه المصري</span>
                                <span class="budget-btn">عرض العقارات</span>
                            </a>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4 mb-lg-0">
                            <a href="{{ route('main.properties.index', ['purpose' => 'sale', 'price_min' => 5000000, 'price_max' => 10000000]) }}"
                                class="budget-card">
                                <span class="budget-shape"></span>
                                <span class="budget-tag">من</span>
                                <span class="budget-price">5 - 10 مليون</span>
                                <span class="budget-currency">الجنيه المصري</span>
                                <span class="budget-btn">عرض العقارات</span>
                            </a>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4 mb-lg-0">
                            <a href="{{ route('main.properties.index', ['purpose' => 'sale', 'price_min' => 10000000]) }}"
                                class="budget-card">
                                <span class="budget-shape"></span>
                                <span class="budget-tag">أكثر من</span>
                                <span class="budget-price">10 مليون</span>
                                <span class="budget-currency">الجنيه المصري</span>
                                <span class="budget-btn">عرض العقارات</span>
                            </a>
                        </div>

                    </div>
                </div>
            </section>

            <section id="home-latest-property" class="section-gap">
                <div class="container -fluid">

                    <div class="section-header text-center mb-5">
                        <h2 class="section-title">{{ __('main.home.latest_properties') }}</h2>
                        <p class="section-subtitle">{{ __('main.home.explore_latest_properties') }}</p>
                    </div>

                    <div class="row md-gap">
                        @foreach ($latestProperties as $i => $property)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                                <a href="{{ propertyUrl($property) }}">
                                    <article class="property-card-premium">

                                        <div class="property-image">
                                            <img src="{{ propertyImage($property->main_image, 'medium') }}"
                                                alt="">
                                        </div><!-- image -->

                                        <div class="property-wrapper">

                                            <div class="property-badges p-3">

                                                <small
                                                    class="badge archived-badge">{{ $property->availability_status->mainCardlabel() }}</small>

                                                {{-- 
                                        @if ($property->purpose === 'sale')
                                            <small
                                                class="badge badge-sale">{{ __('main.property.' . $row->purpose) }}</small>
                                        @else
                                            <small class="badge badge-rent">Rent</small>
                                        @endif --}}

                                                <span class="badge {{ $property->purpose_color }} status-badge">
                                                    {{ __('main.property.' . $property->purpose) }}
                                                </span>
                                            </div><!-- badges -->

                                            <div class="info">

                                                <h2 class="property-title">
                                                    {{ $property->title ?? ($property->purpose === 'sale' ? 'Property for sale' : 'Property for rent') }}
                                                </h2>

                                                <h3 class="property-location">
                                                    <span class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                            height="32" fill="#000000" viewBox="0 0 256 256">
                                                            <path
                                                                d="M200,224H150.54A266.56,266.56,0,0,0,174,200.25c27.45-31.57,42-64.85,42-96.25a88,88,0,0,0-176,0c0,31.4,14.51,64.68,42,96.25A266.56,266.56,0,0,0,105.46,224H56a8,8,0,0,0,0,16H200a8,8,0,0,0,0-16ZM56,104a72,72,0,0,1,144,0c0,57.23-55.47,105-72,118C111.47,209,56,161.23,56,104Zm112,0a40,40,0,1,0-40,40A40,40,0,0,0,168,104Zm-64,0a24,24,0,1,1,24,24A24,24,0,0,1,104,104Z">
                                                            </path>
                                                        </svg>
                                                    </span><!-- icon -->

                                                    <span>
                                                        {{ optional($property->neighborhood)->name ?? '' }}
                                                        @if (optional($property->neighborhood)->name && optional($property->city)->name)
                                                            ,
                                                        @endif
                                                        {{ optional($property->city)->name ?? '—' }}
                                                    </span>
                                                </h3>

                                                <h4 class="property-details">

                                                    <div class="d-inline-block">
                                                        <span class="icon icon-area">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="14px"
                                                                viewBox="0 -960 960 960" width="14px" fill="#e3e3e3">
                                                                <path
                                                                    d="M200-120q-33 0-56.5-23.5T120-200v-120q0-17 11.5-28.5T160-360q17 0 28.5 11.5T200-320v120h120q17 0 28.5 11.5T360-160q0 17-11.5 28.5T320-120H200Zm560 0H640q-17 0-28.5-11.5T600-160q0-17 11.5-28.5T640-200h120v-120q0-17 11.5-28.5T800-360q17 0 28.5 11.5T840-320v120q0 33-23.5 56.5T760-120ZM120-640v-120q0-33 23.5-56.5T200-840h120q17 0 28.5 11.5T360-800q0 17-11.5 28.5T320-760H200v120q0 17-11.5 28.5T160-600q-17 0-28.5-11.5T120-640Zm640 0v-120H640q-17 0-28.5-11.5T600-800q0-17 11.5-28.5T640-840h120q33 0 56.5 23.5T840-760v120q0 17-11.5 28.5T800-600q-17 0-28.5-11.5T760-640Z" />
                                                            </svg>
                                                        </span><!-- icon -->
                                                        <span>
                                                            {{ rtrim(rtrim(number_format((float) $property->area, 2, '.', ''), '0'), '.') }}
                                                            {{ __('main.property.square_meter') }}
                                                        </span>
                                                    </div><!-- Area -->

                                                    <span style="margin: 0px 2px;color:#aaaaaa7d;">|</span>

                                                    <div class="d-inline-block">
                                                        <span class="icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                                viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                                                <path
                                                                    d="M176-200h-30.3L126-280H80v-214q0-25.9 17-43.95Q114-556 140-556h26v-144q0-24.75 17.63-42.38Q201.25-760 226-760h507q24.75 0 42.38 17.62Q793-724.75 793-700v144h27q24.75 0 42.38 17.62Q880-520.75 880-496v216h-46l-19.78 80h-30.44L764-280H197l-21 80Zm334-356h223v-144H510v144Zm-284 0h224v-144H226v144Zm-86 216h680v-156H140v156Zm680 0H140h680Z" />
                                                            </svg>
                                                        </span><!-- icon -->
                                                        <span>{{ (int) $property->bedrooms }}
                                                            {{ __('main.property.bedroom') }}</span>
                                                    </div><!-- Bedroom -->

                                                    <span style="margin: 0px 2px;color:#aaaaaa7d;">|</span>

                                                    <div class="d-inline-block">
                                                        <span class="icon icon-bedroom">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" fill="#000000" viewBox="0 0 256 256">
                                                                <path
                                                                    d="M240,96H208a8,8,0,0,0-8-8H136a8,8,0,0,0-8,8H64V52A12,12,0,0,1,76,40a12.44,12.44,0,0,1,12.16,9.59,8,8,0,0,0,15.68-3.18A28.32,28.32,0,0,0,76,24,a28,28,0,0,0,48,52V96H16a8,8,0,0,0-8,8v40a56.06,56.06,0,0,0,56,56v16a8,8,0,0,0,16,0V200h96v16a8,8,0,0,0,16,0V200a56.06,56.06,0,0,0,56-56V104A8,8,0,0,0,240,96Zm-48,8v32H144V104Zm40,40a40,40,0,0,1-40,40H64a40,40,0,0,1-40-40V112H128v32a8,8,0,0,0,8,8h64a8,8,0,0,0,8-8V112h24Z">
                                                                </path>
                                                            </svg>
                                                        </span><!-- icon -->
                                                        <span>{{ (int) $property->bathrooms }}
                                                            {{ __('main.property.bathroom') }}</span>
                                                    </div><!-- Bathroom -->

                                                </h4>

                                                @if ($property->getPrice())
                                                    <p class="property-price mb-0 font-weight-600 ">

                                                        {{-- EN (LTR): show currency icon BEFORE the number --}}
                                                        @if (lang() == 'en')
                                                            {!! currency_icon() !!}
                                                        @endif

                                                        @if ($property->purpose == 'sale')
                                                            {{-- SALE price --}}
                                                            {{ number_format($property->sale_price) }}

                                                            {{-- AR (RTL): show currency icon AFTER the number --}}
                                                            @if (lang() == 'ar')
                                                                {!! currency_icon() !!}
                                                            @endif
                                                        @else
                                                            {{-- RENT price (monthly) --}}
                                                            {{ number_format($property->rent_price_monthly) }}

                                                            {{-- AR (RTL): show currency icon AFTER the number --}}
                                                            @if (lang() == 'ar')
                                                                {!! currency_icon() !!}
                                                            @endif

                                                            {{-- "/ per month" label (kept as-is) --}}
                                                            <span class="font-13">/
                                                                {{ __('main.property.per_month') }}</span>
                                                        @endif
                                                    </p><!-- price -->
                                                @endif

                                            </div><!-- info -->

                                        </div><!-- property-wrapper -->

                                        <div class="property-wrapper-bottom-overlay"></div>


                                    </article>
                                </a><!-- link -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="home-why-us" class="section-gap mb-0">
                <div class="container">

                    <div class="section-header text-center mb-5">
                        <h2 class="section-title">لماذا تختار <span style="color: #C9A227">أمكنة</span> ؟</h2>
                        <p class="section-subtitle">
                            نقدم تجربة عقارية متكاملة تجمع بين تنوع الخيارات، الأسعار التنافسية، والدعم الكامل حتى إتمام
                            التعاقد.
                        </p>
                    </div>

                    <div class="row g-4 justify-content-center">

                        {{-- خيارات تناسب الجميع --}}
                        <div class="col-lg-4 col-md-6">
                            <div class="why-us-card">

                                <div class="why-us-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-buildings">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 21v-15c0 -1 1 -2 2 -2h5c1 0 2 1 2 2v15" />
                                        <path d="M16 8h2c1 0 2 1 2 2v11" />
                                        <path d="M3 21h18" />
                                        <path d="M10 12v.01" />
                                        <path d="M10 16v.01" />
                                        <path d="M10 8v.01" />
                                        <path d="M7 12v.01" />
                                        <path d="M7 16v.01" />
                                        <path d="M7 8v.01" />
                                        <path d="M17 12v.01" />
                                        <path d="M17 16v.01" />
                                    </svg>
                                </div>

                                <h3 class="why-us-title">
                                    خيارات تناسب الجميع
                                </h3>

                                <p class="why-us-desc">
                                    استكشف مجموعة متنوعة من الشقق، الفلل، الدوبلكس، والمحلات في أفضل المواقع.
                                </p>

                            </div>
                        </div>

                        {{-- أسعار تنافسية --}}
                        <div class="col-lg-4 col-md-6">
                            <div class="why-us-card">

                                <div class="why-us-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none" />
                                        <path
                                            d="M240,186.79c-91.64,44.77-132.36-42.35-224,2.42v-120c91.64-44.77,132.36,42.35,224-2.42Z"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16" />
                                        <circle cx="128" cy="128" r="24" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="16" />
                                        <line x1="48" y1="96" x2="48" y2="144"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16" />
                                        <line x1="208" y1="112" x2="208" y2="160"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16" />
                                    </svg>
                                </div>

                                <h3 class="why-us-title">
                                    أسعار تنافسية
                                </h3>

                                <p class="why-us-desc">
                                    نوفر أفضل الفرص العقارية بأسعار تنافسية تناسب مختلف الميزانيات.
                                </p>

                            </div>
                        </div>

                        {{-- دعم حتى التعاقد --}}
                        <div class="col-lg-4 col-md-6">
                            <div class="why-us-card">

                                <div class="why-us-icon">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-headset"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 14v-3a8 8 0 1 1 16 0v3" /><path d="M18 19c0 1.657 -2.686 3 -6 3" /><path d="M4 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3" /><path d="M15 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3" /></svg>
                                </div>

                                <h3 class="why-us-title">
                                    دعم حتى التعاقد
                                </h3>

                                <p class="why-us-desc">
                                    نرافقك في جميع مراحل الشراء ونقدم لك الاستشارة والدعم حتى إتمام التعاقد.
                                </p>

                            </div>
                        </div>

                    </div>

                </div>
            </section>

        </div>

    </main>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $(document).on('click', '.home-purpose-btn', function() {
                $('.home-purpose-btn').removeClass('active');
                $(this).addClass('active');
                $('.home-selected-purpose').val($(this).data('purpose'));
            });


            ////////////////////////////////////////
            ////////////////////////////////////////
            ////////////////////////////////////////
            ////////////////////////////////////////
            ////////////////////////////////////////

            // Common Swiper Configuration
            const swiperConfig = {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                breakpoints: {
                    480: {
                        slidesPerView: 1,
                        spaceBetween: 15,
                    },
                    576: {
                        slidesPerView: 2,
                        spaceBetween: 15,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 20,
                    },
                },
            };

            // Initialize Most Viewed Swiper (3 ثواني)
            new Swiper('.swiper-most-viewed', {
                ...swiperConfig,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination-viewed',
                    clickable: true,
                },
            });

            // Initialize Rent Swiper (4.5 ثانية)
            new Swiper('.swiper-rent', {
                ...swiperConfig,
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination-rent',
                    clickable: true,
                },
            });

            // Initialize Sale Swiper (5 ثواني)
            new Swiper('.swiper-sale', {
                ...swiperConfig,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination-sale',
                    clickable: true,
                },
            });

            // Initialize Neighborhoods Swiper
            new Swiper('.swiper-neighborhoods', {
                ...swiperConfig,
                slidesPerView: 1.3,
                breakpoints: {
                    480: {
                        slidesPerView: 1.3,
                        spaceBetween: 15,
                    },
                    576: {
                        slidesPerView: 2.3,
                        spaceBetween: 15,
                    },
                    768: {
                        slidesPerView: 2.3,
                        spaceBetween: 20,
                    },
                    992: {
                        slidesPerView: 3.3,
                        spaceBetween: 20,
                    },
                    1200: {
                        slidesPerView: 5.3,
                        spaceBetween: 20,
                    },
                },
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next-neighborhoods',
                    prevEl: '.swiper-button-prev-neighborhoods',
                },
            });
        });
    </script>
@endsection

{{-- <x-js :links="[
    ['from' => 'plugins', 'link' => 'owl-carousel/owl.carousel.min.js'],
    ['from' => 'pages', 'link' => 'home/home.js'],
]" /> --}}

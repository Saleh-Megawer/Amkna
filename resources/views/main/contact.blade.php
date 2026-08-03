@section('title', __('main.contact.meta_title'))
@section('description', __('main.contact.meta_desc', ['app_name' => __('main.app_name')]))
@section('head')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@extends('main.layouts.master')
@section('body-class', 'contact-body')
@section('content')

    <main id="contact-me" role="main" aria-labelledby="contact-me-title" itemscope itemtype="https://schema.org/ContactPage">

        <!-- Hero Section -->
        <header class="contact-hero mt-space-navbar" role="banner">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center position-relative">
                        <span class="section-badge">{{ __('main.contact.sub_title') }}</span>
                        <h1 class="contact-hero__title text-white mb-3 font-weight-bold">
                            {{ __('main.contact.title') }}
                        </h1>
                        <p class="contact-hero__desc text-white mb-0">
                            {{ __('main.contact.desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Contact Section -->
        <section class="contact-section py-5">
            <div class="container">
                <div class="row">

                    <!-- Contact Methods -->
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="contact-card ">
                            <h3 class="contact-card__title mb-4 font-weight-600">
                                {{ __('main.contact.get_in_touch') }}
                            </h3>

                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?phone={{ $phone }}" target="_blank"
                                class="contact-link" aria-label="{{ __('main.contact.whatsapp_aria') }}">
                                <div class="contact-method">
                                    <div class="d-flex align-items-center">
                                        <div class="contact-icon contact-icon--green">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                <path
                                                    d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
                                            </svg>
                                        </div>
                                        <div class="contact-method__info px-3">
                                            <small class="text-muted d-block">{{ __('main.contact.whatsapp') }}</small>
                                            <h5 class="mb-0 font-weight-600">{{ __('main.contact.chat_now') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <!-- Phone -->
                            <a href="tel:+{{ $phone }}" class="contact-link"
                                aria-label="{{ __('main.contact.phone_aria') }}">
                                <div class="contact-method">
                                    <div class="d-flex align-items-center">
                                        <div class="contact-icon contact-icon--blue">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                <path
                                                    d="M222.37,158.46l-47.11-21.11-.13-.06a16,16,0,0,0-15.17,1.4,8.12,8.12,0,0,0-.75.56L134.87,160c-15.42-7.49-31.34-23.29-38.83-38.51l20.78-24.71c.2-.25.39-.5.57-.77a16,16,0,0,0,1.32-15.06l0-.12L97.54,33.64a16,16,0,0,0-16.62-9.52A56.26,56.26,0,0,0,32,80c0,79.4,64.6,144,144,144a56.26,56.26,0,0,0,55.88-48.92A16,16,0,0,0,222.37,158.46ZM176,208A128.14,128.14,0,0,1,48,80,40.2,40.2,0,0,1,82.87,40a.61.61,0,0,0,0,.12l21,47L83.2,111.86a6.13,6.13,0,0,0-.57.77,16,16,0,0,0-1,15.7c9.06,18.53,27.73,37.06,46.46,46.11a16,16,0,0,0,15.75-1.14,8.44,8.44,0,0,0,.74-.56L168.89,152l47,21.05h0s.08,0,.11,0A40.21,40.21,0,0,1,176,208Z" />
                                            </svg>
                                        </div>
                                        <div class="contact-method__info px-3">
                                            <small class="text-muted d-block">{{ __('main.contact.phone') }}</small>
                                            <h5 class="mb-0 font-weight-600">+{{ $phone }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <!-- Email -->
                            <a href="mailto:{{ $email }}" class="contact-link"
                                aria-label="{{ __('main.contact.email_aria') }}">
                                <div class="contact-method">
                                    <div class="d-flex align-items-center">
                                        <div class="contact-icon contact-icon--orange">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                <path
                                                    d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48ZM203.43,64,128,133.15,52.57,64ZM216,192H40V74.19l82.59,75.71a8,8,0,0,0,10.82,0L216,74.19V192Z" />
                                            </svg>
                                        </div>
                                        <div class="contact-method__info px-3">
                                            <small class="text-muted d-block">{{ __('main.contact.email') }}</small>
                                            <h5 class="mb-0 font-weight-600 contact-method__email">{{ $email }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-lg-8">
                        <div class="contact-card">
                            <h3 class="contact-card__title mb-4 font-weight-600">
                                {{ __('main.contact.send_message') }}
                            </h3>

                            <form id="contactForm" class="form contact-form" action="{{ route('main.contact.store') }}"
                                method="post" role="form">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'text',
                                                'name' => 'name',
                                                'options' => [
                                                    'placeholder' => __('main.contact.name_placeholder'),
                                                    'aria-label' => __('main.contact.name_placeholder'),
                                                    'required' => true,
                                                ],
                                            ],
                                            'label' => [
                                                'text' => __('main.contact.name'),
                                                'options' => [
                                                    'class' => 'required font-weight-500',
                                                ],
                                            ],
                                        ]" /> <!-- name -->
                                    </div>

                                    <div class="col-md-6">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'email',
                                                'name' => 'email',
                                                'options' => [
                                                    'placeholder' => __('main.contact.email_placeholder'),
                                                    'aria-label' => __('main.contact.email_placeholder'),
                                                    'required' => true,
                                                ],
                                            ],
                                            'label' => [
                                                'text' => __('main.contact.email'),
                                                'options' => [
                                                    'class' => 'required font-weight-500',
                                                ],
                                            ],
                                        ]" />
                                    </div><!-- Your Email -->

                                    <div class="col-md-6">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'tel',
                                                'name' => 'phone',
                                                'options' => [
                                                    'placeholder' => __('main.contact.phone_placeholder'),
                                                    'aria-label' => __('main.contact.phone_placeholder'),
                                                    'class' => lang() == 'ar' ? 'text-right' : null,
                                                ],
                                            ],
                                            'label' => [
                                                'text' => __('main.contact.phone'),
                                                'options' => [
                                                    'class' => 'required font-weight-500',
                                                ],
                                            ],
                                        ]" /> <!-- phone -->
                                    </div><!-- Your Phone -->

                                    <div class="col-md-6">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'text',
                                                'name' => 'subject',
                                                'options' => [
                                                    'placeholder' => __('main.contact.subject_placeholder'),
                                                    'aria-label' => __('main.contact.subject_placeholder'),
                                                ],
                                            ],
                                            'label' => [
                                                'text' => __('main.contact.subject'),
                                                'options' => [
                                                    'class' => 'required font-weight-500',
                                                ],
                                            ],
                                        ]" /> <!-- subject -->
                                    </div><!-- Subject -->

                                    <div class="col-12">
                                        <x-form-group :properties="[
                                            'textarea' => [
                                                'name' => 'message',
                                                'options' => [
                                                    'placeholder' => __('main.contact.message_placeholder'),
                                                    'rows' => 5,
                                                    'aria-label' => __('main.contact.message_placeholder'),
                                                    'required' => true,
                                                ],
                                            ],
                                            'label' => [
                                                'text' => __('main.contact.message'),
                                                'options' => [
                                                    'class' => 'required font-weight-500',
                                                ],
                                            ],
                                        ]" />
                                    </div><!-- message -->
                                </div>

                                <div class=" d-flex justify-content-start">
                                    <div class="g-recaptcha" data-sitekey="6Lf-UIIsAAAAAEu4O7EIfU-uZhKFQHukChnwuU3s">
                                    </div>
                                </div>

                                <button type="submit"
                                    class="btn btn-second mt-3 px-5 {{ lang() == 'ar' ? 'float-left' : 'float-right' }}"
                                    aria-label="{{ __('main.contact.send_btn') }}">
                                    <span>{{ __('main.contact.send_btn') }}</span>
                                </button>

                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        @if ($googleMapIframe)
            <!-- Map & Address Section -->
            <section class="location-section py-5 bg-white">
                <div class="container">
                    <div class="row align-items-center">

                        {{-- <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="address-box" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                            <h4 class="address-box__title">{{ __('main.contact.our_location') }}</h4>
                            <p class="address-box__text" itemprop="streetAddress">
                                {{ $address ?? __('main.contact.default_address') }}
                            </p>
                            <p class="address-box__text">
                                <span itemprop="addressLocality">{{ $city ?? __('main.contact.default_city') }}</span>,
                               <span itemprop="addressCountry">{{ __('main.contact.country') }}</span> 
                            </p>
                         <p class="address-box__text" itemprop="postalCode">{{ $postal_code ?? '11511' }}</p> 
                        </div>
                    
                        <div class="working-hours">
                            <p class="working-hours__text text-muted">
                                <strong>{{ __('main.contact.working_hours') }}:</strong><br>
                                {{ __('main.contact.saturday_thursday') }}: 9:00 {{ __('main.contact.am') }} - 6:00
                                {{ __('main.contact.pm') }}<br>
                                {{ __('main.contact.friday') }}: {{ __('main.contact.closed') }}
                            </p>
                        </div>
                      
                    </div> --}}

                        <div class="col-lg-12">
                            <div class="map-container">
                                {!! $googleMapIframe !!}
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        @endif

    </main>

@endsection

@section('js')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

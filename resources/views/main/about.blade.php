@section('title', __('about.meta.title'))
@section('description', __('about.meta.description'))
@section('image', asset('images/about/sahd-og-image.jpg'))
@section('image-type', 'jpg')
@extends('main.layouts.master')

@section('content')

    {{-- Hero Section --}}
    <section class="about-hero-section position-relative overflow-hidden">
        <div class="hero-bg-gradient"></div>
        <div class="hero-pattern-overlay"></div>
        <div class="container position-relative">
            <div class="row align-items-center min-vh-100 py-5">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-up">
                    <span class="badge-modern mb-3">{{ __('about.hero.badge') }}</span>
                    <h1 class="display-3 font-weight-bold mb-4 hero-title">
                        {{ __('about.hero.title_part1') }}
                        <span class="text-accent d-block position-relative">
                            {{ __('about.hero.title_accent') }}
                            <span class="title-underline"></span>
                        </span>
                        {{ __('about.hero.title_part2') }}
                    </h1>
                    <p class="lead text-dark-gray mb-4">
                        {{ __('about.hero.description') }}
                    </p>
                    <div class="d-flex align-items-center flex-wrap hero-stats-wrapper">
                        <div class="stat-box">
                            <h3 class="text-accent font-weight-bold mb-0">+5K</h3>
                            <small class="text-muted">{{ __('about.hero.stats.properties') }}</small>
                        </div>
                        <div class="stat-box">
                            <h3 class="text-accent font-weight-bold mb-0">+12K</h3>
                            <small class="text-muted">{{ __('about.hero.stats.clients') }}</small>
                        </div>
                        <div class="stat-box">
                            <h3 class="text-accent font-weight-bold mb-0">98%</h3>
                            <small class="text-muted">{{ __('about.hero.stats.satisfaction') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="hero-image-wrapper position-relative">
                        <div class="image-accent-border"></div>
                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&h=600&fit=crop"
                            alt="{{ __('about.hero.image_alt_1') }}" class="img-fluid rounded-modern shadow-modern">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Story Timeline Section --}}
    <section class="story-section bg-gradient-light">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <span class="badge-outline-accent mb-3">{{ __('about.story.subtitle') }}</span>
                    <h2 class="display-4 font-weight-bold mb-4">
                        {{ __('about.story.title_part1') }}
                        <span class="text-accent">{{ __('about.story.title_accent') }}</span>
                    </h2>
                    <p class="lead text-dark-gray">
                        {{ __('about.story.description') }}
                    </p>
                </div>
            </div>

            <div class="timeline-modern">
                @foreach (__('about.story.timeline') as $index => $item)
                    <div class="timeline-item-modern {{ $loop->last ? 'mb-0' : 'mb-5' }}"
                        data-aos="fade-{{ $index % 2 == 0 ? 'right' : 'left' }}">
                        <div class="row align-items-center {{ $index % 2 == 0 ? '' : 'flex-row-reverse' }}">
                            <div class="col-md-5 mb-3 mb-md-0">
                                <div class="timeline-card">
                                    <h4 class="text-accent font-weight-bold mb-3">{{ $item['year'] }}</h4>
                                    <p class="text-dark-gray mb-0">{{ $item['text'] }}</p>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="timeline-icon-modern">
                                    {!! $item['icon'] !!}
                                </div>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Mission & Vision Section --}}
    <section class="mission-vision-section py-5 bg-white">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-up">
                    <div class="modern-card h-100">
                        <div class="card-image-wrapper">
                            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=600&fit=crop"
                                alt="{{ __('about.mission.image_alt') }}" class="card-image">
                            <div class="card-gradient-overlay"></div>
                        </div>
                        <div class="card-content-modern">
                            <div class="icon-modern mb-4">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="font-weight-bold mb-3">{{ __('about.mission.title') }}</h3>
                            <p class="mb-3">{{ __('about.mission.description') }}</p>
                            <ul class="list-modern">
                                @foreach (__('about.mission.points') as $point)
                                    <li>
                                        <svg class="check-icon-modern" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="modern-card h-100">
                        <div class="card-image-wrapper">
                            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&h=600&fit=crop"
                                alt="{{ __('about.vision.image_alt') }}" class="card-image">
                            <div class="card-gradient-overlay"></div>
                        </div>
                        <div class="card-content-modern">
                            <div class="icon-modern mb-4">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <h3 class="font-weight-bold mb-3">{{ __('about.vision.title') }}</h3>
                            <p class="mb-3">{{ __('about.vision.description') }}</p>
                            <ul class="list-modern">
                                @foreach (__('about.vision.points') as $point)
                                    <li>
                                        <svg class="check-icon-modern" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Values Section --}}
    <section class="values-section py-5 bg-gradient-light">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <span class="badge-outline-accent mb-3">{{ __('about.values.subtitle') }}</span>
                    <h2 class="display-4 font-weight-bold mb-4">
                        {{ __('about.values.title_part1') }}
                        <span class="text-accent">{{ __('about.values.title_accent') }}</span>
                    </h2>
                    <p class="lead text-dark-gray">
                        {{ __('about.values.description') }}
                    </p>
                </div>
            </div>

            <div class="row">
                @php
                    $valueSvgs = [
                        '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
                        '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>',
                        '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>',
                        '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/></svg>',
                    ];
                @endphp

                @foreach (__('about.values.items') as $index => $value)
                    <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="value-card-modern">
                            <div class="value-icon-modern">
                                {!! $valueSvgs[$index] !!}
                            </div>
                            <h5 class="font-weight-bold mb-3">{{ $value['title'] }}</h5>
                            <p class="text-dark-gray small mb-0">{{ $value['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Statistics Counter Section --}}
    <section class="stats-modern-section position-relative overflow-hidden">
        <div class="stats-gradient-overlay"></div>
        <div class="stats-pattern"></div>
        <div class="container py-5 position-relative">
            <div class="row text-center">
                @php
                    $statSvgs = [
                        '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
                        '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                        '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                        '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>',
                    ];
                @endphp

                @foreach (__('about.stats.items') as $index => $stat)
                    <div class="col-6 col-lg-3 mb-4 mb-lg-0" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                        <div class="stat-modern-item">
                            <div class="stat-icon-modern">
                                {!! $statSvgs[$index] !!}
                            </div>
                            <h2 class="display-4 text-accent font-weight-bold mb-2" data-count="{{ $stat['count'] }}">0
                            </h2>
                            <h6 class="font-weight-bold mb-1 text-white">{{ $stat['label'] }}</h6>
                            <small class="text-light-gray">{{ $stat['sublabel'] }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Why Choose Us Section --}}
    <section class="why-choose-modern py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                    <div class="position-relative">
                        <div class="image-decoration"></div>
                        <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=700&h=800&fit=crop"
                            alt="{{ __('about.why_choose.image_alt') }}"
                            class="img-fluid rounded-modern shadow-modern position-relative">
                        <div class="rating-badge-modern">
                            <span class="badge-star">★</span>
                            <span class="badge-number">5.0</span>
                            <small>{{ __('about.why_choose.badge_text') }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                    <span class="badge-outline-accent mb-3">{{ __('about.why_choose.subtitle') }}</span>
                    <h2 class="display-4 font-weight-bold mb-4">
                        {{ __('about.why_choose.title_part1') }}
                        <span class="text-accent">{{ __('about.why_choose.title_accent') }}</span>
                    </h2>
                    <p class="lead text-dark-gray mb-4">
                        {{ __('about.why_choose.description') }}
                    </p>

                    <div class="features-modern-list">
                        @php
                            $featureSvgs = [
                                '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>',
                                '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
                                '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                                '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>',
                            ];
                        @endphp

                        @foreach (__('about.why_choose.features') as $index => $feature)
                            <div class="feature-modern-card">
                                <div class="feature-icon-modern">
                                    {!! $featureSvgs[$index] !!}
                                </div>
                                <div class="feature-content-modern">
                                    <h6 class="font-weight-bold mb-1">{{ $feature['title'] }}</h6>
                                    <p class="text-dark-gray small mb-0">{{ $feature['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="cta-modern-section">
        <div class="cta-gradient-bg"></div>
        <div class="container py-5 position-relative">
            <div class="cta-card-modern" data-aos="zoom-in">
                <div class="row align-items-center">
                    <div
                        class="col-lg-8 mb-4 mb-lg-0 text-center text-lg-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                        <h2 class="display-4 font-weight-bold mb-3 text-white">{{ __('about.cta.title') }}</h2>
                        <p class="lead text-light-gray mb-0">{{ __('about.cta.description') }}</p>
                    </div>
                    <div class="col-lg-4 text-center text-lg-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                        <a href="{{ url('/properties') }}" class="btn btn-modern-primary btn-lg btn-block mb-3">
                            <svg class="btn-icon {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            {{ __('about.cta.button_properties') }}
                        </a>
                        <a href="{{ url('/contact') }}" class="btn btn-modern-outline btn-lg btn-block">
                            <svg class="btn-icon {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ __('about.cta.button_contact') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out-cubic',
            once: true,
            offset: 100
        });

        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-count'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;
            const isArabic = document.documentElement.lang === 'ar';

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    const formattedNumber = isArabic ? target.toLocaleString('ar-EG') : target.toLocaleString(
                        'en-US');
                    element.textContent = formattedNumber + (element.nextElementSibling.textContent.includes('%') ?
                        '' : '+');
                    clearInterval(timer);
                } else {
                    const formattedNumber = isArabic ? Math.floor(current).toLocaleString('ar-EG') : Math.floor(
                        current).toLocaleString('en-US');
                    element.textContent = formattedNumber;
                }
            }, 16);
        }

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                    entry.target.classList.add('counted');
                    animateCounter(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        document.querySelectorAll('[data-count]').forEach(counter => {
            counterObserver.observe(counter);
        });
    </script>
@endsection

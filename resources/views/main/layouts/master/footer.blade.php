@if (!isset($footerOptions['hide']))

    <footer class="main-footer">
        <!-- Main Footer Content -->
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <!-- Company Info -->
                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                        <div class="footer-brand">
                            <a href="{{ appUrl('') }}">
                                <img src="{{ largeAsset('settings/' . setting('footer_logo')) }}"
                                    alt="{{ config('app.name') }}" class="footer-logo" alt="{{ __('main.app_name') }}"
                                    title="{{ __('main.app_name') }}">
                            </a>
                            <p class="footer-description">
                                {{ __('main.footer.description') }}
                            </p>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                        <h5 class="footer-heading">{{ __('main.footer.quick_links') }}</h5>
                        <ul class="footer-links">
                            <li><a
                                    href="{{ route('main.properties.index') }}">{{ __('main.footer.all_properties') }}</a>
                            </li>
                            <li><a
                                    href="{{ route('main.properties.index') }}?purpose=sale">{{ __('main.footer.for_sale') }}</a>
                            </li>
                            <li><a
                                    href="{{ route('main.properties.index') }}?purpose=rent">{{ __('main.footer.for_rent') }}</a>
                            </li>
                            <li><a href="{{ route('main.about-us') }}">{{ __('main.footer.about_us') }}</a></li>
                            <li><a href="{{ appUrl('faqs') }}">{{ __('main.footer.faqs') }}</a></li>
                        </ul>
                    </div>

                    <!-- Support Links -->
                    <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                        <h5 class="footer-heading">{{ __('main.footer.support') }}</h5>
                        <ul class="footer-links">
                            <li><a href="{{ appUrl('contact') }}">{{ __('main.footer.contact') }}</a></li>
                            <li><a href="{{ appUrl('privacy-policy') }}">{{ __('main.footer.privacy_policy') }}</a>
                            </li>

                            <li><a href=""> أعلن عن عقارك</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#joinMarketerModal">انضم كمسوق</a></li>

                            {{-- <li><a href="{{ appUrl('login') }}">{{ __('main.footer.login') }}</a></li>
                            <li><a href="{{ appUrl('register') }}">{{ __('main.footer.register') }}</a></li> --}}
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                        <h5 class="footer-heading">{{ __('main.footer.contact_us') }}</h5>

                        <ul style="direction: ltr" class="footer-contact">
                            @if (setting('contact.phone'))
                                <!-- Phone -->
                                @foreach (explode('|', setting('contact.phone')) as $phoneRow)
                                    <li class="contact-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                        </svg>
                                        <a href="tel:+{{ $phoneRow }}" dir="ltr">+{{ $phoneRow }}</a>
                                    </li>
                                @endforeach
                            @endif

                            <!-- Email -->
                            @if (setting('contact.email'))
                                @foreach (explode('|', setting('contact.email')) as $emailRow)
                                    <li class="contact-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path
                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                            <polyline points="22,6 12,13 2,6" />
                                        </svg>
                                        <a href="mailto:{{ $emailRow }}">{{ $emailRow }}</a>
                                    </li>
                                @endforeach
                            @endif

                        </ul>


                        <!-- Newsletter -->
                        {{-- <div class="footer-newsletter mt-4">
                            <h6 class="mb-2">{{ __('main.footer.newsletter') }}</h6>
                            <form class="newsletter-form" method="POST" action="">
                                @csrf
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="{{ __('main.footer.email_placeholder') }}" required>
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="22" y1="2" x2="11" y2="13" />
                                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div> --}}
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                        <!-- Social Links -->
                        <div class="footer-social">
                            <h6 class="mb-3">{{ __('main.footer.follow_us') }}</h6>
                            <ul class="social-links">
                                @foreach (mainViewSocialMedia() as $key => $val)
                                    @php $valName = $val['name_en']; @endphp
                                    @if (!empty(setting('social.' . $valName)))
                                        <li>
                                            <a href="{{ setting('social.' . $valName) }}" target="_blank"
                                                aria-label="{{ $val['name_en'] }}">
                                                {!! $val['icon'] !!}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">

                <div class="mb-2 mb-md-0 text-center">
                    <p class="mb-0">
                        {{ __('main.footer.rights') }}
                        <a href="{{ appUrl('') }}">{{ __('main.app_name') }}</a>
                        {{ date('Y') }}©.
                    </p>
                </div>

            </div>
        </div>
    </footer>
@endif

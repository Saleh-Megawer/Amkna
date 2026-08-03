@if ($options['show'])

    <header class="main-header fixed-top">
        <div class="{{ $options['full_width'] == false ? 'container-fluid' : 'px-3' }} ">
            <nav class="navbar navbar-expand-lg main-navbar px-0">

                <!-- Logo -->
                <a class="navbar-brand  d-flex align-items-center" href="{{ appUrl('') }}">
                    <img src="{{ website_logo() }}" alt="{{ __('main.app_name') }}" title="{{ __('main.app_name') }}"
                        class="logo">
                </a>

                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

                        <a class="nav-link theme" href="{{ route('main.properties.index') }}">
                            {{ __('navbar.all_properties') }}
                        </a>

                        <a class="nav-link theme" href="{{ route('main.properties.index') }}?purpose=sale">
                            {{ __('navbar.for_sale') }}
                        </a>

                        <a class="nav-link theme" href="{{ route('main.properties.index') }}?purpose=rent">
                            {{ __('navbar.for_rent') }}
                        </a>

                        {{-- 
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('main.about-us') }}">About Us</a>
                        </li> --}}

                        <li id="nav-drop" class="nav-item dropdown">
                            <a class="nav-link theme dropdown-toggle" href="#" id="dropdownId"
                                data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">{{ __('navbar.explore') }}</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                {{-- <a class="dropdown-item"
                                    href="{{ url('en/about-us') }}">{{ __('navbar.about_us') }}</a> --}}
                                <a class="dropdown-item"
                                    href="{{ route('main.contact-us') }}">{{ __('navbar.contact_us') }}</a>
                                <a class="dropdown-item" href="{{ route('main.faqs') }}">{{ __('navbar.faqs') }}</a>
                                <a class="dropdown-item"
                                    href="{{ route('main.privacy-policy') }}">{{ __('navbar.privacy_policy') }}</a>
                            </div>
                        </li>


                        <a class="nav-link theme" href="#" data-toggle="modal" data-target="#joinMarketerModal">
                            {{ __('navbar.join_as_marketer') }}
                        </a>


                    </ul>
                </div>

                {{-- @if (!$options['hide_search'])
                    <!-- Center search -->
                    <form class="search-form mx-auto w-100" action="{{ route('main.properties.index') }}">
                        <div class="form-group m-0">
                            <input type="text" class="form-control search-input"
                                placeholder="{{ __('navbar.search_placeholder') }}">
                            <div class="icon-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </div>
                        </div>
                    </form>
                @else
                    <!-- set the space if form search removed -->
                    <div class="mx-auto w-100 d-none d-lg-block"></div>
                @endif --}}


                <!-- set the space if form search removed -->
                <div class="mx-auto w-100 d-none d-lg-block"></div>

                <!-- Right icons -->
                <ul class="ul-icons navbar-nav flex-row align-items-center">


                    <!-- Account -->
                    <li class="nav-item tip" title="دعم العملاء">
                        <a class="nav-link d-flex flex-column align-items-center" href="{{ appUrl('login') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-headset">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 14v-3a8 8 0 1 1 16 0v3" />
                                <path d="M18 19c0 1.657 -2.686 3 -6 3" />
                                <path d="M4 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3" />
                                <path
                                    d="M15 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3" />
                            </svg>
                            {{-- <span class="nav-label">{{ __('navbar.account') }}</span> --}}
                        </a>
                    </li>
                   

                    <li class="nav-item mr-2 tip d-block d-lg-none " title="أعلن عن عقارك">
                        <a class="nav-link d-flex flex-column align-items-center" href="{{ appUrl('login') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </a>
                    </li>

                    <li class="nav-item btn-advertise-your-property d-none d-lg-block">
                        <a class="nav-link d-flex align-items-center" href="{{ appUrl('login') }}">
                            <span class="nav-label">أعلن عن عقارك</span>
                        </a>
                    </li>

                    {{-- <!-- Language -->
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column align-items-center" href="{{ urlSwitchLang() }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-world">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M3.6 9h16.8" />
                                <path d="M3.6 15h16.8" />
                                <path d="M11.5 3a17 17 0 0 0 0 18" />
                                <path d="M12.5 3a17 17 0 0 1 0 18" />
                            </svg>
                            <span class="nav-label">
                                @if (lang() == 'ar')
                                    الإنجليزية
                                @else
                                    Arabic
                                @endif
                            </span>
                        </a>
                    </li>

                    <!-- Account -->
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column align-items-center" href="{{ appUrl('login') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                            </svg>
                            <span class="nav-label">{{ __('navbar.account') }}</span>
                        </a>
                    </li> --}}

                    <!-- Toggler Button -->
                    <li class="nav-item d-lg-none">
                        <button class="navbar-toggler mr-3" type="button" data-toggle="collapse"
                            data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 6l16 0" />
                                <path d="M4 12l16 0" />
                                <path d="M4 18l16 0" />
                            </svg>
                        </button>
                    </li>

                </ul>

            </nav>
        </div>
    </header>

    <div class="modal fade" id="joinMarketerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('register_marketer.modal_title') }}
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">

                    <div class="join-marketer-box mb-4">

                        <div class="d-flex align-items-center mb-1">

                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="{{ lang() == 'ar' ? 'ml-1' : 'mr-1' }} text-primary">

                                <path d="M12 3l1.9 4.9L19 10l-5.1 2.1L12 17l-1.9-4.9L5 10l5.1-2.1L12 3z"></path>

                            </svg>

                            <strong>
                                {{ __('register_marketer.headline') }}
                            </strong>

                        </div><!--  -->

                        <p @style(lang() == 'ar' ? 'margin-right:30px;' : 'margin-left:30px;') class="text-muted mb-0" style="font-size:14px;">
                            {{ __('register_marketer.description') }}
                        </p>

                    </div><!-- join-marketer-box -->


                    <form class="form" action="{{ route('main.register-marketer') }}" method="POST">
                        @csrf

                        <div class="form-row">

                            <div class="col-6">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'f_name',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => __('register_marketer.f_name'),
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div><!--  -->

                            <div class="col-6">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'l_name',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => __('register_marketer.l_name'),
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div><!--  -->

                            <div class="col-12">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'email',
                                        'type' => 'email',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => __('register_marketer.email'),
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div><!--  -->

                            <div class="form-row w-100">

                                <div class="col-12">
                                    <label>
                                        {{ __('client.register.form.phone') }}
                                    </label>
                                </div>

                                <div class="col-xl-3 col-md-4 col-5">
                                    <div class="input-flags">

                                        <select name="country_code" class="country-select">

                                            @foreach ($globalPhoneData['countries'] as $country)
                                                <option @selected(old('country_code') == $country['code']) value="{{ $country['code'] }}"
                                                    data-flag="{{ $country['flag'] }}">
                                                    {{ $country['code'] }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>


                                <div class="col-xl-9 col-md-8 col-7">

                                    <x-form-group :properties="[
                                        'input' => [
                                            'type' => 'phone',
                                            'name' => 'phone',
                                            'value' => '',
                                            'options' => [
                                                'required',
                                                'placeholder' => __('client.register.form.phone_number'),
                                            ],
                                        ],
                                    ]" />

                                </div>

                            </div><!--  -->

                            <div class="col-12">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'marketing_license',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => __('register_marketer.marketing_license'),
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div><!--  -->

                        </div>

                        <button type="submit" class="btn btn-second btn-block">

                            {{ __('register_marketer.submit') }}

                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@else
    <style>
        body {
            padding-top: 0;
        }
    </style>
@endif

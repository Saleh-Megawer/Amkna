@extends('main.layouts.master')
@section('title', $pageTitle)
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')


    <section id="customers">
        <div class="container mb-5">
            <div class="row">

                <div class="col-12">
                    <h1 class="page-title">{{ $pageTitle }}</h1>
                </div><!-- page title -->

                @include('clients.includes.aside')

                <div class="col-lg-9 col-md-12 ">
                    <div id="register">

                        <form class="form" action="{{ route('main.clients.profile.update') }}" method="POST">

                            <x-panel-with-heading title="{{ __('client.profile.personal_info') }}">

                                @csrf


                                <div class="form-row">

                                    <div class="col-md-4">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'text',
                                                'name' => 'name',
                                                'value' => clientAuth('name'),
                                                'options' => [
                                                    'required',
                                                    'maxlength' => 45,
                                                    'placeholder' => __('client.profile.name_placeholder'),
                                                ],
                                            ],
                                            'label' => [
                                                'text' => __('client.profile.name'),
                                            ],
                                        ]" />
                                    </div><!-- name -->

                                    <div class="col-md-4">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'email',
                                                'name' => 'email',
                                                'value' => clientAuth('email'),
                                                'options' => ['required'],
                                            ],
                                            'label' => [
                                                'text' => __('client.profile.email'),
                                            ],
                                        ]" />
                                    </div><!-- email -->

                                    <div class="col-md-4">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'date',
                                                'name' => 'birth_date',
                                                'value' => clientAuth('birth_date'),
                                            ],
                                            'label' => [
                                                'text' => __('client.profile.birth_date'),
                                            ],
                                        ]" />
                                    </div>{{-- Date of Birth --}}

                                    <div class="col-md-4">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'number',
                                                'name' => 'national_id',
                                                'value' => clientAuth('national_id'),
                                                'options' => [
                                                    'maxlength' => 20,
                                                    'placeholder' => __('client.profile.national_id_placeholder'),
                                                ],
                                            ],
                                            'label' => [
                                                'text' => __('client.profile.national_id'),
                                            ],
                                        ]" />
                                    </div> {{-- National ID --}}

                                    <div class="col-md-8">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'text',
                                                'name' => 'national_address',
                                                'value' => clientAuth('national_address'),
                                                'options' => [
                                                    'maxlength' => 255,
                                                    'placeholder' => __('client.profile.national_address_placeholder'),
                                                ],
                                            ],
                                            'label' => [
                                                'text' => __('client.profile.national_address'),
                                            ],
                                        ]" />
                                    </div>{{-- National Address --}}

                                    <div class="col-12">
                                        <label for="">{{ __('client.profile.phone') }}</label>
                                    </div>

                                    <div class="col-sm-2 col-3">
                                        <div class="input-flags">
                                            <select name="country_code" class="country-select">
                                                @foreach ($globalPhoneData['countries'] as $country)
                                                    <option value="{{ $country['code'] }}"
                                                        data-flag="{{ $country['flag'] }}" @selected($country['code'] == clientAuth('country_code'))>
                                                        {{ $country['code'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-10 col-9">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'number',
                                                'value' => clientAuth('phone'),
                                                'name' => 'phone',
                                                'options' => [
                                                    'required',
                                                    'placeholder' => __('client.profile.phone_number'),
                                                ],
                                            ],
                                        ]" />
                                    </div><!-- phone -->



                                </div>

                                <div class="mt-3 mt-md-0"></div>
                                <button type="submit"
                                    class="btn btn-second float-right mb-0 px-5">{{ __('client.update') }}</button>
                                <div class="clearfix"></div>

                            </x-panel-with-heading>

                        </form><!-- end form -->


                        <form class="form" action="{{ route('main.clients.profile.update_password') }}" method="POST">

                            <x-panel-with-heading title="{{ __('client.profile.update_password') }}">

                                @csrf

                                <div class="form-row">
                                    <div class="col-sm-4">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'password',
                                                'name' => 'current_password',
                                                'options' => ['required'],
                                            ],
                                            'label' => [
                                                'text' => __('client.profile.current_password'),
                                            ],
                                        ]" /> <!-- current password -->
                                    </div><!--  -->

                                    <div class="col-sm-4">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'password',
                                                'name' => 'password',
                                                'options' => ['required'],
                                            ],
                                            'label' => [
                                                'text' => __('client.profile.new_password'),
                                            ],
                                        ]" /> <!-- new password -->
                                    </div><!--  -->

                                    <div class="col-sm-4">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'type' => 'password',
                                                'name' => 'password_confirmation',
                                                'options' => ['required'],
                                            ],
                                            'label' => [
                                                'text' => __('client.profile.confirm_password'),
                                            ],
                                        ]" /> <!-- confirm password -->
                                    </div><!--  -->

                                </div><!-- row -->

                                <div class="mt-3 mt-md-0"></div>


                                <div style="direction: ltr" class="float-right">

                                    <button title="{{ __('client.profile.show_hide_passwords') }}" type="button"
                                        class="btn btn-soft-main" id="togglePasswordsBtn">
                                        <span class="icon-eye">
                                            <!-- Eye SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path
                                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                            </svg>
                                        </span>

                                        <span class="icon-eye-off d-none">
                                            <!-- Eye-Off SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                                <path
                                                    d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                                <path d="M3 3l18 18" />
                                            </svg>
                                        </span>
                                    </button><!-- show / hide -->

                                    <button type="submit" class="btn btn-second  mb-0 px-5">
                                        {{ __('client.save') }}
                                    </button><!-- submit -->

                                </div><!-- buttons -->
                                <div class="clearfix"></div>

                            </x-panel-with-heading>

                        </form>


                    </div>


                </div>
            </div>
        </div>
    </section>



@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

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



            $('#togglePasswordsBtn').on('click', function() {

                const fields = [
                    $('input[name="current_password"]'),
                    $('input[name="password"]'),
                    $('input[name="password_confirmation"]')
                ];

                // Toggle field types
                fields.forEach(function(input) {
                    const type = input.attr('type');
                    input.attr('type', type === 'password' ? 'text' : 'password');
                });

                // Toggle icons
                $(this).find('.icon-eye').toggleClass('d-none');
                $(this).find('.icon-eye-off').toggleClass('d-none');
            });



        });
    </script>
@endsection

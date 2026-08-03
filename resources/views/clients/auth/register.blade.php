@extends('main.layouts.master')
@section('title', 'Register')
@section('content')

    <div class="half">

        <div class="contents ">
            <div class="container px-4 px-xl-0 ">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-7 col-lg-9 col-md-11 col-sm-9">



                        <div class="mb-3">
                            <a href="{{ appUrl('') }}">
                                <img style="width: 64px;" src="{{ website_logo() }}" alt="">
                            </a>
                        </div>


                        <h3 class="text-black">
                            {!! __('client.register.title', [
                                'app' => '<a href="' . appUrl('') . '" ><strong class="text-black">' . e(__('main.app_name')) . '</strong></a>',
                            ]) !!}
                        </h3>

                        <p class="mb-4">{{ __('client.register.description') }}</p>

                        <form
                            action="{{ route('main.clients.register.index') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                            method="POST">
                            @csrf


                            <x-form-group :properties="[
                                'input' => [
                                    'type' => 'text',
                                    'name' => 'name',
                                    'options' => [
                                        'required',
                                        'maxlength' => 45,
                                        'placeholder' => __('client.register.form.name_placeholder'),
                                    ],
                                ],
                                'label' => [
                                    'text' => __('client.register.form.name'),
                                ],
                            ]" /><!-- name -->


                            <x-form-group :properties="[
                                'input' => [
                                    'type' => 'email',
                                    'name' => 'email',
                                    'options' => ['maxlength' => 150, 'placeholder' => 'name@example.com'],
                                ],
                                'label' => [
                                    'text' => __('client.register.form.email'),
                                ],
                            ]" /><!-- email -->


                            <div class="form-row">
                                <div class="col-12">
                                    <label for="">{{ __('client.register.form.phone') }}</label>
                                </div>

                                <div class="col-xl-3 col-md-4 col-5">
                                    <div class="input-flags">
                                        <select name="country_code" class="country-select">
                                            @foreach ($globalPhoneData['countries'] as $country)
                                                <option @selected(old('country_code') == $country['code']) value="{{ $country['code'] }}"
                                                    data-flag="{{ $country['flag'] }}">
                                                    {{ $country['code'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- country_code -->


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
                                </div><!-- phone -->

                            </div><!-- phone + code -->

                            <x-form-group class="mb-0"
                                :properties="[
                                    'input' => [
                                        'type' => 'password',
                                        'name' => 'password',
                                        'options' => ['required', 'maxlength' => 60],
                                    ],
                                    'label' => [
                                        'text' => __('client.register.form.password'),
                                    ],
                                ]" /><!-- password , 'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$'-->
                            <small class="text-muted">{{ __('client.register.form.password_help') }}</small>



                            <button type="submit"
                                class="btn btn-main btn-block mt-3">{{ __('client.register.form.submit') }}</button>
                        </form>


                        <hr style="border-top: 1px solid rgba(0, 0, 0, 0.050);">

                        <a href="{{ appUrl('login') }}"
                            class="btn btn-soft-main btn-block">{{ __('client.register.form.have_account') }}</a>



                    </div><!-- col -->
                </div><!-- row -->
            </div><!-- container -->
        </div><!-- contents -->

        <div class="bg" style="background-image: url({{ asset('assets/images/register-bg.jpg') }});"></div>

    </div>

@endsection

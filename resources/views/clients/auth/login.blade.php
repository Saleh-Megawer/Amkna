@extends('main.layouts.master')
@section('title', 'Login')
@section('content')


    <div class="d-lg-flex half">

        <div class="contents">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">


                        @if (session()->has('error_login'))
                            <div class="alert alert-danger text-center font-weight-300 mb-4 mt-0" role="alert">
                                @php $err = session('error_login'); @endphp

                                @if (is_array($err))
                                    {!! implode('<br>', array_map('e', $err)) !!}
                                @else
                                    {{ $err }}
                                @endif
                            </div>
                        @endif


                        @if (session('success'))
                            <div class="alert alert-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-rosette-discount-check">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7c.412 .41 .97 .64 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1c0 .58 .23 1.138 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1" />
                                    <path d="M9 12l2 2l4 -4" />
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-info">
                                {{ session('status') }}
                            </div>
                        @endif



                        <div class="mb-3">
                            <a href="{{ appUrl('') }}">
                                <img style="width: 64px;" src="{{ website_logo() }}" alt="">
                            </a>
                        </div>


                        <h3 class="text-black">
                            {!! __('client.login.title', [
                                'app' => '<a href="' . appUrl('') . '"><strong class="text-black">' . e(__('main.app_name')) . '</strong></a>',
                            ]) !!}
                        </h3>

                        <p class="mb-4">{{ __('client.login.description') }}</p>

                        <form
                            action="{{ route('main.clients.login.attempt') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                            method="post">
                            @csrf

                            <x-form-group :properties="[
                                'input' => [
                                    'type' => 'text',
                                    'name' => 'login',
                                    'options' => ['required'],
                                ],
                                'label' => [
                                    'text' => __('client.login.form.phone_or_email'),
                                ],
                            ]" /><!-- login -->


                            <x-form-group :properties="[
                                'input' => [
                                    'type' => 'password',
                                    'name' => 'password',
                                    'options' => ['required'],
                                ],
                                'label' => [
                                    'text' => __('client.login.form.password'),
                                ],
                            ]" /><!-- password -->


                            <div class="my-3 text- center">
                                <a href="{{ route('main.clients.password.request') }}"
                                    class="forgot-pass font-weight-600">{{ __('client.login.form.forgot') }}</a>
                            </div>

                            <button type="submit"
                                class="btn btn-main btn-block">{{ __('client.login.form.submit') }}</button>

                        </form>

                        <hr style="border-top: 1px solid rgba(0, 0, 0, 0.050);">

                        <a href="{{ appUrl('register') }}" class="btn btn-soft-main btn-block">
                            {{ __('client.login.form.new_to', ['app' => __('main.app_name')]) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg " style="background-image: url({{ asset('assets/images/login-bg.png') }});"></div>

    </div>


@endsection
